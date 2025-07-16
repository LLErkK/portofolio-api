<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\Userresource;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function register(UserRegisterRequest $request):JsonResponse{
        $data = $request->validated();
        if(User::where('username',$data['username'])->count()==1){
            throw new HttpResponseException(response([
                "errors"=>[
                    "username"=>[
                        "username already register"
                    ],
                    "password"=>[
                        "password eror"
                    ],
                    "name"=>[
                        "name eror"
                    ]
                ]
            ],400));
        }
        $user = new User($data);
        $user->password =Hash::make($data['password']);
        $user->save();

        return (new Userresource($user)->response()->setStatusCode(201));
    }

    public function login(UserLoginRequest $request):Userresource{
        $data = $request->validated();

        $user = User::where('username',$data['username'])->first();
        if(!$user|| !Hash::check($data['password'],$user->password)){
            throw new HttpResponseException(response([
                "errors"=>[
                    "massage"=>[
                        "username or password wrong"
                    ]
                ]
            ],401));
        }
        $user->token = Str::uuid()->toString();
        $user->save();
        return new Userresource($user);
    }

    public function get(Request $request): Userresource{
        $user = Auth::user();
        return new Userresource($user);
    }
    public function logout(Request $request): JsonResponse
    {
        $user = Auth::user();
        $user->token = null;
        $user->save();

        return response()->json([
            "data"=>true
        ])->setStatusCode(200);
    }
}
