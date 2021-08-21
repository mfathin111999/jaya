<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Engagement\Entities\Engagement;
use App\Domain\Engagement\Application\EngagementManagement;
use App\Domain\Engagement\Factories\EngagementFactory;
use Illuminate\Support\Facades\Auth;

class EngagementController extends Controller
{

    protected $engagement;

    public function __construct(EngagementManagement $engagement){
        $this->engagement = $engagement;
    }

    
    // GET DATA ENGAGEMENT BY ROLE

    public function index(Request $request)
    {
        if (auth()->user()->role == 4 || auth()->user()->role == 3) {
            return apiResponseBuilder(403, [], 'unauthorize');
        }
        
        $data = Engagement::when(auth()->guard('api')->user()->role == 2, function ($query) {
                    $query->whereHas('employee', function ($query){
                        $query->where('users.id', auth()->guard('api')->user()->id);
                    });
                })
                ->when(auth()->guard('api')->user()->role == 5, function ($query) {
                    $query->where('mandor_id', auth()->guard('api')->user()->id);
                })
                ->when($request->has('filter') && $request->filter == 'finish', function ($query) use ($request){
                    $query->where('status', $request->filter);
                })
                ->when($request->has('filter') && $request->filter == 'pending', function ($query) use ($request){
                    $query->where('status', $request->filter);
                })
                ->when($request->has('filter') && $request->filter == 'ignore', function ($query) use ($request){
                    $query->where('status', $request->filter);
                })
                ->when($request->has('filter') && $request->filter == 'post_offer', function ($query) use ($request){
                    $query->where('locked', 'offer')->where('status', 'acc')->whereHas('report');
                })
                ->when($request->has('filter') && $request->filter == 'offer', function ($query) use ($request){
                    $query->where('locked', 'offer')->where('status', 'acc')->whereDoesntHave('report');
                })
                ->when($request->has('filter') && $request->filter == 'deal', function ($query) use ($request){
                    $query->where('locked', 'deal')->where('status', 'acc');
                })
                ->with('province', 'regency', 'district', 'village', 'service')
                ->withCount('report')
                ->when($request->has('order'), function ($query) use ($request){
                    $query->orderBy('date', $request->order)->orderBy('status');
                })
                ->get();

        $response = [
            'data' => EngagementFactory::allFactory($data),
            'count' => $data->count()
        ];

        return apiResponseBuilder(200, $response);
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
                            ->when($request->has('order'), function ($query) use ($request){
                                $query->orderBy('date', $request->order);
                            })
                            ->with(['regency', 'service', 'report' => function($query){
                                $query->whereNull('parent_id')->with(['subreport' => function($query){
                                    $query->orderBy('id', 'desc');
                                }]);
                            }])
                            ->get();
        $count = $data->count();

        return apiResponseBuilder(200, EngagementFactory::vendorFactory($data), $count);
        // return $data;
    }

    public function indexCustomer(Request $request)
    {

        $data = Engagement::whereHas('user', function($query) {
                    $query->where('user_id', auth()->guard('api')->user()->id);
                })
                ->when(auth()->guard('api')->user()->role == 5, function ($query) {
                    $query->where('mandor_id', auth()->guard('api')->user()->id);
                })
                ->when($request->has('filter') && $request->filter == 'finish', function ($query) use ($request){
                    $query->where('status', $request->filter);
                })
                ->when($request->has('filter') && $request->filter == 'pending', function ($query) use ($request){
                    $query->where('status', $request->filter);
                })
                ->when($request->has('filter') && $request->filter == 'ignore', function ($query) use ($request){
                    $query->where('status', $request->filter)->with('reason');
                })
                ->when($request->has('filter') && $request->filter == 'post_offer', function ($query) use ($request){
                    $query->where('locked', 'offer')->where('status', 'acc')->whereHas('report');
                })
                ->when($request->has('filter') && $request->filter == 'offer', function ($query) use ($request){
                    $query->where('locked', 'offer')->where('status', 'acc')->whereDoesntHave('report');
                })
                ->when($request->has('filter') && $request->filter == 'deal', function ($query) use ($request){
                    $query->where('locked', 'deal')->where('status', 'acc');
                })
                ->when($request->has('order'), function ($query) use ($request){
                    $query->orderBy('date', $request->order)->orderBy('status');
                })
                ->with('province', 'regency', 'district', 'village', 'service')->get();

        $count = $data->count();

        $datas = [
            'data' => EngagementFactory::customerFactory($data),
            'count' => $count,
        ];

        return apiResponseBuilder(200, $datas);
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

        if (Auth::check()) {

            $data = Engagement::find($id);

            if (auth()->user()->id === $data->user_id ) {
                if ($data->vendor_is == 1) {
                    $data->locked = 'deal';
                    $data->mandor_id = 2;   
                }

                $data->customer_is = 1;

                $data->save();

                return redirect()->route('action');
            }else{
                return abort(401);
            }
        }else{
            return redirect()->route('login');
        }

    }

    public function checkOrder(Request $request){
        if (auth()->guard('api')->user()->role != 1 && auth()->guard('api')->user()->role != 4) {
            return abort(401);
        }

        if (auth()->guard('api')->user()->role == 1) {
            $data = Engagement::where('id', $request->id)
                    ->withCount(['report' => function($query){
                        $query->whereNull('parent_id')
                            ->whereHas('termin', function($query){
                                $query->whereNull('status');
                            });
                    }])
                    ->first();
        }else{
            $data = Engagement::where('user_id', auth()->guard('api')->user()->id)
                    ->where('id', $request->id)
                    ->withCount(['report' => function($query){
                        $query->whereNull('parent_id')
                            ->whereHas('termin', function($query){
                                $query->whereNull('status');
                            });
                    }])
                    ->first();
        }

        return apiResponseBuilder(200, $data->report_count);
    }


    public function completingOrder(Request $request){

        if (auth()->guard('api')->user()->role != 1 && auth()->guard('api')->user()->role != 4) {
            return abort(401);
        }

        if (auth()->guard('api')->user()->role == 1) {
            $data = Engagement::findOrFail($request->id);
        }else{
            $data = Engagement::where('user_id', auth()->guard('api')->user()->id)
                                ->where('id', $request->id)
                                ->firstOrFail();


        }

        $data->status = 'finish';
        $data->save();

        return apiResponseBuilder(200, "oke", "Berhasil");
    }

    public function recompletingOrder(Request $request){

        if (auth()->guard('api')->user()->role != 1) {
            return abort(401);
        }

        $data = Engagement::findOrFail($request->id);

        $data->status = 'acc';
        $data->save();

        return apiResponseBuilder(200, "oke", "Berhasil");
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
