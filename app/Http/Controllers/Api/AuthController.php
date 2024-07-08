<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $payload = $request->validate([
            "first_name"=>"required|min:2|max:60",
            "username"=>"required|min:5|unique:users,username",
            "email"=>"required|email|unique:users,email",
            "password"=>"required|min:4|max:50|confirmed",
        ]);
        $payload["role_id"]=1;
        $req = $request->all();
        try{
            $payload['password'] = Hash::make($payload['password']);
            $payload['last_name'] = $req["last_name"];
            User::create($payload);
            return response()->json(["message"=>"Successfully Created","data"=>[]],200);
        }catch(\Exception $e)
        {
            Log::info($e->getMessage());
            return response()->json(["message"=>$e->getMessage()],500);
        }

    }
    public function login(Request $request)
    {
        $payload = $request->validate([
            "email"=>"required|email",
            "password"=>"required",
        ]);
        try{
            $user = User::where('email',$payload['email'])->first();
            if($user){
                if(!Hash::check($payload['password'], $user->password))
            {
                return response()->json(["status"=>401,"message"=>"Invalid Credentials","data"=>[]],401);

            }else{
                $token = $user->createToken('web')->plainTextToken;
                $res = array_merge($user->toArray(),['token'=>$token]);
                return response()->json(["message"=>"Successfully  logged in","data"=>$res],200);
            }
            }else{
                return response()->json(["status"=>401,"message"=>"No user found","data"=>[]],401);
            }

        }catch(\Exception $e)
        {
            Log::info($e->getMessage());
            return response()->json(["message"=>$e->getMessage()],500);
        }
    }
}
