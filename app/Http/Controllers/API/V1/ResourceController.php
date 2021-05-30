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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createUnit(Request $request)
    {
        $data = $this->resource->createUnit($request);

        return response()->json([
            'status'    => 200,
            'data'      => $data,
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateUnit(Request $request, $id)
    {
        $data = $this->resource->updateUnit($id, $request);

        return response()->json([
            'status'    => 200,
            'data'      => $data,
        ]);        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $data = $this->resource->view($id);

        return response()->json([
            'status'    => 200,
            'data'      => $data,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
