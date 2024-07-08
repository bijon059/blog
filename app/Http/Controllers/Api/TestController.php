<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function getPostsApi()
    {
        $data = array(
            "name"=>"Bijon",
            "content"=>"Etc and more"
        );

        return json_encode($data);
    }
}
