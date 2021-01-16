<?php

namespace App\Domain\Reservation\Application;

use App\Domain\Reservation\Entities\Reservation;

class ReservationManagement
{
	public function allData(){
		$data = Reservation::all();

		return $data;
	}

	public function storeReservation($request){
		$data = Reservation::create([
			'' 			=> $request->,
			'' 			=> $request->,
			'' 	=> $request->,
			''			=> $request->,
			''			=> $request->,
			''			=> $request->,
			''		=> $request->,
			''		=> $request->,
			''			=> $request->,
			''		=> $request->,
		]);

		return $data;
	}

	public function updateReservation($id, $request){
		$data = Reservation::find($id);

		$data-> 		= $request->;
		$data-> 		= $request->;
		$data-> 	= $request->;
		$data-> 		= $request->;
		$data-> 		= $request->;
		$data-> 		= $request->;
		$data-> 		= $request->;
		$data-> 		= $request->;
		$data-> 		= $request->;
		$data-> 	= $request->;

		$data->save();

		return $data;
	}

	public function view($id){
		$data = Reservation::find($id);

		return $data;
	}

	public function delete($id){
		$data = Reservation::find($id)->delete();

		return $data;
	}
}