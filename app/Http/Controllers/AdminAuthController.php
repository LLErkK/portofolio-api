<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use function PHPUnit\Framework\returnValueMap;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $response = Http::post(url('api/users/login'),[
            'username'=>$request->username,
            'password'=>$request->password
        ]);

        if($response->successful()){
            $token = $response['token'];
            Session::put('admin_token',$token);
            return redirect()->route('admin.dashboard');
        }

        return redirect()->back()->with('eror','login gagal');
    }

    public function logout(){
        Session::forget('admin_token');
        return redirect()->route('admin.login');
    }
}
