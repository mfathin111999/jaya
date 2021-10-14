<?php

namespace App\Domain\Resource\Application;

use App\Domain\Resource\Entities\Resource;
use App\Models\Village;
use App\Models\District;
use App\Models\Regency;
use App\Models\Province;

class ResourceManagement
{
	public function __construct(){

	}

	public function allResource(){
		$data = Resource::all();

		$unit = [];

		foreach ($data as $key) {
			if ($key->type == 'unit') {
				$unit[] = $key;
			}
		}

		return compact('unit');
	}

	public function allUnit(){
		$data = Resource::where('type', 'unit')->get();

		return $data;
	}

	public function createUnit($request){
		$data = new Resource;

		$data->type 	= 'unit';
		$data->name 	= $request->name;
		$data->data1 	= $request->data1;
		$data->data2	= $request->data2;

		$data->save();

		return $data;
	}

	public function updateUnit($id, $request){
		$data = Resource::find($id);

		$data->name 	= $request->name;
		$data->data1 	= $request->data1;
		$data->data2 	= $request->data2;

		$data->save();

		return $data;
	}

	public function view($id){
		$data = Resource::find($id);

		return $data;
	}

	public function delete($id){
		$data = Resource::find($id)->delete();

		return $data;
	}

	public function getProvince(){
		$data = Province::all();

		return $data;
	}

	public function getRegency($provinceId = 0){
		if ($provinceId != 0) {
			$data = Regency::where('province_id', $provinceId)->orderBy('name')->get();
		}else{
			$data = Regency::orderBy('name')->get();			
		}

		return $data;
	}

	public function getDistrict($regencyId = 0){
		if ($regencyId != 0) {
			$data = District::where('regency_id', $regencyId)->orderBy('name')->get();
		}else{
			$data = District::orderBy('name')->get();			
		}

		return $data;
	}

	public function getVillage($districtId = 0){
		if ($districtId != 0) {
			$data = Village::where('district_id', $districtId)->orderBy('name')->get();			
		}else{
			$data = Village::orderBy('name')->get();
		}

		return $data;
	}

}