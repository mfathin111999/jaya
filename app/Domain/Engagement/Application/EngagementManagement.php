<?php

namespace App\Domain\Engagement\Application;

use App\Domain\Engagement\Entities\Engagement;
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
		$data = Engagement::with('province', 'regency', 'district', 'village')->get();

		return $data;
	}

	public function storeEngagement($request){
		$code = $this->getCode->createCode();

		$data = Engagement::create([
			'code' 				=> $code,
			'user_id' 			=> $request['user_id'] ?? null,
			'name'				=> $request['name'],
			'email'				=> $request['email'],
			'village_id'		=> $request['village_id'],
			'district_id'		=> $request['district_id'],
			'regency_id'		=> $request['regency_id'],
			'provincy_id'		=> $request['provincy_id'],
			'date'				=> $request['date'],
			'time'				=> $request['time'],
			'description'		=> $request['description'],
			'phone_number'		=> $request['phone_number'],
		]);

		$service = array_map(function($a){
            return ['service_id' => $a];
        }, $request['service']);

		$data->service()->createMany(
			$service
		);

		return $data;
	}

	public function actionEngagement($id, $type = 'acc'){
		$data = Engagement::find($id);

		$data->status = $type;

		$data->save();

		return $data;
	}

	public function getDate(){
		$data = $this->getResource->getAvailableDate();

		return $data;
	}

	public function view($id){
		$data = Engagement::find($id);

		return $data;
	}

	public function delete($id){
		$data = Engagement::find($id)->delete();

		return $data;
	}
}