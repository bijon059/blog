<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Validation\ValidationException;
use library\libs\ApiResponse;

use function Laravel\Prompts\error;

//use Library\libs\ApiResponse;

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
        $response = new  ApiResponse();
        return $response->displayWithResponse(true,$data,200);
    }
}
