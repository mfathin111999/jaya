<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Service\Application\ServiceManagement;

class ServiceController extends Controller
{

    protected $service;

    public function __construct(ServiceManagement $service){
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->service->allData();

        return apiResponseBuilder(200, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createService(Request $request)
    {
        $data = $this->service->storeService($request);

        return apiResponseBuilder(200, $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view($id)
    {
        $data = $this->service->view($id);

        return apiResponseBuilder(200, $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateService(Request $request, $id)
    {
        $data = $this->service->updateService($id, $request);

        return apiResponseBuilder(200, $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        if($request->has('type')){
            if ($request->type == 'visible') {
                $data = $this->service->visible($id);
            }
        }else{
            $data = $this->service->delete($id);
        }

        return apiResponseBuilder(200, $data);
    }
}
