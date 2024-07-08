<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
class PostController extends Controller
{
    //

    public function getPostsApi()
    {
        try {
            $posts = Post::get();
        } catch (\Exception $e) {
            return json_encode($e);
        }
        $data = array(
            "name"=>"Bijon",
            "content"=>"Etc and more"
        );

        return json_encode($data);
    }
    public function register(Request $request)
    {
        $payload = $request->validate([
            "first_name"=>"required|min:2|max:60",
            "username"=>"required|min:5|unique:users,username",
            "email"=>"required|email|unique:email,email",
            "password"=>"required|min:4|max:50|confirmed",
        ]);
        $payload["role_id"]=1;
        return response()->json(["message"=>"Successfully Created","data"=>$payload],200);
    }
}
