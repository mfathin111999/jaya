<?php

namespace App\Domain\Engagement\Factories;

class EngagementFactory 
{
	public static function allFactory($items){
        $data = [];

        foreach ($items as $item) {
        $data[] = [
                'id'                => $item->id,
                'code'              => $item->code,
                'user_id'           => $item->user_id,
                'name'              => $item->name,
                'email'             => $item->email,
                'address'           => empty($item->address) ? '' : $item->address,
                'village_id'        => $item->village_id,
                'district_id'       => $item->district_id,
                'regency_id'        => $item->regency_id,
                'province_id'       => $item->province_id,
                'village'           => $item->village->name,
                'district'          => $item->district->name,
                'regency'           => $item->regency->name,
                'province'          => $item->province->name,
                'date'              => $item->date,
                'time'              => $item->time,
                'description'       => $item->description,
                'status'            => $item->status,
                'phone_number'      => $item->phone_number,
                'service'           => self::serviceFactory($item->service),
            ];
        }
        return $data;
    }

    public static function viewFactory($item){
        $data = [
                'id'                => $item->id,
                'code'              => $item->code,
                'user_id'           => $item->user_id,
                'name'              => $item->name,
                'email'             => $item->email,
                'address'           => empty($item->address) ? '' : $item->address,
                'village_id'        => $item->village_id,
                'district_id'       => $item->district_id,
                'regency_id'        => $item->regency_id,
                'province_id'       => $item->province_id,
                'village'           => $item->village->name,
                'district'          => $item->district->name,
                'regency'           => $item->regency->name,
                'province'          => $item->province->name,
                'date'              => $item->date,
                'time'              => $item->time,
                'description'       => $item->description,
                'status'            => $item->status,
                'phone_number'      => $item->phone_number,
                'service'           => self::serviceFactory($item->service),
            ];

        return $data;
    }

    public static function serviceFactory($item){
        $data = [];

        foreach ($item as $key) {
            $data[] = $key->name;
        }

        return implode(', ', $data);
    }

    public static function calendarFactory($item){
    	$data = [];
    	foreach ($item as $key) {
    		$data[] = [
    			'title' 			=> $key->code,
				'start' 			=> date('Y-m-d H:m', strtotime($key->date.' '. $key->time,)),
		      	'allDay' 			=> true,
		      	'backgroundColor' 	=> $key->status == 'pending' ? '#f56954' : '#007bff',
		      	'borderColor' 		=> $key->status == 'pending' ? '#f56954' : '#007bff',
    		]; 	
    	}

    	return $data;
    }
}