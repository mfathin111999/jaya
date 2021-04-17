<?php

namespace App\Domain\Report\Factories;

class ReportFactory 
{

    public static function call($items){
        $data = [
            'id'            => $items->id,
            'code'          => $items->code,
            'name'          => $items->name,
            'date'          => $items->date,
            'date_work'     => $items->date_work,
            'time'          => $items->time,
            'vendor'        => $items->vendor,
            'locked'        => $items->locked,
            'vendor_is'     => $items->vendor_is,
            'customer_is'   => $items->customer_is,
            'report'        => self::callReport($items->report),
            'gallery'       => self::gallery($items->gallery),
            'customer'      => $items->customer,
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
                'termin'            => $item->termin,
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
        $data_clean += $item->price_clean; 
        $data_dirt  += $item->price_dirt; 
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