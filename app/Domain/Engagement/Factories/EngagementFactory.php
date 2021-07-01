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
                'locked'            => $item->locked,
                'phone_number'      => $item->phone_number,
                'customer_is'       => $item->customer_is,
                'vendor_is'         => $item->vendor_is,
                'service'           => self::serviceFactory($item->service),
                'count'             => $item->report_count,
                'created_at'        => Date('Y-m-d', strtotime($item->created_at))
            ];
        }
        return $data;
    }

    public static function vendorFactory($items){
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
                'locked'            => $item->locked,
                'vendor_is'         => $item->vendor_is,
                'phone_number'      => $item->phone_number,
                'service'           => self::serviceFactory($item->service),
                'price'             => self::allPrice($item->report),
            ];
        }
        return $data;
    }

    public static function allPrice($item){
        $price = 0;
 
        foreach ($item as $key) {
            foreach ($key->subreport as $value) {
                $price += $value->price_clean*$value->volume;
            }
        }

        return $price;
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
                'customer_is'       => $item->customer_is,
                'vendor_is'         => $item->vendor_is,
                'service'           => self::serviceFactory($item->service),
                'created_at'        => Date('Y-m-d', strtotime($item->created_at))
            ];

        if (isset($item->report_count)) {
            $data['report_count'] = $item->report_count;
        }

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
        $color = '';
    	foreach ($item as $key) {
            if ($key->status == 'pending') {
                $color = '#f56954';
            }elseif($key->status == 'offer'){
                $color = '#ffc107';
            }elseif($key->status == 'acc'){
                if ($key->locked == 'deal') {
                    $color = '#64bd63';
                }elseif($key->locked == 'offer'){
                    $color = '#17a2b8';
                }
            }
    		$data[] = [
    			'title' 			=> $key->code,
				'start' 			=> date('Y-m-d H:m', strtotime($key->date.' '. $key->time,)),
		      	'allDay' 			=> true,
                // 'backgroundColor'   => $key->status == 'pending' 
                //                             ? '#f56954' : ($key->status == 'acc' && $key->report_count == 0 
                //                                 ? '#17a2b8' : ($key->locked == 'offer' 
                //                                     ? '#ffc107' : ($key->locked == 'deal' 
                //                                         ? '#64bd63' : ($key->status == 'payed'
                //                                             ? '#26a69a' : '#546e7a')))),
                'backgroundColor'   => $color,
                'borderColor'       => $color,
    		]; 	
    	}

    	return $data;
    }
}