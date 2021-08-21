<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Resource\Application\ResourceManagement;
use App\Domain\Engagement\Entities\Engagement;
use App\Domain\Resource\Entities\Reason;

class ResourceController extends Controller
{

    protected $resource;

    public function __construct(ResourceManagement $resource){
        $this->resource = $resource;
    }

    public function index()
    {
        $data = $this->resource->allResource();

        return response()->json([
            'status'    => 200,
            'data'      => $data['unit'],
        ]);
    }

    public function allUnit()
    {
        $data = $this->resource->allUnit();

        return response()->json([
            'status'    => 200,
            'data'      => $data,
        ]);
    }

    public function getDisableDate(){
        $data = Engagement::where('date', '>', date('Y-m-d'))->pluck('date');

        return apiResponseBuilder(200, $data);
    }

    public function createUnit(Request $request)
    {
        $data = $this->resource->createUnit($request);

        return response()->json([
            'status'    => 200,
            'data'      => $data,
        ]);
    }

    public function updateUnit(Request $request, $id)
    {
        $data = $this->resource->updateUnit($id, $request);

        return response()->json([
            'status'    => 200,
            'data'      => $data,
        ]);        
    }

    public function view($id)
    {
        $data = $this->resource->view($id);

        return response()->json([
            'status'    => 200,
            'data'      => $data,
        ]);
    }

    public function destroy($id)
    {
        $data = $this->resource->delete($id);

        return response()->json([
            'status'    => 200,
            'data'      => $data,
        ]);
    }

    public function getProvince()
    {
        $data = $this->resource->getProvince();

        return response()->json([
            'status'    => 200,
            'data'      => $data,
        ]);
    }

    public function getMaterialDashboard()
    {
        if (auth()->guard('api')->user()->role == 4) {
            return apiResponseBuilder(403, '', 'Unauthorize');
        }

        $data_finish    = self::dataMaterial('finish');
        $finish         = $data_finish['count'];
        $benefit        = $data_finish['price'];
        $all            = self::dataMaterial('all');
        $do             = self::dataMaterial('do');
        $ignore         = self::dataMaterial('ignore');
        $all_benefit    = self::dataMaterial('benefit');
        $chart          = [$ignore, $do, $finish];

        $datas = compact('all', 'finish', 'do', 'ignore', 'benefit', 'all_benefit', 'chart');

        return apiResponseBuilder(200, $datas, 'oke');

    }
    

    public function dataMaterial($request)
    {
        $data = Engagement::when(auth()->guard('api')->user()->role == 2, function($query){
                            $query->whereHas('employee', function ($query){
                                $query->where('users.id', auth()->guard('api')->user()->id);
                            });
                        })
                        ->when(auth()->guard('api')->user()->role == 3, function($query){
                            $query->where('mandor_id', auth()->guard('api')->user()->id);
                        })
                        ->when(auth()->guard('api')->user()->role == 5, function($query){
                            $query->where('vendor_id', auth()->guard('api')->user()->id);
                        })
                        ->whereMonth('date', 7);

        if ($request == 'all') {
            $data   = $data->count();
        }elseif($request == 'finish'){

            $data   = $data->where('status', 'finish')->with('report', function($query){
                        $query->select(['id', 'reservation_id', 'price_clean', 'price_dirt', 'volume'])->whereNotNull('parent_id');
                    })->get();

            $count = 0;

            if (auth()->guard('api')->user()->role == 1) {
                if($data->count() != 0){
                    foreach ($data as $items) {
                        foreach ($items->report as $item){
                            $count += (($item->price_dirt*$item->volume) - ($item->price_clean*$item->volume));       
                        }
                    }
                }
            }else{
                if($data->count() != 0){
                    foreach ($data as $items) {
                        foreach ($items->report as $item){
                            $count += $item->price_clean*$item->volume;       
                        }
                    }
                }
            }
            

            $datas = [
                'price' => $count,
                'count' => $data->count()
            ];

            return $datas;

        }elseif($request == 'do'){
            $data   = $data->where([['status', '!=', 'finish'], ['status', '!=', 'ignore']])->count();
        }elseif($request == 'ignore'){
            $data   = $data->where('status', 'ignore')->count();
        }elseif($request == 'benefit'){
            $data   = $data->select('id', 'code')->where('status', 'acc')->orWhere('status', 'finish')->with('report', function($query){
                    $query->select(['id', 'reservation_id', 'price_clean', 'price_dirt'])->whereNotNull('parent_id');
            })->get();

            $count = 0; 
            if (auth()->guard('api')->user()->role == 1) {
                if($data->count() != 0){
                    foreach ($data as $items) {
                        foreach ($items->report as $item){
                            $count += (($item->price_dirt*$item->volume) - ($item->price_clean*$item->volume));       
                        }
                    }
                }
            }else{
                if($data->count() != 0){
                    foreach ($data as $items) {
                        foreach ($items->report as $item){
                            $count += $item->price_clean*$item->volume;       
                        }
                    }
                }
            }

            return $count;
        }

        return $data;
    }

    public function getRegency(Request $request)
    {
        if ($request->has('id')) {
            $data = $this->resource->getRegency($request->id);
        }else{
            $data = $this->resource->getRegency();
        }

        return response()->json([
            'status'    => 200,
            'data'      => $data,
        ]);
    }

    public function getDistrict(Request $request)
    {
        if ($request->has('id')) {
            $data = $this->resource->getDistrict($request->id);
        }else{
            $data = $this->resource->getDistrict();
        }

        return response()->json([
            'status'    => 200,
            'data'      => $data,
        ]);
    }

    public function getVillage(Request $request)
    {
        if ($request->has('id')) {
            $data = $this->resource->getVillage($request->id);
        }else{
            $data = $this->resource->getVillage();
        }

        return response()->json([
            'status'    => 200,
            'data'      => $data,
        ]);
    }

    public function getReason(Request $request)
    {
        $data = Reason::all();

        return apiResponseBuilder(200, $data);
    }

    public function viewReason(Request $request)
    {
        $data = Reason::find($request->id);

        if (auth()->guard('api')->user()->role != 1) {
            return apiResponseBuilder(404, 'unauthorize');
        }

        return apiResponseBuilder(200, $data);
    }

    public function storeReason(Request $request)
    {
        $data = new Reason;

        $data->reason = $request->reason;

        $data->save();

        if (auth()->guard('api')->user()->role != 1) {
            return apiResponseBuilder(404, 'unauthorize');
        }

        return apiResponseBuilder(200, $data, 'success');
    }

    public function updateReason(Request $request)
    {
        $data = Reason::find($request->id);

        $data->reason = $request->reason;

        $data->save();

        if (auth()->guard('api')->user()->role != 1) {
            return apiResponseBuilder(404, 'unauthorize');
        }

        return apiResponseBuilder(200, $data, 'success');
    }

    public function destroyReason(Request $request)
    {
        $data = Reason::find($request->id)->delete();

        if (auth()->guard('api')->user()->role != 1) {
            return apiResponseBuilder(404, 'unauthorize');
        }

        return apiResponseBuilder(200, $data, 'success');
    }
}
