<?php

namespace  App\Domain\Engagement\Service;

use App\Domain\Engagement\Entities\Engagement;
use Illuminate\Support\Str;

class GetCode
{
    /**
     * @param $title
     * @param int $id
     * @return string
     * @throws \Exception
     */
    public function createCode()
    {
        $code = strtoupper(Str::random(7));

        $validate = $this->getRelatedCodes($code);

        if ($validate == 0) {
            return $code;
        }

        throw new Exception("Code Can't Generated");
    }

    protected function getRelatedCodes($code)
    {
        return Engagement::select('code')->where('code', $code)->count();
    }
}