<?php

namespace App\Domain\Report\Factories;

class ReportFactory 
{

    public static function call($items){
        $data = [
            'id'            => $items->id,
            'user_id'       => $items->user_id,
            'code'          => $items->code,
            'name'          => $items->name,
            'email'         => $items->email,
            'phone_number'  => $items->phone_number,
            'date'          => $items->date,
            'date_work'     => $items->date_work,
            'time'          => $items->time,
            'vendor'        => $items->vendor,
            'pprovince'     => $items->pprovince ?? '-',
            'pregency'      => $items->pregency ?? '-',
            'pdistrict'     => $items->pdistrict ?? '-',
            'pvillage'      => $items->pvillage ?? '-',
            'paddress'      => $items->paddress ?? '-',
            'locked'        => $items->locked,
            'vendor_is'     => $items->vendor_is,
            'customer_is'   => $items->customer_is,
            'report'        => self::callReport($items->report),
            'gallery'       => self::gallery($items->gallery),
            'partner'      => $items->user->partner,
        ];

        return $data;
    }

	public static function callReport($items){
        $data = [];

        foreach ($items as $item) {
        $data[] = [
                'id'                => $item->id,
                'reservation_id'    => $item->reservation_id,
                'name'              => $item->name,
                'termin'            => auth()->guard('api')->user()->role == 5 ? ($item->termins->payment ?? null ) : $item->termin,
                'termin_code'       => $item->termins->id ?? null,
                'status'            => $item->status,
                'all_price'         => self::price($item->subreport),
                'detail'            => self::subReport($item->subreport),
            ];
        }

        return $data;
    }

    public static function price($items){
        $data_clean = 0;
        $data_dirt  = 0;

        foreach ($items as $item) {
        $data_clean += $item->price_clean * $item->volume; 
        $data_dirt  += $item->price_dirt * $item->volume; 
        }

        return [$data_clean, $data_dirt];
    }

    public static function subReport($items){
        $data = [];

        foreach ($items as $item) {
        $data[] = [
                'id'            => $item->id,
                'name'          => $item->name,
                'unit'          => $item->unit,
                'volume'        => $item->volume,
                'price_clean'   => $item->price_clean,
                'price_dirt'    => $item->price_dirt,
                'status'        => $item->status,
                'time'          => $item->time,
                'description'   => $item->description,
            ];
        }

        return $data;
    }

    public static function gallery($items){
        $data = [];

        foreach ($items as $item) {
        $data[] = [
                'id'            => $item->id,
                'image'         => $item->image,
            ];
        }

        return $data;
    }
}