<?php

namespace App\Domain\Engagement\Application;

use App\Domain\Engagement\Entities\Engagement;
use App\Domain\Service\Entities\Service;
use App\Domain\Engagement\Entities\EngagementHasEmployee;
use App\Domain\Engagement\Service\GetCode;
use App\Domain\Engagement\Service\GetResource;

class EngagementManagement
{
	protected $getCode;

	public function __construct(GetCode $getCode, GetResource $getResource){
		$this->getCode = $getCode;
		$this->getResource = $getResource;
	}

	public function allData(){
		$data = Engagement::with('province', 'regency', 'district', 'village', 'service')->get();

		return $data;
	}

	public function getCalendarData(){
		$data = Engagement::where('status', '!=', 'ignore')->with('province', 'regency', 'district', 'village', 'service')->get();

		return $data;
	}

	public function storeEngagement($request){
		$code = $this->getCode->createCode();

		$data = Engagement::create([
			'code' 				=> $code,
			'user_id' 			=> $request['user_id'] ?? null,
			'name'				=> $request['name'],
			'email'				=> $request['email'],
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

		return $data;
	}

	public function actionEngagement($id, $employee = [], $type = 'acc'){
		$data = Engagement::find($id);

		$data->status = $type;

		$data->save();

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

	public function getByCode($code){
		$data = Engagement::with('province', 'regency', 'district', 'village', 'service')->where('code', $code)->first();

		return $data;
	}

	public function delete($id){
		$data = Engagement::find($id);

		$data->service()->sync([]);

		$data->delete();

		return $data;
	}
}