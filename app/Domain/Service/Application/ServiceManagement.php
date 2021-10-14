<?php

namespace App\Domain\Service\Application;

use App\Domain\Service\Entities\Service;

class ServiceManagement
{

	public function allData(){
		$data = Service::all();

		return $data;
	}

	public function storeService($request){
		$data = Service::create([
			'name' 			=> $request->name,
			'description' 	=> $request->description,
		]);

		return $data;
	}

	public function updateService($id, $request){
		$data = Service::find($id);

		$data->name 		= $request->name;
		$data->description 	= $request->description;
		$data->save();

		return $data;
	}

	public function view($id){
		$data = Service::find($id);

		return $data;
	}

	public function visible($id){
		$data = Service::find($id);

		if ($data->active == 1) {
			$data->active = 0;
		}else{
			$data->active = 1;
		}

		$data->save();

		return $data;
	}

	public function delete($id){
		$data = Service::find($id)->delete();

		return $data;
	}
}