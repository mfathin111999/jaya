<?php

namespace App\Domain\Report\Application;

use App\Domain\Report\Entities\Report;
use App\Domain\Engagement\Entities\EngagementGalleries;
use App\Domain\Report\Entities\ReportGalleries;
use App\Domain\Engagement\Entities\Engagement;
use App\Domain\Payment\Entities\Termin;
use App\Domain\Employee\Entities\Vendor;
use App\Models\Village;
use App\Models\District;
use App\Models\Regency;
use App\Models\Province;
use App\Shared\Uploader;

class ReportManagement
{
	protected $upload;

	public function __construct(Uploader $upload){
		$this->upload = $upload;
	}

	public function getByIdEngagement($id){
		$engagement = Engagement::where('id', $id)
					->when(auth()->guard('api')->user()->role == 1, function ($query){
						$query->with('termin');
					})
					->with(['user.partner', 'gallery', 'pprovince', 'pdistrict', 'pregency', 'pvillage', 'vendor', 'report' => function($query){
						$query->whereNull('parent_id')
							  ->when(auth()->guard('api')->user()->role == 1, function ($query){
									$query->with('termin');
								})
							  ->when(auth()->guard('api')->user()->role == 5, function ($query){
									$query->with(['termins.payment' => function ($query) {
										$query->where('payment_log.status', 'success')->orWhere('payment_log.status', 'settlement');
									}]);
								})
							  ->when(auth()->guard('api')->user()->role == 4, function ($query){
									$query->with('termin');
								})
							  ->with(['subreport' => function($query){
									$query->orderBy('id', 'asc');
								}]);
						}])
					->first();

		return $engagement;
	}

	public function call($request){
		$array = [];
		$datas = json_decode($request['data']);
		foreach ($datas as $key) {
			$data 	= new Report;
		 	$data->reservation_id 	= $request['id'];
		 	$data->name 			= $key->name_part;

		 	$data->save();
		 	$array[] 				= $key;

		 	foreach ($key->detail as $value) {
				$data2 	= new Report;
		 		$data2->reservation_id 	= $request['id'];
		 		$data2->parent_id 		= $data->id;
		 		$data2->name 			= $value->name_point;
		 		$data2->volume			= $value->volume;
		 		$data2->unit			= $value->unit;

		 		$data2->save();
		 		$array[] = $value;

		 	}
		}

		$partner 	= json_decode($request['partner']);
		$check		= Vendor::where('ktp', $partner->ktp)->first();
		if ($check == null) {
			$vendor  				= new Vendor;
			$search_key 			= explode(" ", $partner->name);

			$vendor->name 			= $partner->name; 
			$vendor->phone_number 	= $partner->phone_number; 
			$vendor->email 			= $partner->email; 
			$vendor->address 		= $partner->address; 
			$vendor->ktp 			= $partner->ktp; 
			$vendor->province_id 	= $partner->province_id; 
			$vendor->regency_id 	= $partner->regency_id; 
			$vendor->district_id 	= $partner->district_id; 
			$vendor->village_id 	= $partner->village_id; 
			$vendor->customer 		= 'yes';
			$vendor->vendor 		= 'no';
			$vendor->search_key 	= strtolower($search_key[0]);

			$vendor->save();

			$engagement = Engagement::find($request['id']);
			$engagement->partner_id = $vendor->id;
			$engagement->save();
		}else {
			$check->province_id 	= $partner->province_id; 
			$check->regency_id 		= $partner->regency_id; 
			$check->district_id 	= $partner->district_id; 
			$check->village_id 		= $partner->village_id; 

			$check->save();

			$engagement = Engagement::find($request['id']);
			$engagement->partner_id = $check->id;
			$engagement->save();
		}
		

		$images = [];
		
		foreach ($request['image'] as $key2) {
			$images[] = ['reservation_id' => $request['id'], 'image' => $this->upload->uploadImage($key2)];
		}

		$galleries = EngagementGalleries::insert($images);

		return $array;
	}

	public function getByEngagement($id){
		$data = Report::where('reservation_id', $id)->get()->count();

		return $data;
	}

