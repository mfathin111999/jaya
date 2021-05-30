<?php

namespace App\Domain\Employee\Application;

use App\Domain\Employee\Entities\Vendor;
use App\Domain\Employee\Entities\Employee;
use App\Domain\Employee\Entities\EmployeeHasWork;
use App\Domain\User\Entities\User;
use App\Shared\Uploader;

class EmployeeManagement
{

	protected $upload;

	public function __construct(Uploader $upload){
		$this->upload = $upload;
	}

	public function allData(){
		$data = Employee::all();

		return $data;
	}

	public function allBusiness(){
		$data = Vendor::with('user')->get();

		return $data;
	}

	public function allVendor(){
		$data = Vendor::where('vendor', 'yes')->get();

		return $data;
	}

	public function storeEmployee($request){
		$image = $this->upload->uploadImage($request->picture);

		$data = Employee::create([
			'name' 				=> $request->name,
			'phone_number' 		=> $request->phone_number,
			'status' 			=> $request->status,
			'address' 			=> $request->address,
			'ktp' 				=> $request->ktp,
			'picture'			=> $image,
			'village_id'		=> $request->village_id,
			'district_id'		=> $request->district_id,
			'regency_id'		=> $request->regency_id,
			'province_id'		=> $request->province_id,
		]);

		return $data;
	}

	public function storeVendor($request){
		$data = new Vendor;

		$data->name 				= $request->name ?? null;
		$data->email 				= $request->email ?? null;
		$data->tax_id				= $request->tax_id ?? null;
		$data->phone_number			= $request->phone_number ?? null;
		$data->search_key 			= $request->search_key ?? null;
		$data->customer 			= $request->customer ?? null;
		$data->vendor 				= $request->vendor ?? null;
		$data->bank_name 			= $request->bank_name ?? null;
		$data->bank_account_name	= $request->bank_account_name ?? null;
		$data->bank_account_number	= $request->bank_account_number ?? null;
		$data->owner				= $request->owner ?? null;
		$data->address				= $request->address ?? null;
		$data->ktp					= $request->ktp ?? null;

		$data->save();

		return $data;
	}

	public function updateEmployee($id, $request){
		$data = Employee::find($id);
		
		$data->name 		= $request->name;
		$data->address 		= $request->address;
		$data->ktp			= $request->ktp;
		$data->phone_number	= $request->phone_number;
		if ($request->has('picture')) {
			$this->upload->deleteImage($data->picture);
			$data->picture 		= $this->upload->uploadImage($request->file('picture'));
		}
		$data->village_id 	= $request->village_id;
		$data->district_id 	= $request->district_id;
		$data->regency_id 	= $request->regency_id;
		$data->province_id 	= $request->province_id;
		$data->status 		= $request->status;

		$data->save();

		return $data;
	}

	public function updateVendor($id, $request){
		$data = Vendor::find($id);
		
		$data->name 				= $request->name ?? null;
		$data->email 				= $request->email ?? null;
		$data->tax_id				= $request->tax_id ?? null;
		$data->phone_number			= $request->phone_number ?? null;
		$data->search_key 			= $request->search_key ?? null;
		$data->customer 			= $request->customer ?? null;
		$data->vendor 				= $request->vendor ?? null;
		$data->bank_name 			= $request->bank_name ?? null;
		$data->bank_account_name	= $request->bank_account_name ?? null;
		$data->bank_account_number	= $request->bank_account_number ?? null;
		$data->owner				= $request->owner ?? null;
		$data->address				= $request->address ?? null;
		$data->ktp					= $request->ktp ?? null;

		$data->save();

		return $data;
	}

	public function view($id){
		$data = Employee::find($id);

		$data->picture = asset('storage/'.$data->picture);

		return $data;
	}

	public function viewVendor($id){
		$data = Vendor::find($id);

		return $data;
	}

	public function delete($id){
		$data = Employee::find($id);

		$this->upload->deleteImage($data->picture);

		$data->delete();

		return $data;
	}

	public function deleteVendor($id){
		$data = Vendor::find($id);

		$data->delete();

		return $data;
	}
}