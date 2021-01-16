<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Resource\Application\ResourceManagement;

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
        $data = $this->resource->allData();

        return response()->json([
            'status'    => 200,
            'data'      => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createStep(Request $request)
    {
        $data = $this->resource->storeStep($request);

        return response()->json([
            'status'    => 200,
            'data'      => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createResource(Request $request)
    {
        $data = $this->resource->storeResource($request);

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
    public function updateStep(Request $request, $id)
    {
        $data = $this->resource->updateStep($id, $request);

        return response()->json([
            'status'    => 200,
            'data'      => $data,
        ]);        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateResource(Request $request, $id)
    {
        $data = $this->resource->updateResource($id, $request);

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
}
