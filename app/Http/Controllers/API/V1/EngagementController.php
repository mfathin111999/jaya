<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Engagement\Application\EngagementManagement;
use App\Domain\Engagement\Factories\EngagementFactory;

class EngagementController extends Controller
{

    protected $engagement;

    public function __construct(EngagementManagement $engagement){
        $this->engagement = $engagement;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->engagement->allData();

        return apiResponseBuilder(200, EngagementFactory::allFactory($data));
    }

    public function indexSurveyer(Request $request)
    {
        $data = $this->engagement->allData($request);

        return apiResponseBuilder(200, EngagementFactory::allFactory($data));
    }

    public function indexMandor(Request $request)
    {
        $data = $this->engagement->allDataMandor($request);

        return apiResponseBuilder(200, EngagementFactory::allFactory($data));
        // return $data;
    }

    public function getCalendarData()
    {
        $data = $this->engagement->getCalendarData();

        return apiResponseBuilder(200, EngagementFactory::calendarFactory($data));
    }

    public function getCalendarDataSurveyer(Request $request)
    {
        $data = $this->engagement->getCalendarDataSurveyer($request);

        return apiResponseBuilder(200, EngagementFactory::calendarFactory($data->engagement));
        // return apiResponseBuilder(200, $request->id);
    }

    public function getCalendarDataMandor(Request $request)
    {
        $data = $this->engagement->getCalendarDataMandor($request);

        return apiResponseBuilder(200, EngagementFactory::calendarFactory($data->engage));
        // return apiResponseBuilder(200, $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createEngagement(Request $request)
    {
        $data = $this->engagement->storeEngagement($request);

        return apiResponseBuilder(200, $data, 'Engagement has been created');

    }

    /**
     * For acc the engagement
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function action(Request $request)
    {
        $data = $this->engagement->actionEngagement($request['id'], $request['employee'], $request['action']);

        return apiResponseBuilder(200, $data);
    }

    /**
     * For ignore the engagement
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ignore(Request $request)
    {
        $data = $this->engagement->actionEngagement($request->id, 'ignore');

        return apiResponseBuilder(200, $data);
    }

    /**
     * For finish the engagement
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function finish(Request $request)
    {
        $data = $this->engagement->actionEngagement($request->id, 'finish');

        return apiResponseBuilder(200, $data);
    }

    /**
     * For finish the engagement
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dealed($id)
    {
        $data = $this->engagement->deal($id);

        return apiResponseBuilder(200, $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $data = $this->engagement->view($id);

        return apiResponseBuilder(200, EngagementFactory::viewFactory($data));
    }

    public function getByCode($code)
    {
        $data = $this->engagement->getByCode($code);

        return apiResponseBuilder(200, EngagementFactory::viewFactory($data));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAvailableDate()
    {
        $data = $this->engagement->getDate();

        return apiResponseBuilder(200, $data);

    }

    public function addVendor(Request $request)
    {
        $data = $this->engagement->addVendor($request);

        return apiResponseBuilder(200, $data, 'Success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->engagement->delete($id);

        return apiResponseBuilder(200, $data, 'Engagement has been deleted');
    }
}
