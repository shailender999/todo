<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $status = 'Failed';

    protected $message = 'Some technical issues occured';

    protected $response = 500;

    protected $result = array();

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return $this->sendResponse(true);
    }

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('Todo')->accessToken;
            $this->result += array('token' => $token);
            return $this->sendResponse(true);
        } else {
            return $this->sendResponse(false);
        }
    }

    protected function sendResponse($status = false)
    {
        if($status)
        {
            $this->status = 'Success';
            $this->message = 'Successfull';
            $this->response = 200;
        }
        return response()->json(['status' =>$this->status,'message' => $this->message, 'data'=> $this->result], $this->response);
    }
}
