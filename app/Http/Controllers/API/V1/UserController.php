<?php

namespace App\Http\Controllers\API\V1;

use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\User\Entities\User;
use App\Domain\Employee\Entities\Vendor;
use App\Domain\User\Factories\UserFactory;
use Session;

class UserController extends Controller
{
    public $successStatus = 200;

    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required',
        ]);

        $message = "Login Error";
        if ($validator->fails()) {
            return apiResponseBuilder(200, $validator->errors(), $message);
        }

        $credentials                = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user                   = $request->user();
            $tokenResult            = $user->createToken('access_token');
            $user->access_token     = $tokenResult->accessToken;

            $message                = "You are logged";
            return apiResponseBuilder(200, UserFactory::call($user), $message);
            // return apiResponseBuilder(200, $user, $message);
        }else{
            return apiResponseBuilder(401, 'Not Available', 'Unauthorised');
        }
    }

    public function setToken(Request $request)
    {
        $user = User::find(auth()->user()->id);

        $tokenResult            = $user->createToken('access_token');
        $user->access_token     = $tokenResult->accessToken;

        $request->session()->put('id', $user->id);
        $request->session()->put('role', $user->role);
        $request->session()->put('access_token', $user->access_token);
        Session::put('id', $user->id);
        Session::put('role', $user->role);
        Session::put('access_token', $user->access_token);

        $message                = "You get the Token";

        return apiResponseBuilder(200, $user, $message);

    }

    public function getSurveyer(){
        $data = User::where('role', 2)->get();

        return apiResponseBuilder(200, $data, 'success');
    }

    public function getMandor(){
        $data = User::where('role', 3)->get();

        return apiResponseBuilder(200, $data, 'success');
    }

    public function getVendor(){
        $data = User::with('partner')->where('role', 5)->get();

        return apiResponseBuilder(200, $data, 'success');
    }

    public function getSurveyerById($id){
        $data = User::where('id', $id)->with('province', 'district', 'regency', 'village', 'partner')->first();

        return apiResponseBuilder(200, $data, 'success');
    }

    public function actionSurveyer($id, Request $request){
        $data = User::find('id');

        $data->status = $request['action'];

        $data->save();

        return apiResponseBuilder(200, $data, 'success');
    }

    public function getMe(Request $request){
        $data = User::where('id', $request->id)->select('name', 'email', 'province_id', 'regency_id', 'district_id', 'village_id', 'phone', 'address')->first();

        return apiResponseBuilder(200, $data);
    }

    public function registerSurveyer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'username'  => 'required|unique:users,username',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=> $validator->errors()], 401);            
        }

        $user = new User;
        $user->username     = $request['username'];
        $user->name         = $request['name'];
        $user->email        = $request['email'];
        $user->province_id  = $request['province_id'];
        $user->regency_id   = $request['regency_id'];
        $user->district_id  = $request['district_id'];
        $user->village_id   = $request['village_id'];
        $user->address      = $request['address'];
        $user->phone        = $request['phone'];
        $user->password     = bcrypt($request['password']);
        $user->role         = 2;
        $user->save();

        return apiResponseBuilder(200, $user, 'Registrasi Pekerja Berhasil');
    }

    public function updateSurveyer($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=> $validator->errors()], 401);            
        }

        $user = User::find($id);

        $user->name         = $request['name'] ?? $user->name;
        $user->email        = $request['email'] ?? $user->email;
        $user->province_id  = $request['province_id'] ?? null;
        $user->regency_id   = $request['regency_id'] ?? null;
        $user->district_id  = $request['district_id'] ?? null;
        $user->village_id   = $request['village_id'] ?? null;
        $user->address      = $request['address'] ?? null;
        $user->phone        = $request['phone'] ?? null;
        $user->save();

        return apiResponseBuilder(200, $user, 'Update Pekerja Berhasil');
    }

    public function registerMandor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'username'  => 'required|unique:users,username',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=> $validator->errors()], 401);            
        }

        $user = new User;
        $user->username     = $request['username'];
        $user->name         = $request['name'];
        $user->email        = $request['email'];
        $user->province_id  = $request['province_id'];
        $user->regency_id   = $request['regency_id'];
        $user->district_id  = $request['district_id'];
        $user->village_id   = $request['village_id'];
        $user->address      = $request['address'];
        $user->phone        = $request['phone'];
        $user->password     = bcrypt($request['password']);
        $user->role         = 2;
        $user->save();

        return apiResponseBuilder(200, $user, 'Registrasi Pekerja Berhasil');
    }

    public function updateMandor($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=> $validator->errors()], 401);            
        }

        $user = User::find($id);

        $user->name         = $request['name'] ?? $user->name;
        $user->email        = $request['email'] ?? $user->email;
        $user->province_id  = $request['province_id'] ?? null;
        $user->regency_id   = $request['regency_id'] ?? null;
        $user->district_id  = $request['district_id'] ?? null;
        $user->village_id   = $request['village_id'] ?? null;
        $user->address      = $request['address'] ?? null;
        $user->phone        = $request['phone'] ?? null;
        $user->save();

        return apiResponseBuilder(200, $user, 'Update Pekerja Berhasil');
    }

    public function registerVendor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'username'  => 'required|unique:users,username',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=> $validator->errors()], 401);            
        }

        $user = new User;
        $user->username     = $request['username'];
        $user->name         = $request['name'];
        $user->email        = $request['email'];
        $user->province_id  = $request['province_id'];
        $user->regency_id   = $request['regency_id'];
        $user->district_id  = $request['district_id'];
        $user->village_id   = $request['village_id'];
        $user->address      = $request['address'];
        $user->phone        = $request['phone'];
        $user->password     = bcrypt($request['password']);
        $user->role         = 5;
        $user->save();

        $vendor             = new Vendor;
        $vendor->user_id    = $user->id;
        $vendor->vendor     = 'yes';
        $vendor->tax_id     = $request['tax_id'];
        $vendor->ktp        = $request['ktp'];
        $vendor->owner      = $request['owner'];
        $vendor->bank_name  = $request['bank_name'];
        $vendor->bank_account_name      = $request['bank_account_name'];
        $vendor->bank_account_number    = $request['bank_account_number'];
        $vendor->save();

        return apiResponseBuilder(200, $user, 'Registrasi Pekerja Berhasil');
    }

    public function updateVendor($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=> $validator->errors()], 401);            
        }

        $user = User::find($id);

        $user->name         = $request['name'] ?? $user->name;
        $user->email        = $request['email'] ?? $user->email;
        $user->province_id  = $request['province_id'] ?? null;
        $user->regency_id   = $request['regency_id'] ?? null;
        $user->district_id  = $request['district_id'] ?? null;
        $user->village_id   = $request['village_id'] ?? null;
        $user->address      = $request['address'] ?? null;
        $user->phone        = $request['phone'] ?? null;
        $user->save();

        $vendor             = Vendor::find($user->id);
        $vendor->user_id    = $user->id;
        $vendor->vendor     = 'yes';
        $vendor->tax_id     = $request['tax_id'];
        $vendor->ktp        = $request['ktp'];
        $vendor->owner      = $request['owner'];
        $vendor->bank_name  = $request['bank_name'];
        $vendor->bank_account_name      = $request['bank_account_name'];
        $vendor->bank_account_number    = $request['bank_account_number'];
        $vendor->save();

        return apiResponseBuilder(200, $user, 'Update Pekerja Berhasil');
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }
}
