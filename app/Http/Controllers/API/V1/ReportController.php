<?php

namespace App\Http\Controllers\API\V1;

use PDF;
use Mail;
use Storage;
use Validator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Shared\Uploader;

use App\Domain\Payment\Entities\Termin;

use App\Domain\Engagement\Entities\Engagement;
use App\Domain\Engagement\Entities\EngagementGalleries;
use App\Domain\Engagement\Application\EngagementManagement;

use App\Domain\Report\Entities\Report;
use App\Domain\Report\Entities\ReportGalleries;
use App\Domain\Report\Factories\ReportFactory;
use App\Domain\Report\Application\ReportManagement;

use App\Mail\PayMail;
use App\Mail\SendEngage;
use App\Mail\SendEngageVendor;

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

        if (auth()->guard('api')->user()->role != 5) {
            return abort(403);
        }

        $data = Engagement::where('id', $id)
            ->with(['user.partner', 'gallery', 'pprovince', 'pdistrict', 'pregency', 'pvillage', 'vendor', 'termin' => function($query){
                    $query->with(['report' => function ($query){
                        $query->select(['id', 'reservation_id', 'name', 'status', 'termin'])
                          ->whereNull('parent_id')
                          ->with(['subreport' => function($query){
                                $query->select(['id', 'parent_id', 'name', 'unit', 'volume', 'price_clean', 'status', 'time', 'description'])
                                    ->orderBy('id', 'asc');
                            }]);
                    }])->orderby('termin', 'asc');
            }])
            ->first();

        $all_report = [];
        $reports    = [];
        $subreport  = [];

        $date       = $data->date_work;

        foreach ($data->termin as $keys => $items) {

            foreach ($items->report as $key => $report) {

                $price = 0; 
                $subreport  = [];

                foreach ($report->subreport as $sub) {

                    $status     = '';
                    $finish     = date('Y/m/d', strtotime($date.' +'.$sub->time.' day'));

                    if ($items->termin == 1) {
                        if ($key == 0 && $items->status == 'donePayed')
                            if ($sub->status == 'done')
                                $status = 'wait';
                            elseif ($sub->status == 'doneMandor')
                                $status = 'finish';
                            else
                                $status = 'active';
                        elseif($key != 0 && $items->status == 'donePayed' && $items->report[$key-1]->status == 'doneMandor')
                            if ($sub->status == 'done')
                                $status = 'wait';
                            elseif ($sub->status == 'doneMandor')
                                $status = 'finish';
                            else
                                $status = 'active';
                        else
                            $status = 'nonactive';
                    }else {
                        if ($data->termin[$keys-1]->status != 'donePayed') {
                            $status = 'nonactive';
                        }else{
                            if ($key == 0) {
                                if ($data->termin[$keys-1]->report->last()->status == "doneMandor")
                                    if ($sub->status == 'done')
                                        $status = 'wait';
                                    elseif ($sub->status == 'doneMandor')
                                        $status = 'finish';
                                    else
                                        $status = 'active';
                                else
                                    $status = 'nonactive';
                            }else{
                                if ($items->report[$key-1]->status == "doneMandor")
                                    if ($sub->status == 'done')
                                        $status = 'wait';
                                    elseif ($sub->status == 'doneMandor')
                                        $status = 'finish';
                                    else
                                        $status = 'active';
                                else
                                    $status = 'nonactive';
                            }
                        }
                    }
                    
                    $subreport[] = [
                        'id'            => $sub->id,
                        'name'          => $sub->name,
                        'unit'          => $sub->unit,
                        'volume'        => $sub->volume,
                        'price_clean'   => $sub->price_clean,
                        'status'        => $sub->status,
                        'status_action' => $status,
                        'time'          => $sub->time,
                        'deadline'      => $finish,
                        'description'   => $sub->description,
                    ];

                    $price  += $sub->price_clean * $sub->volume;

                    $date   = $finish;
                }

                if ($items->termin == 1) {
                    if ($key == 0 && $items->status == 'donePayed')
                        if ($report->status == 'done')
                            $status = 'wait';
                        elseif ($report->status == 'doneMandor')
                            $status = 'finish';
                        else
                            $status = 'active';
                    elseif($key != 0 && $items->status == 'donePayed' && $items->report[$key-1]->status == 'doneMandor')
                        if ($report->status == 'done')
                            $status = 'wait';
                        elseif ($report->status == 'doneMandor')
                            $status = 'finish';
                        else
                            $status = 'active';
                    else
                        $status = 'nonactive';
                }else {
                    if ($data->termin[$keys-1]->status != 'donePayed') {
                        $status = 'nonactive';
                    }else{
                        if ($key == 0) {
                            if ($data->termin[$keys-1]->report->last()->status == "doneMandor")
                                if ($report->status == 'done')
                                    $status = 'wait';
                                elseif ($report->status == 'doneMandor')
                                    $status = 'finish';
                                else
                                    $status = 'active';
                            else
                                $status = 'nonactive';
                        }else{
                            if ($items->report[$key-1]->status == "doneMandor")
                                if ($report->status == 'done')
                                    $status = 'wait';
                                elseif ($report->status == 'doneMandor')
                                    $status = 'finish';
                                else
                                    $status = 'active';
                            else
                                $status = 'nonactive';
                        }
                    }
                }

                $reports[] = [
                    'id'                => $report->id,
                    'name'              => $report->name,
                    'status'            => $status,
                    'price'             => $price,
                    'detail'            => $subreport,
                ];
            }
        }

        $send = [
            'id'            => $data->id,
            'code'          => $data->code,
            'name'          => $data->name,
            'email'         => $data->email,
            'phone_number'  => $data->phone_number,
            'date'          => $data->date,
            'date_work'     => $data->date_work,
            'time'          => $data->time,
            'vendor'        => $data->vendor->name,
            'pprovince'     => $data->pprovince ?? '-',
            'pregency'      => $data->pregency ?? '-',
            'pdistrict'     => $data->pdistrict ?? '-',
            'pvillage'      => $data->pvillage ?? '-',
            'paddress'      => $data->paddress ?? '-',
            'status'        => $data->status,
            'report'        => $reports,
            'gallery'       => ReportFactory::gallery($data->gallery),
            'partner'       => $data->user->partner,
        ];

        return apiResponseBuilder(200, $send);

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


    public function printPDFVendor($id)
    {
        $datas = $this->engagement->getById($id);

        $pdf = PDF::loadView('export/vendor', compact('datas'));

        return $pdf->stream("Surat Penunjukan Rekanan.pdf", array("Attachment" => false));

        // return apiResponseBuilder(200, $datas);
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

        $child = Report::where('parent_id', $data->id)->update(['status' => 'done']);

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
            $child = Report::where('parent_id', $data->id)->update(['status' => 'doneMandor']);

        }elseif ($request->action == 'ignore') {
            $data->status = 'deal';
            $child = Report::where('parent_id', $data->id)->update(['status' => 'deal']);
        }

        $data->save();

        return apiResponseBuilder(200, $data, 'oke');
    }

    public function addPay($id, Request $request){

        $validator = Validator::make($request->all(), [
            'pic'           => 'required',
            'date'          => 'required',
            'image'         => 'required|file',
        ]);

        if($validator->fails()){
            return apiResponseBuilder(422, $validator->errors(), 'Lengkapi Inputan');
        }

        $data = Termin::where('id', $id)->first();

        $data->pic                  = $request['pic'];
        $data->date_invoice         = $request['date'];
        $data->document             = 'PAY/'.uniqid().'/'.date('m').'/'.date('Y');
        $data->image                = $this->upload->uploadImage($request['image']);
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
