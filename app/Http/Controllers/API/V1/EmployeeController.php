<?php

namespace App\Http\Controllers\API\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\User\Entities\User;
use App\Domain\Employee\Entities\Vendor;
use App\Domain\Employee\Entities\Employee;
use App\Domain\Engagement\Entities\Engagement;
use App\Domain\Employee\Entities\EmployeeHasWork;
use App\Domain\Employee\Factories\EmployeeFactory;
use App\Domain\Employee\Application\EmployeeManagement;

use File;
use Storage;
use PDF;

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

    public function getProgress(Request $request)
    {
        $data = User::select('id', 'name')
        ->when(auth()->guard('api')->user()->role == 5, function ($query) {
          $query->where('id', auth()->guard('api')->user()->id);
        })
        ->where('role', 5)
        ->whereHas('vendorEngage', function($query) use ($request) {
            $query->where('status', 'acc')
                  ->where('locked', 'deal')
                  ->whereHas('termin', function($query){
                    $query->where('status', 'doneCustomer');
                  })
                  ->when($request->has('month') && $request->month != 'all', function($query) use ($request) {
                    $query->whereMonth('date', $request->month);
                  })
                  ->when($request->has('year') && $request->year != 'all', function($query) use ($request) {
                    $query->whereYear('date', $request->year);
                  });
        })
        ->with(['vendorEngage' => function($query) use ($request) {
            $query->where('status', 'acc')
                  ->where('locked', 'deal')
                  ->when($request->has('month') && $request->month != 'all', function($query) use ($request) {
                    $query->whereMonth('date', $request->month);
                  })
                  ->whereHas('termin', function($query){
                    $query->where('status', 'doneCustomer');             
                  })
                  ->when($request->has('year') && $request->year != 'all', function($query) use ($request) {
                    $query->whereYear('date', $request->year);
                  })
                  ->with(['service', 'vendor', 'termin' => function ($query) {
                    $query->where('status', 'doneCustomer')
                          ->with(['report' => function($query){
                            $query->whereNull('parent_id')
                                  ->with(['subreport' => function($query){
                                      $query->orderBy('id', 'desc');
                                  }]);
                          }]);
                  }]);
        }])
        ->withCount(['vendorEngage' => function($query) use ($request){
            $query->where('status', 'acc')
                  ->where('locked', 'deal')
                  ->whereHas('termin', function($query){
                    $query->where('status', 'doneCustomer');             
                  })
                  ->when($request->has('month') && $request->month != 'all', function($query) use ($request) {
                    $query->whereMonth('date', $request->month);
                  })
                  ->when($request->has('year') && $request->year != 'all', function($query) use ($request) {
                    $query->whereYear('date', $request->year);
                  });
        }])
        ->get();

        return apiResponseBuilder(200, EmployeeFactory::call($data));
        // return apiResponseBuilder(200);
    }

    public function getPayment(Request $request)
    {
        $data = User::select('id', 'name')
        ->when(auth()->guard('api')->user()->role == 5, function ($query) {
          $query->where('id', auth()->guard('api')->user()->id);
        })
        ->where('role', 5)
        ->whereHas('vendorEngage', function($query) use ($request) {
            $query->where('status', 'acc')
                  ->where('locked', 'deal')
                  ->whereHas('termin', function($query){
                    $query->where('status', 'donePayed');             
                  })
                  ->when($request->has('month') && $request->month != 'all', function($query) use ($request) {
                    $query->whereMonth('date', $request->month);
                  })
                  ->when($request->has('year') && $request->year != 'all', function($query) use ($request) {
                    $query->whereYear('date', $request->year);
                  });
        })
        ->with(['vendorEngage' => function($query) use ($request) {
            $query->where('status', 'acc')
                  ->where('locked', 'deal')
                  ->whereHas('termin', function($query){
                    $query->where('status', 'donePayed');             
                  })
                  ->when($request->has('month') && $request->month != 'all', function($query) use ($request) {
                    $query->whereMonth('date', $request->month);
                  })
                  ->when($request->has('year') && $request->year != 'all', function($query) use ($request) {
                    $query->whereYear('date', $request->year);
                  })
                  ->with(['service', 'vendor', 'termin' => function($query){
                    $query->where('status', 'donePayed')
                          ->with(['report' => function($query){
                              $query->whereNull('parent_id')
                                ->with(['subreport' => function($query){
                                  $query->orderBy('id', 'desc');
                                }]);
                          }])->with(['payment' => function($query){
                              $query->where('status', 'success')
                                    ->orWhere('status', 'settlement');
                          }]);
                  }]);
        }])
        ->withCount(['vendorEngage' => function($query) use ($request){
            $query->where('status', 'acc')
                  ->where('locked', 'deal')
                  ->whereHas('termin', function($query){
                    $query->where('status', 'donePayed');             
                  })
                  ->when($request->has('month') && $request->month != 'all', function($query) use ($request) {
                    $query->whereMonth('date', $request->month);
                  })
                  ->when($request->has('year') && $request->year != 'all', function($query) use ($request) {
                    $query->whereYear('date', $request->year);
                  });
        }])
        ->get();

        return apiResponseBuilder(200, EmployeeFactory::call($data));
        // return apiResponseBuilder(200);
    }

    public function getProgressCustomer(Request $request)
    {
        $data = User::select('id', 'name')
        ->where('role', 4)
        ->whereHas('engageCustomer', function($query) use ($request) {
            $query->where('status', 'acc')
                  ->where('locked', 'deal')
                  ->whereHas('termin', function($query){
                    $query->whereNull('status');
                  })
                  ->when($request->has('month') && $request->month != 'all', function($query) use ($request) {
                    $query->whereMonth('date', $request->month);
                  })
                  ->when($request->has('year') && $request->year != 'all', function($query) use ($request) {
                    $query->whereYear('date', $request->year);
                  });
        })
        ->with(['engageCustomer' => function($query) use ($request) {
            $query->where('status', 'acc')
                  ->where('locked', 'deal')
                  ->whereHas('termin', function($query){
                    $query->whereNull('status');
                  })
                  ->when($request->has('month') && $request->month != 'all', function($query) use ($request) {
                    $query->whereMonth('date', $request->month);
                  })
                  ->when($request->has('year') && $request->year != 'all', function($query) use ($request) {
                    $query->whereYear('date', $request->year);
                  })
                  ->with(['service', 'termin' => function ($query) {
                    $query->whereNull('status')
                          ->with(['report' => function($query){
                              $query->whereNull('parent_id')
                                    ->with(['subreport' => function($query){
                                        $query->orderBy('id', 'desc');
                                    }]);
                          }])
                          ->with(['payment' => function($query){
                              $query->where('status', 'success')
                                    ->orWhere('status', 'settlement');
                          }]);
                  }]);
        }])
        ->withCount(['engageCustomer' => function($query) use ($request){
            $query->where('status', 'acc')
                  ->where('locked', 'deal')
                  ->whereHas('termin', function($query){
                    $query->whereNull('status');
                  })
                  ->when($request->has('month') && $request->month != 'all', function($query) use ($request) {
                    $query->whereMonth('date', $request->month);
                  })
                  ->when($request->has('year') && $request->year != 'all', function($query) use ($request) {
                    $query->whereYear('date', $request->year);
                  });
        }])
        ->get();

        return apiResponseBuilder(200, EmployeeFactory::callPartner($data));
        // return $request;
    }

    public function getPaymentCustomer(Request $request)
    {
        $data = User::select('id', 'name')
        ->when(auth()->guard('api')->user()->role == 4, function ($query) {
          $query->where('id', auth()->guard('api')->user()->id);
        })
        ->where('role', 4)
        ->whereHas('engageCustomer', function($query) use ($request) {
            $query->where('status', 'acc')
                  ->where('locked', 'deal')
                  ->whereHas('termin', function($query){
                    $query->where('status', 'doneCustomer')
                          ->orWhere('status', 'donePayed');             
                  })
                  ->when($request->has('month') && $request->month != 'all', function($query) use ($request) {
                    $query->whereMonth('date', $request->month);
                  })
                  ->when($request->has('year') && $request->year != 'all', function($query) use ($request) {
                    $query->whereYear('date', $request->year);
                  });
        })
        ->with(['engageCustomer' => function($query) use ($request) {
            $query->where('status', 'acc')
                  ->where('locked', 'deal')
                  ->whereHas('termin', function($query){
                    $query->where('status', 'doneCustomer')
                          ->orWhere('status', 'donePayed');             
                  })
                  ->when($request->has('month') && $request->month != 'all', function($query) use ($request) {
                    $query->whereMonth('date', $request->month);
                  })
                  ->when($request->has('year') && $request->year != 'all', function($query) use ($request) {
                    $query->whereYear('date', $request->year);
                  })
                  ->with(['service', 'vendor', 'termin' => function($query){
                    $query->where('status', 'doneCustomer')
                          ->orWhere('status', 'donePayed')
                          ->with(['payment' => function($query){
                            $query->where('status', 'success')
                                  ->orWhere('status', 'settlement');
                          }])
                          ->with(['report' => function($query){
                            $query->whereNull('parent_id')
                                  ->with(['subreport' => function($query){
                                    $query->orderBy('id', 'desc');
                                  }]);
                          }]);
                  }]);
        }])
        ->withCount(['engageCustomer' => function($query) use ($request){
            $query->where('status', 'acc')
                  ->where('locked', 'deal')
                  ->whereHas('termin', function($query){
                    $query->where('status', 'doneCustomer')
                          ->orWhere('status', 'donePayed');             
                  })
                  ->when($request->has('month') && $request->month != 'all', function($query) use ($request) {
                    $query->whereMonth('date', $request->month);
                  })
                  ->when($request->has('year') && $request->year != 'all', function($query) use ($request) {
                    $query->whereYear('date', $request->year);
                  });
        }])
        ->get();

        return apiResponseBuilder(200, EmployeeFactory::callPartner($data));
        // return apiResponseBuilder(200, $data);
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

    public function createPartner(Request $request)
    {
        $data = Vendor::firstOrNew(['user_id' => $request['user_id']]);

        $data->user_id  = $request['user_id'];
        $data->ktp      = $request['ktp'];
        $data->customer = 'yes';

        $data->save();

        $reservation = Engagement::find($request['reservation_id']);

        $reservation->pvillage_id   = $request['village_id'];
        $reservation->pdistrict_id  = $request['district_id'];
        $reservation->pregency_id   = $request['regency_id'];
        $reservation->pprovince_id  = $request['province_id'];
        $reservation->paddress      = $request['paddress'];

        $reservation->save();

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
        $data = [];

        $path = public_path().'/public/pdf';

        if (!file_exists($path))
          File::makeDirectory($path, $mode = 0755, true, true);

        $pdf = PDF::loadView('export/test', $data);

        $content = $pdf->download()->getOriginalContent();

        Storage::put('public/pdf/name.pdf',$content) ;
    }
}
