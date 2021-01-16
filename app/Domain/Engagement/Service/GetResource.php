<?php

namespace  App\Domain\Engagement\Service;

use App\Domain\Engagement\Entities\Engagement;
use Illuminate\Support\Arr;

class GetResource
{
    /**
     * @return string
     * @throws \Exception
     */
    public function getAvailableDate()
    {
        $data = Engagement::select('date')->where('date', '>=', date('Y-m-d'))->get();

        $data = array_unique(Arr::flatten($data));

        return $data;
    }
}