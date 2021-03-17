<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class AuthController extends Controller
{
    public function setSession(Request $request){
        // $data = $request->json()->all();
        // Session::put('id', $data['id']);
        // Session::put('name', $data['name']);
        // Session::put('phone', $data['phone']);
        // Session::put('email', $data['email']);
        // Session::put('address', $data['address']);
        // Session::put('province', $data['province']);
        // Session::put('regency', $data['regency']);
        // Session::put('district', $data['district']);
        // Session::put('village', $data['village']);
        // Session::put('role', $data['role']);
        // Session::put('access_token', $data['access_token']);

        return $request->session()->id;
    }

    public function updateSession(Request $request){
        $data = $request->json()->all();
        Session::put('id', $data['id']);
        Session::put('name', $data['name']);
        Session::put('phone', $data['phone']);
        Session::put('email', $data['email']);
        Session::put('address', $data['address']);
        Session::put('province', $data['province']);
        Session::put('regency', $data['regency']);
        Session::put('district', $data['district']);
        Session::put('village', $data['village']);
        Session::put('role', $data['role']);
        Session::put('access_token', $data['access_token']);
    }
    
    public function deleteSession(Request $request){
        Session::flush();
    }
}