	public function getByIdReport($id){
		$data = Report::where('id', $id)->with('subreport')->first();

		return $data;
	}

	public function getByIdReportStep($id){
		$data = Report::where('id', $id)->with('gallery', 'subreport')->first();

		return $data;
	}

	public function date($request){
		$data = Engagement::where('id', $request['id'])->first();

		$data->date_work 		= $request['date'];

		$data->save();

		return $data;
	}

	public function price($request){
		$data = Report::where('id', $request->id)->first();

		$data->price_clean 	= $request->price_clean;
		$data->price_dirt 	= $request->price_dirt;
		// $data->status 		= 'deal';

		$data->save();

		return $data;
	}

	public function store($request){
		$data = new Report;

		if ($request['type'] == 'step') {
			$data->reservation_id 	= $request['reservation_id'];
			$data->name 			= $request['name'];

			$data->save();

			return $data;

		}elseif ($request['type'] == 'detail') {

			$data->reservation_id 	= $request['reservation_id'];
			$data->parent_id 		= $request['step_id'];
			$data->name 			= $request['name'];
			$data->price_clean 		= $request->has('price_clean') ? $request['price_clean'] : null;
			$data->price_dirt 		= $request->has('price_dirt') ? $request['price_dirt'] :null;
			$data->volume 			= $request['volume'];
			$data->description 		= $request['description'];
			$data->unit 			= $request['unit'];
			$data->time 			= $request['time'];
			$data->start 			= $request['start'];
			$data->end 				= $request['end'];

			$data->save();

			return $data;
		}
	}

	public function updateReport($request){
		$data = Report::where('id', $request['id'])->first();

		$data->name 		= $request['name'] ?? $data->name;
		$data->price_clean 	= $request['price_clean'] ?? $data->price_clean;
		$data->price_dirt 	= $request['price_dirt'] ?? $data->price_dirt;
		$data->volume 		= $request['volume'] ?? $data->volume;
		$data->description 	= $request['description'] ?? $data->description;
		$data->unit 		= $request['unit'] ?? $data->unit;
		$data->time 		= $request['time'] ?? $data->time;
		$data->start 		= $request['start'] ?? $data->start;
		$data->end 			= $request['end'] ?? $data->end;

		$data->save();

		return $data;
	}

	public function termin($request){
		$data = Report::where('id', $request->id)->first();
		// $check = Termin::where('reservation_id', $data->reservation_id)->where('termin', $request->termin)->first();

		// if ($check == null) {
		// 	if ($request->has('persentase')) {
		// 		$all = 0;
		// 		$check2 = Report::where('reservation_id', $data->reservation_id)->whereNotNull('parent_id')->get();
		// 		foreach ($check2 as $key) {
		// 			 $key->price_clean += $all;
		// 		}

		// 		$termin = new Termin;
		// 		$termin->reservation_id = $data->reservation_id;
		// 		$termin->termin 		= $data->termin;
		// 		$termin->total 			= $request->persentase ? (int)$all/(int)$request->persentase : $request->total;
		// 		$termin->persentase 	= $request->persentase ?? null;

		// 		$termin->save();
		// 	}else{
		// 		$all = 0;
		// 		$check2 = Report::where('reservation_id', $data->reservation_id)->where('parent_id', $request->id)->get();
		// 		foreach ($check2 as $key) {
		// 			(int) $key->price_clean += $all;
		// 		}

		// 		$termin = new Termin;
		// 		$termin->reservation_id = $data->reservation_id;
		// 		$termin->termin 		= $data->termin;
		// 		$termin->total 			= $all;
		// 		$termin->persentase 	= $request->persentase ?? null;

		// 		$termin->save();
		// 	}
		// }

		$data->status 		= 'deal';
		$data->termin 		= $request->termin;

		$data->save();

		return $data;
	}

	public function delete($id){
		$data = Report::find($id)->delete();

		return $data;
	}

	public function view($id){
		$data = Engagement::where('id', $id)->with('report', 'gallery')->get();

		return $data;
	}

}