<?php

namespace App\Domain\Employee\Factories;

class EmployeeFactory 
{
	public static function call($items){
        $data = [];

        foreach ($items as $item) {
        $data[] = [
                'id'                    => $item->id,
                'name'                  => $item->name,
                'vendor_engage'         => self::reservation($item->vendorEngage),
                'vendor_engage_count'   => $item->vendor_engage_count,
            ];
        }
        return $data;
    }

    public static function callPartner($items){
        $data = [];

        foreach ($items as $item) {
        $data[] = [
                'id'                    => $item->id,
                'name'                  => $item->name,
                'customer_engage'       => self::reservation($item->customerEngage),
                'customer_engage_count' => $item->customer_engage_count,
            ];
        }
        return $data;
    }

    public static function reservation($items){
        $data = [];

        foreach ($items as $item) {
        $data[] = [
                'id'                => $item->id,
                'code'              => $item->code,
                'name'              => $item->name,
                'address'           => empty($item->address) ? '-' : $item->address,
                'village'           => $item->village->name,
                'district'          => $item->district->name,
                'regency'           => $item->regency->name,
                'province'          => $item->province->name,
                'date'              => $item->date,
                'time'              => $item->time,
                'status'            => $item->status,
                'service'           => $item->service,
                'report'            => self::report($item->report),
                'allprice_dirt'     => self::allprice($item->report, 1),
                'allprice_clean'    => self::allprice($item->report, 2),
                'created_at'        => Date('Y-m-d', strtotime($item->created_at))
            ];
        }
        return $data;
    }

    public static function allprice($items, $type){
        $data = 0;

        if ($type == 1) {
            foreach ($items as $key) {
                foreach ($key->subreport as $value) {
                    $data += $value->price_dirt;
                }
            }
        }elseif ($type == 2) {
            foreach ($items as $key) {
                foreach ($key->subreport as $value) {
                    $data += $value->price_clean;
                }
            }
        }

        return $data;
    }

    public static function report($items){
        $data = [];

        foreach ($items as $item) {
            $data[] = [
                'id'            => $item->id,
                'name'          => $item->name,
                'price_dirt'    => self::price($item->subreport, 1),
                'price_clean'   => self::price($item->subreport, 2),
                'date_invoice'  => $item->date_pay,
                'updated_at'    => $item->updated_at,
                'status'        => $item->status,
            ];
        }

        return $data;
    }

    public static function price($item, $type){
        $price = 0;

        if ($type == 1) {
            foreach ($item as $key) {
                $price += $key->price_dirt;
            }
        }elseif ($type == 2) {
            foreach ($item as $key) {
                $price += $key->price_clean;
            }
        }
        

        return $price;
    }

    public static function serviceFactory($item){
        $data = [];

        foreach ($item as $key) {
            $data[] = $key->name;
        }

        return implode(', ', $data);
    }
}