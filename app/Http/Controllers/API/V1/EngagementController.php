<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Engagement\Entities\Engagement;
use App\Domain\Engagement\Application\EngagementManagement;
use App\Domain\Engagement\Factories\EngagementFactory;

class EngagementController extends Controller
{

    protected $engagement;

    public function __construct(EngagementManagement $engagement){
        $this->engagement = $engagement;
    }

    
    // GET DATA ENGAGEMENT BY ROLE

    public function index()
    {
        $data = Engagement::when(auth()->guard('api')->role == 2, function ($query) {
                    $query->whereHas('employee', function ($query){
                        $query->where('id', auth()->guard('api')->id);
                    });
                })
                ->when(auth()->guard('api')->role == 5, function ($query) {
                    $query->where('mandor_id', auth()->guard('api')->id);
                })
                ->with('province', 'regency', 'district', 'village', 'service')
                ->withCount('report')
                ->orderBy('date')->get();

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

    public function indexVendor(Request $request)
    {
        $data = Engagement::where('vendor_id', $request->id)
                            ->when($request->has('filter') && $request->filter == 'finish', function ($query) use ($request){
                                $query->where('status', 'finish');
                            })
                            ->when($request->has('filter') && $request->filter != 'finish', function ($query) use ($request){
                                $query->where('locked', $request->filter);
                            })
                            ->with(['regency', 'service', 'report' => function($query){
                                $query->whereNull('parent_id')->with(['subreport' => function($query){
                                    $query->orderBy('id', 'desc');
                                }]);
                            }])->orderBy('date', 'desc')->get();
        $count = $data->count();

        return apiResponseBuilder(200, EngagementFactory::vendorFactory($data), $count);
        // return $data;
    }

    public function indexCustomer()
    {
        $data = Engagement::whereHas('user', function($query) {
                $query->where('user_id', auth()->guard('api')->user()->id);
            })->with('province', 'regency', 'district', 'village', 'service')->withCount('report')->get();

        return apiResponseBuilder(200, EngagementFactory::allFactory($data));
    }

    // GET CALENDAR

    public function getCalendarData(Request $request)
    {
        $data = $this->engagement->getCalendarData($request);

        return EngagementFactory::calendarFactory($data);
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

    // STORE METHOD

    public function createEngagement(Request $request)
    {
        $data = $this->engagement->storeEngagement($request);

        return apiResponseBuilder(200, $data, 'Engagement has been created');

    }

    public function addVendor(Request $request)
    {
        $data = $this->engagement->addVendor($request);

        return apiResponseBuilder(200, $data, 'Success');
    }

    // GET METHOD

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

    public function getProgress()
    {
        $data = $this->engagement->getProgress();

        return apiResponseBuilder(200, $data);
    }

    public function getAvailableDate()
    {
        $data = $this->engagement->getDate();

        return apiResponseBuilder(200, $data);

    }

    public function accVendor($id, Request $request)
    {
        if ($request['type'] == 'not') {
            $data = $this->engagement->notVendor($id);
        }else if ($request['type'] == 'acc') {
            $data = $this->engagement->accVendor($id);
        }
        return apiResponseBuilder(200, $data);

    }

    public function accCustomer($id, Request $request)
    {
        $data = $this->engagement->accCustomer($id);

        return redirect()->route('action');

    }

    // ACTION METHOD

    public function action(Request $request)
    {
        if (auth()->guard('api')->user()->role != 1)
            return apiResponseBuilder(403, 'Unauthorized', 'Unsuccessfully');

        $data = $this->engagement->actionEngagement($request['id'], $request['employee'], $request['action'], $request['reason']);


        return apiResponseBuilder(200, $data);
    }

    public function ignore(Request $request)
    {
        $data = $this->engagement->actionEngagement($request->id, 'ignore');

        return apiResponseBuilder(200, $data);
    }

    public function finish(Request $request)
    {
        $data = $this->engagement->actionEngagement($request->id, 'finish');

        return apiResponseBuilder(200, $data);
    }

    public function dealed($id)
    {
        $data = $this->engagement->deal($id);

        return apiResponseBuilder(200, $data);
    }

    public function destroy($id)
    {
        $data = $this->engagement->delete($id);

        return apiResponseBuilder(200, $data, 'Engagement has been deleted');
    }
}
