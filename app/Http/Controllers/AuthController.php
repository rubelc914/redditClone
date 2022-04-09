<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function register(RegisterRequest $request){


         $user = User::create($request->only('username','email','password'));
         return [
           'message'=>'User Register Successfully',
           'date'=> $user
         ];

    }

    public function login(LoginRequest $request){

        if (!auth()->attempt($request->only('email','password'))){
            throw new AuthenticationException('Invalid Credential');
        }
        return [
            'message'=>'Login successful',
            'user'=> auth()->user()->createToken('access_token')->plainTextToken
        ];
    }

    public function logOut(){
    auth()->user()->currentAccessToken()->delete();
    return[
        'message'=>'Successfully logout'
    ];
    }

    public function updateProfile(UpdateProfileRequest $request){

        auth()->user()->update($request->only('username','email'));

        return [
            'message'=>'Update Profile Successfully'
        ];
    }

}
