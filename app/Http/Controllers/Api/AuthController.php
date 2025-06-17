<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ResponseTrait;
    public function register(Request $request){
        $validtor=Validator::make($request->all(),[
            "name"=>"required",
            "email"=>"required|email|unique:users",
            "password"=>"required|min:8",
        ]);
        if($validtor->fails())
            return $this->Response($validtor->errors(),"Data Not Valid",422);
        $user=User::create([
            "name"=>$request->name,
            "email"=>$request->email,
            "password"=>Hash::make($request->password),
        ]);
        $token = $user->createToken('Driver Token')->plainTextToken;
        $data=[
            "user"=>$user,
            "token"=>$token,
        ];
        return $this->Response($data,"Registered Successfully",201);
    }
    public function login(Request $request){
        $validtor=Validator::make($request->all(),[
            "email"=>'required|email',
            "password"=>"required",
        ]);
        if($validtor->fails())
            return $this->Response($validtor->errors(),"Data Not Valid",422);
        $user=User::where("email",$request->email)->first();
        if(!$user || ! Hash::check($request->password,$user->password) )
            return $this->Response(null,"Password Or Email Not Correct",422);
        $token=$user->createToken("Auth_token")->plainTextToken;
                $data=[
            "user"=>$user,
            "token"=>$token,
        ];
        return $this->Response($data,"Login Successfully",201);
    }
    public function logout(Request $request){
        $request->user()->tokens()->delete();
        return $this->Response(null,"Logout Successfully",201);
    }
}
