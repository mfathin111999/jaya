<?php

namespace App\Http\Controllers\API\V1;

use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\User\Entities\User;

class UserController extends Controller
{
    public $successStatus = 200;

    public function login(Request $request){
        // if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){
        //     $user = Auth::user();
        //     $success['token'] =  $user->createToken('token')->accessToken;
        //     return response()->json(['success' => $success], $this->successStatus);
        // }
        // else{
        //     return response()->json(['error'=>'Unauthorised'], 401);
        // }

        $validator = Validator::make($request->all(), [
            'email'     => 'required',
            'password'  => 'required',
        ]);

        $message = "Login Error";
        if ($validator->fails()) {
            return apiResponseBuilder(401, $validator->errors(), $message);
        }

        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $user = $request->user();
            $tokenResult = $user->createToken('VIP Access Token');
            $user->authentication = $tokenResult->accessToken;

            $message = "You are logged";
            return apiResponseBuilder(200, $user, $message);
        }else{
            return apiResponseBuilder(401, [], 'Unauthorised');
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error'=> $validator->errors()], 401);            
        }

        $user = new User;
        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->username     = $request->username;
        $user->password     = bcrypt($request->password);
        $user->role         = 4;
        if ($user->save()) {
            $token = $user->createToken('token')->accessToken;
            $message = "Registration successful ... !";
            return apiResponseBuilder(200, $message, ['data' => $user, 'token' => $token]);
        }else{
            $message = "Sorry! Registration is not successfull.";
            return apiResponseBuilder(401, $message);
        }      
    }

    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
