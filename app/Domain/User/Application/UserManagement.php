<?php

namespace App\Domain\User\Application;

use App\Domain\User\Entities\User;

class UserManagement
{
	public function getAvailableEmployee(){
		$data = User::with(['reservation' => function($query){
			$query->where('status', '!=', 'finish');
		}])->get();

		return $data;
	}
}