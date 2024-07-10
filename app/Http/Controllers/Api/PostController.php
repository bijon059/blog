<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use library\libs\ApiResponse;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $payload = $request->validate([
            'title'=>'required|min:5|max:150',
            'short_description'=>'required|min:5|max:255',
            'content'=>'required|min:10',
            'media' => 'required',
            'media.*' => 'mimes:jpeg,jpg,png|max:4000',
        ]);
        $payload['created_by'] = 1;
        try {
            $response = new ApiResponse();
            $post = Post::create($payload);
            if(!empty($post->id))
            {
                if($files = $payload['media'])
                {   $i=0;
                    foreach($files as $media)
                    {
                        $image = $media->store($post->created_by.'/'.$post->id);
                        $type = $media->getClientOriginalExtension();
                        $imageArray=[
                            'image_url'=>$image,
                            'file_type'=>$type,
                            'uploaded_by'=> $post->created_by,
                            'post_id'=> $post->id,
                        ];
                        if(File::create($imageArray))
                        {
                            $i++;
                        }
                    }
                    addInfo($i.' Files Saved');
                }
            }
            return $response->displayWithResponse(true,$post,200);
        }catch (\Exception $err){
            Log::info($err->getMessage());
            return response()->json(["message"=>"Something went wrong"],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
