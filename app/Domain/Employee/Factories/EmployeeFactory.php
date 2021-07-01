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
                'customer_engage'       => self::reservation($item->engageCustomer),
                'customer_engage_count' => $item->engage_customer_count,
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
                'termin'            => self::termin($item->termin),
                'allprice_dirt'     => self::allprice($item->termin, 3),
                'allprice_clean'    => self::allprice($item->termin, 4),
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
                    $data += $value->price_dirt * $value->volume;
                }
            }
        }elseif ($type == 2) {
            foreach ($items as $key) {
                foreach ($key->subreport as $value) {
                    $data += $value->price_clean * $value->volume;
                }
            }
        }elseif ($type == 3) {
            foreach ($items as $item) {
                foreach ($item->report as $key) {
                    foreach ($key->subreport as $value) {
                        $data += $value->price_dirt * $value->volume;
                    }
                }
            }
        }elseif ($type == 4) {
            foreach ($items as $item) {
                foreach ($item->report as $key) {
                    foreach ($key->subreport as $value) {
                        $data += $value->price_clean * $value->volume;
                    }
                }
            }
        }

        return $data;
    }

    public static function termin($items){
        $data = [];

        foreach ($items as $item) {
            $data[] = [
                'id'            => $item->id,
                'termin'        => $item->termin,
                'price_dirt'    => self::allprice($item->report, 1),
                'price_clean'   => self::allprice($item->report, 2),
                'payment_url'   => $item->payment_url,
                'date_invoice'  => $item->date_invoice ?? '-',
                'date_pay'      => $item->date_pay ?? '-',
                'document_no'   => $item->document ?? '-',
                'status'        => $item->status,
                'payment'       => $item->payment,
                'report'        => self::report($item->report),
            ];
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
                'payment_url'   => $item->payment_url,
                'date_invoice'  => $item->date_pay,
                'document_no'   => $item->payment[0]->number ?? '-',
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
                $price += $key->price_dirt * $key->volume;
            }
        }elseif ($type == 2) {
            foreach ($item as $key) {
                $price += $key->price_clean * $key->volume;
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