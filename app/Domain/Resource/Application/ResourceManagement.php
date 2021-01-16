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

	public function allData(){
		$data = Resource::all();

		return $data;
	}

	public function storeStep($request){
		$data = Resource::create([
			'name' 			=> $request->name,
			'type' 			=> $request->type,
			'type_service' 	=> $request->type_service,
			'description' 	=> $request->description,
		]);

		return $data;
	}

	public function storeResource($request){
		$data = Resource::create([
			'name' 			=> $request->name,
			'type' 			=> $request->type,
			'description' 	=> $request->description,
			'price'			=> $request->price ?? null,
			'unit'			=> $request->unit ?? null,
			'width'			=> $request->width ?? null,
			'length'		=> $request->length ?? null,
			'height'		=> $request->height ?? null,
			'color'			=> $request->color ?? null,
			'material'		=> $request->material ?? null,
		]);

		return $data;
	}

	public function updateResource($id, $request){
		$data = Resource::find($id);

		$data->name 		= $request->name;
		$data->type 		= $request->type;
		$data->description 	= $request->description;
		$data->price 		= $request->price ?? null;
		$data->unit 		= $request->unit ?? null;
		$data->width 		= $request->width ?? null;
		$data->length 		= $request->length ?? null;
		$data->height 		= $request->height ?? null;
		$data->color 		= $request->color ?? null;
		$data->material 	= $request->material ?? null;

		$data->save();

		return $data;
	}

	public function updateStep($id, $request){
		$data = Resource::find($id);
		
		$data->name 		= $request->name;
		$data->type 		= $request->type;
		$data->type_service	= $request->type_service;
		$data->description 	= $request->description;

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
		$data = Province::orderBy('name')->get();

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