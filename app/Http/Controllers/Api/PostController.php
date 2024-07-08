<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        //return response()->json(["message"=>"Successfully Created","data"=>$request->all()],200);
//        try {
            $payload = $request->validate([
                'title'=>'required|min:5|max:20',
                'content'=>'required|min:10'
            ]);
//        }catch (\Illuminate\Validation\ValidationException $th){
//            return $th->validator->errors();
//        }

        return response()->json(["message"=>"Successfully Created","data"=>$payload],200);
        $payload['created_by'] = 1;
        try {
            $post = Post::create($payload);
            return response()->json(["message"=>"Successfully Created","data"=>$post],200);
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
