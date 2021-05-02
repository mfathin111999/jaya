<?php

namespace App\Domain\Engagement\Application;

use App\Mail\AccMail;
use App\Mail\IgnoreMail;
use App\Mail\ThanksMail;
use App\Domain\User\Entities\User;
use App\Domain\Engagement\Entities\Engagement;
use App\Domain\Service\Entities\Service;
use App\Domain\Engagement\Entities\EngagementHasEmployee;
use App\Domain\Engagement\Service\GetCode;
use App\Domain\Engagement\Service\GetResource;
use Mail;

class EngagementManagement
{
	protected $getCode;

	public function __construct(GetCode $getCode, GetResource $getResource){
		$this->getCode = $getCode;
		$this->getResource = $getResource;
	}

	public function allData($request = null){
		if ($request == null || empty($request)) {		
			$data = Engagement::with('province', 'regency', 'district', 'village', 'service')->withCount('report')->get();
		}else {
			$id = $request->id;
			$data = Engagement::whereHas('employee', function($query) use ($id) {
				$query->where('user_id', $id);
			})->with('province', 'regency', 'district', 'village', 'service')->withCount('report')->get();
		}

		return $data;
	}

	public function allDataMandor($request){
		$data = Engagement::where('mandor_id', $request->id)->with('province', 'regency', 'district', 'village', 'service')->withCount('report')->get();

		return $data;
	}

	public function allDataVendor($request){
		$data = Engagement::where('vendor_id', $request->id)
							->where('status', '!=', 'finish')
							->with(['regency', 'service', 'report' => function($query){
								$query->whereNull('parent_id')->with(['subreport' => function($query){
									$query->orderBy('id', 'desc');
								}]);
							}])->get();

		return $data;
	}

	public function deal($id){
		$data = Engagement::where('id', $id)->first();

		$data->locked 	 = 'deal';
		$data->mandor_id = 2;

		$data->save();

		return $data;
	}

	public function getCalendarData(){
		$data = Engagement::where('status', '!=', 'ignore')->with('province', 'regency', 'district', 'village', 'service')->withCount('report')->get();

		return $data;
	}

	public function getCalendarDataSurveyer($request){
		$data = User::where('id', $request->id)
				->with(['engagement' => function($query){
					$query
						->where('status', '!=', 'ignore')
						->where('status', '!=', 'pending')
						->with('province', 'regency', 'district', 'village', 'service')->withCount('report');
				}])->first();

		return $data;
	}

	public function getCalendarDataMandor($request){
		$data = User::where('id', $request->id)
				->with(['engage' => function($query){
					$query
						->where('locked', 'deal')
						->with('province', 'regency', 'district', 'village', 'service')->withCount('report');
				}])->first();

		return $data;
	}

	public function storeEngagement($request){
		$code = $this->getCode->createCode();

		$data = Engagement::create([
			'code' 				=> $code,
			'user_id' 			=> auth()->guard('api')->user()->id,
			'name'				=> $request['name'],
			'email'				=> auth()->guard('api')->user()->email,
			'address'			=> $request['address'],
			'village_id'		=> $request['village_id'],
			'district_id'		=> $request['district_id'],
			'regency_id'		=> $request['regency_id'],
			'province_id'		=> $request['province_id'],
			'date'				=> $request['date'],
			'time'				=> $request['time'],
			'description'		=> $request['description'],
			'phone_number'		=> $request['phone_number'],
		]);

		$data->service()->sync($request['service']);

		Mail::to($data->email)
        		->send(new ThanksMail($data));

		return $data;
	}

	public function actionEngagement($id, $employee = [], $type = 'acc'){
		$data = Engagement::find($id);

		$data->status = $type;

		$data->save();
		if ($type == 'acc') {
			Mail::to($data->email)
        		->send(new AccMail($data));
		}elseif ($type == 'ignore') {
			Mail::to($data->email)
        		->send(new IgnoreMail($data));
		}

		if ($employee != null) {
			$data->employee()->sync($employee);
		}

		return $data;
	}

	public function getDate(){
		$data = $this->getResource->getAvailableDate();

		return $data;
	}

	public function view($id){
		$data = Engagement::with('province', 'regency', 'district', 'village', 'service')->find($id);

		return $data;
	}

	public function getById($id){
		$engagement = Engagement::where('id', $id)
			->with(['province', 'regency', 'district', 'village', 'service', 'gallery', 'partner', 'vendor', 'report' => function($query){
				$query->whereNull('parent_id')->with(['subreport' => function($query){
					$query->orderBy('id', 'desc');
				}]);
			}])->first();

		return $engagement;
	}

	public function getProgress(){
		$engagement = Engagement::where('status', 'acc')->where('locked', 'deal')
			->with(['service', 'partner', 'vendor', 'report' => function($query){
					$query->whereNull('parent_id');
			}])->get();

		return $engagement;
	}
	public function getByCode($code){
		$data = Engagement::with('province', 'regency', 'district', 'village', 'service')->withCount('report')->where('code', $code)->first();

		return $data;
	}

	public function addVendor($request){
		$data = Engagement::where('id', $request['id'])->first();

		$data->vendor_id = $request['vendor'];
		$data->save();

		return $data;
	}

	public function accVendor($id){
		$data = Engagement::find($id);

		$data->vendor_is = 1;

		$data->save();

		return 'success';
	}

	public function accCustomer($id){
		$data = Engagement::find($id);

		$data->customer_is = 1;

		$data->save();

		return 'success';
	}

	public function notVendor($id){
		$data = Engagement::find($id);

		$data->vendor_is = 99;

		$data->save();

		return 'success';
	}

	public function notCustomer($id){
		$data = Engagement::find($id);

		$data->customer_is = 99;

		$data->save();

		return 'success';
	}

	public function delete($id){
		$data = Engagement::find($id);

		$data->service()->sync([]);

		$data->delete();

		return $data;
	}
}