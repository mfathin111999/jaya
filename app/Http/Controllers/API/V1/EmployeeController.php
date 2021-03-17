<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Employee\Application\EmployeeManagement;

class EmployeeController extends Controller
{

    protected $employee;

    public function __construct(EmployeeManagement $employee){
        $this->employee = $employee;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->employee->allData();

        return apiResponseBuilder(200, $data);
    }

    public function allBusiness()
    {
        $data = $this->employee->allBusiness();

        return apiResponseBuilder(200, $data);
    }

    public function allVendor()
    {
        $data = $this->employee->allVendor();

        return apiResponseBuilder(200, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createEmployee(Request $request)
    {
        $data = $this->employee->storeEmployee($request);

        return apiResponseBuilder(200, $data);
    }

    public function createVendor(Request $request)
    {
        $data = $this->employee->storeVendor($request);

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
        $data = $this->employee->view($id);

        return apiResponseBuilder(200, $data);
    }

    public function viewVendor($id)
    {
        $data = $this->employee->viewVendor($id);

        return apiResponseBuilder(200, $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateEmployee(Request $request, $id)
    {
        $data = $this->employee->updateEmployee($id, $request);

        return apiResponseBuilder(200, $data);
    }

    public function updateVendor(Request $request, $id)
    {
        $data = $this->employee->updateVendor($id, $request);

        return apiResponseBuilder(200, $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->employee->delete($id);

        return apiResponseBuilder(200, $data);
    }

    public function destroyVendor($id)
    {
        $data = $this->employee->deleteVendor($id);

        return apiResponseBuilder(200, $data);
    }

    public function test(Request $request)
    {
        $data = [$request['name'], $request['email'], $request['phone_number'], $request['province_id'], $request['regency_id'], $request['district_id'], $request['address'], $request['date'], $request['time'], $request['service'], $request['description']];

        return apiResponseBuilder(200, $data);
    }
}
