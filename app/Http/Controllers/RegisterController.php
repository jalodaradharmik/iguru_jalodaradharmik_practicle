<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use GoogleTranslate;

class RegisterController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError(GoogleTranslate::trans($validator->errors()->first(), app()->getLocale()));       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $data = $user;
        $data['token'] =  $user->createToken('Iguru')->accessToken;
   
        return $this->sendResponse($data, GoogleTranslate::trans('User register successfully.', app()->getLocale()));
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
   
        if($validator->fails()){
            return $this->sendError(GoogleTranslate::trans($validator->errors()->first(), app()->getLocale()));       
        }

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $data = $user;
            $data['token'] =  $user->createToken('Iguru')->accessToken;
            return $this->sendResponse($data, GoogleTranslate::trans('User login successfully.', app()->getLocale()));
        } 
        else{ 
            return $this->sendError(GoogleTranslate::trans('Unauthorised.', app()->getLocale()));
        } 
    }
}
