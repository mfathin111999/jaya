<?php

namespace App\Http\Controllers\API\V1;

use PDF;
use Mail;
use App\Mail\PayMail;
use App\Mail\SendEngage;
use App\Shared\Uploader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Payment\Entities\Termin;
use App\Domain\Report\Entities\Report;
use App\Domain\Report\Factories\ReportFactory;
use App\Domain\Engagement\Entities\Engagement;
use App\Domain\Report\Entities\ReportGalleries;
use App\Domain\Report\Application\ReportManagement;
use App\Domain\Engagement\Entities\EngagementGalleries;
use App\Domain\Engagement\Application\EngagementManagement;


class ReportController extends Controller
{
    protected $report;
    protected $engagement;
    protected $upload;

    public function __construct(ReportManagement $report, EngagementManagement $engagement, Uploader $upload){
        $this->report = $report;
        $this->engagement = $engagement;
        $this->upload = $upload;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $data = $this->report->call($request);

        return apiResponseBuilder(200, $data, 'Success');
    }

    public function store(Request $request)
    {
        $data = $this->report->store($request);

        return apiResponseBuilder(200, $data, 'Success');
    }

    public function delStep(Request $request)
    {
        $data = Report::find($request['id']);

        $subreport = Report::where('parent_id', $request->id)->delete();

        $data->delete();

        return apiResponseBuilder(200, $data, 'Success');
    }

    public function updateStep(Request $request)
    {
        $data = Report::find($request['id']);
        $data->name     = $request['name'];

        $data->save();

        return apiResponseBuilder(200, $data, 'Success');
    }

    public function getCount($id){
        $data = $this->report->getByEngagement($id);

        return apiResponseBuilder(200, $data, 'Checked');
    }

    public function getByIdEngagement($id)
    {
        $data = $this->report->getByIdEngagement($id);

        // return $data;

        if (auth()->guard('api')->user()->role == 4){
            if ($data->user_id !== auth()->guard('api')->user()->id){
                return apiResponseBuilder(403, 'Unauthorize');
            }
            else{
                $termin = Termin::where('reservation_id', $data->id)
                            ->with(['report' => function($query){
                                $query->whereNull('parent_id')->with(['subreport' => function($query){
                                    $query->orderBy('id', 'desc');
                                }]);
                            }])
                            ->with(['payment' => function($query){
                                $query->where('payment_log.status', 'success')->orWhere('payment_log.status', 'settlement');
                            }])->get();

                foreach($termin as $item){
                    foreach($item->report as $key => $report){
                        if ($key == 0) {
                            $item['report_all'] = $report->name;
                        }else{
                            $item['report_all'] = $report->name.', '.$item['report_all'];
                        }

                        foreach($report->subreport as $subreport){
                            $item['customer_price'] += $subreport->price_dirt;
                        }
                    }
                }
                $data = [
                    'data' => ReportFactory::call($data),
                    'termin' => $termin
                ];
                return apiResponseBuilder(200, $data);
            }
        }else{
            if (auth()->guard('api')->user()->role == 5) {
                if ($data->vendor_id !== auth()->guard('api')->user()->id){
                    return apiResponseBuilder(403, 'Unauthorize');
                }
                else{
                    $termins = Termin::where('reservation_id', $data->id)->get();
                    return apiResponseBuilder(200, ReportFactory::call($data), $termins);
                }
            }else{
                return apiResponseBuilder(200, ReportFactory::call($data), 'success');
            }
        }
    }

    public function engagementVendorAction($id){

        $engagement = Engagement::where('id', $id)
                    ->with(['user.partner', 'gallery', 'pprovince', 'pdistrict', 'pregency', 'pvillage', 'vendor', 'report' => function($query){
                        $query->whereNull('parent_id')
                                ->with(['termins.payment' => function ($query) {
                                    $query->where('payment_log.status', 'success')->orWhere('payment_log.status', 'settlement');
                                }])
                                ->with(['subreport' => function($query){
                                    $query->orderBy('id', 'asc');
                                }]);
                        }])
                    ->first();

        return apiResponseBuilder(200, $engagement);
    }

