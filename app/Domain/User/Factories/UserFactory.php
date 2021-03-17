<?php

namespace App\Domain\User\Factories;

class UserFactory
{
	public static function call($item){
        $data = [
                'id'                => $item->id,
                'name'              => $item->name,
                'phone'             => $item->phone,
                'email'             => $item->email,
                'address'           => empty($item->address) ? '' : $item->address,
                'village_id'        => empty($item->village_id) ? '' : $item->village_id,
                'district_id'       => empty($item->district_id) ? '' : $item->district_id,
                'regency_id'        => empty($item->regency_id) ? '' : $item->regency_id,
                'province_id'       => empty($item->province_id) ? '' : $item->province_id,
                'village'           => empty($item->village->name) ? '' : $item->village->name,
                'district'          => empty($item->district->name) ? '' : $item->district->name,
                'regency'           => empty($item->regency->name) ? '' : $item->regency->name,
                'province'          => empty($item->province->name) ? '' : $item->province->name,
                'role'              => $item->role,
                'access_token'      => $item->access_token,
            ];
        return $data;
    }
}