<?php

namespace App\Domain\Report\Application;

use App\Domain\Report\Entities\Report;
use App\Models\Village;
use App\Models\District;
use App\Models\Regency;
use App\Models\Province;

class ReportManagement
{
	public function __construct(){

	}

	public function call($request){
		$array = [];
		foreach ($request['data'] as $key) {
			$data 	= new Report;
			$data2 	= new Report;
		 	$data->reservation_id = $request['id'];
		 	$data->name = $key['name_part'];

		 	$data->save();
		 	$array[] = $data;

		 	foreach ($key['detail'] as $value) {
		 		$data2->reservation_id 	= $request['id'];
		 		$data2->parent_id 		= $data->id;
		 		$data2->name 			= $value['name_point'];
		 		$data2->volume			= $value['volume'];
		 		$data2->unit			= $value['unit'];

		 		$data2->save();
		 		$array[] = $data2;

		 	}
		}

		return $array;
	}

	public function getByEngagement($id){
		$data = Report::where('reservation_id', $id)->count();

		return $data;
	}

	public function delete($id){
		$data = Report::find($id)->delete();

		return $data;
	}

}