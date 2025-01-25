<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $post = Post::all();
        // return response()->json([
        //     'status' => true,
        //     'message' => 'Post retrived successfully',
        //     'data' => PostResource::collection($post)
        // ],200);
        // with pagination.
        $post = Post::with('comments')->paginate(5);
        return response()->json([
            'status' => true,
            'message' => 'Post retrived successfully',
            'data' => [
                'posts' => PostResource::collection($post),
                'pagination' => [
                    'total' => $post->total(),
                    'pre_page' => $post->perPage(),
                    'current_page' => $post->currentPage(),
                    'last_page' => $post->lastPage(),
                    'next_page_url' => $post->nextPageUrl(),
                    'prev_page_url' => $post->previousPageUrl()
                ]
            ]
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title'=>'required|string|min:3|max:255',
            'body'=>'required|string|min:5'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'All fields are required',
                'errors' => $validator->errors()
            ],422);

        }

            $post = Post::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Post created successfully',
                'data' => new PostResource($post) 
            ],201);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        if(!$post){
            return response()->json([
                'status' => false,
                'message' => 'Post not found!'
            ],404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Post retrived successfully',
            'data' => new PostResource($post)
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'title'=>'required|string|min:3|max:255',
            'body'=>'required|string|min:5'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'All fields are required',
                'errors' => $validator->errors()
            ],422);
        }

        $post = Post::find($id);

        if(!$post){
            return response()->json([
                'status' => false,
                'message' => 'Post not found!'
            ],404);
        }

        $post-> update($request->all());

        return response()->json([
            'ststus' => true,
            'message' => 'Post update successfully',
            'data' => new PostResource($post)
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);

        if(!$post){
            return response()->json([
                'status' => false,
                'message' => 'Post not found!'
            ],404);
        }

        $post-> delete();

        return response()->json([
            'ststus' => true,
            'message' => 'Post deleted successfully',
        ],200);
    }
}