    public function addPrice(Request $request)
    {
        $data = $this->report->price($request);

        return apiResponseBuilder(200, $data, 'Success');
    }

    public function addDate(Request $request)
    {
        $data = $this->report->date($request);

        return apiResponseBuilder(200, $data, 'Success');
    }

    public function addImage(Request $request)
    {
        $data = new EngagementGalleries;

        $data->reservation_id   = $request['reservation_id'];
        $data->image            = $this->upload->uploadImage($request['image']);

        $data->save();

        return apiResponseBuilder(200, $data, 'Success');
    }

    public function delImage(Request $request)
    {
        $data = EngagementGalleries::find($request['id']);

        $this->upload->deleteImage($data->image);

        $data->delete();

        return apiResponseBuilder(200, $data, 'Success');
    }

    public function addTermin(Request $request)
    {
        $data = $this->report->termin($request);

        return apiResponseBuilder(200, $data, 'Success');
    }

    public function printPDF($id)
    {
        $data = $this->engagement->getById($id);

        $pdf = PDF::loadView('export/engagement', $data);  
        return $pdf->stream('Akad.pdf', array('Attachment' => false));
        // return $pdf->download('engagement.pdf');
    }

    public function printPDFCustomer($id)
    {
        $data = $this->engagement->getById($id);

        $pdf = PDF::loadView('export/customer', $data);  
        return $pdf->stream('Penawaran.pdf', array('Attachment' => false));
        // return $pdf->download('engagement.pdf');
    }

    public function sendPDFCustomer($id)
    {
        $datas = $this->engagement->getById($id);

        // $pdf = PDF::loadView('export/customer', compact('datas'));  
        // return $pdf->stream("Penawaran.pdf", array("Attachment" => false));

        Mail::to($datas->email)
             ->send(new SendEngage($datas));

        return redirect()->back();
    }

    public function printPDFVendor($id)
    {
        $datas = $this->engagement->getById($id);

        $pdf = PDF::loadView('export.customer', compact('datas'));
        return $pdf->stream('Penawaran.pdf', array('Attachment' => false));
        // return $pdf->download('engagement.pdf');
    }

    public function test($id)
    {
        $data = $this->engagement->getById($id);

        return view('export.customer', compact('data'));
    }

    public function getByIdReport($id){
        $data = $this->report->getByIdReport($id);

        return apiResponseBuilder(200, $data, 'success');
    }

    public function getByIdReportStep($id){
        $data = $this->report->getByIdReportStep($id);

        return apiResponseBuilder(200, $data, 'success');
    }

    public function updateReport(Request $request){
        $data = $this->report->updateReport($request);

        return apiResponseBuilder(200, $data, 'success');
    }

    public function setVendor($id, Request $request){
        $data = Report::find($id);

        $data->status = 'done';

        $data->save();

        return apiResponseBuilder(200, $data, 'oke');
    }

    public function setVendorAll(Request $request){
        $data = Report::find($request['id']);

        $data->status = 'done';

        $data->save();

        $images = [];

        foreach ($request['image'] as $key) {
            $images[] = ['report_id' => $request['id'], 'image' => $this->upload->uploadImage($key)];
        }

        $galleries = ReportGalleries::insert($images);

        return apiResponseBuilder(200, $data, 'oke');
    }

    public function mandorAction($id, Request $request){
        $data = Report::find($id);

        if ($request->action == 'acc') {
            $data->status = 'doneMandor';
        }elseif ($request->action == 'ignore') {
            $data->status = 'deal';
        }

        $data->save();

        return apiResponseBuilder(200, $data, 'oke');
    }

    public function addPay($id, Request $request){
        $data = Termin::where('id', $id)->first();

        $data->date_invoice         = $request->date;
        $data->document             = 'PAY/'.uniqid().'/'.date('m').'/'.date('Y');
        $data->status               = 'donePayed';

        $data->save();


        return $data;
    }

    public function destroy($id)
    {
        $data = $this->report->delete($id);

        return apiResponseBuilder(200, $data, 'success');
    }
}
