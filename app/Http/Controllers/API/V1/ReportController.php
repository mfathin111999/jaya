<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Report\Application\ReportManagement;
use App\Domain\Engagement\Application\EngagementManagement;
use App\Domain\Report\Factories\ReportFactory;
use PDF;

class ReportController extends Controller
{
    protected $report;
    protected $engagement;

    public function __construct(ReportManagement $report, EngagementManagement $engagement){
        $this->report = $report;
        $this->engagement = $engagement;
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

    public function getCount($id){
        $data = $this->report->getByEngagement($id);

        return apiResponseBuilder(200, $data, 'Checked');
    }

    public function getByIdEngagement($id)
    {
        $data = $this->report->getByIdEngagement($id);

        return apiResponseBuilder(200, ReportFactory::call($data), 'Success');
    }

    public function addPrice(Request $request)
    {
        $data = $this->report->price($request);

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
        // $data = [
        //     'engagement' => 'kuy'
        // ];

        $pdf = PDF::loadView('export/engagement', $data);  
        return $pdf->stream('engagement.pdf', array('Attachment' => false));
        // return $pdf->download('engagement.pdf');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
