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

        return json_encode($posts);
    }
}
