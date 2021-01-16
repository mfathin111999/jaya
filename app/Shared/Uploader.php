<?php

namespace App\Shared;

use Image;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class Uploader
{

    protected $path = 'public/';

    public function uploadImage($data, $type = 1000)
    {
        $imageName = NULL;
        $extension = $data->getClientOriginalExtension();
        $img       = Image::make($data->getRealPath());
        $img->resize(1000, 1000, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        $imageName = strtotime(date('Y-m-d H:i:s')).'_'.uniqid().'.'.$extension;
        $saved     = Storage::put($this->path.$imageName, $img->encode());

        return $imageName;
    }

    public function deleteImage($data)
    {
        $delete = Storage::delete($this->path.'/'.$data);

        if ($delete) {
            return true;
        }else{
            return false;
        }
    }
}
