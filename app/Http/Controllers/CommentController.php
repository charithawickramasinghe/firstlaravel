<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use Illuminate\Support\Facades\Validator;
use App\Models\Comment;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comment = Comment::all();
        return response()->json([
            'status' => true,
            'message' => 'Comment retrived successfully',
            'data' => CommentResource::collection($comment)
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'comment'=>'required|string|min:3|max:255',
            'post_id'=>'required|integer'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'All fields are required',
                'errors' => $validator->errors()
            ],422);

        }

        $comment = Comment::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Comment created successfully',
            'data' => new CommentResource($comment)
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment = Comment::find($id);
        if(!$comment){
            return response()->json([
                'status' => false,
                'message' => 'Comment not found!'
            ],404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Comment retrived successfully',
            'data' => new CommentResource($comment) 
        ],200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(),[
            'comment'=>'required|string|min:3|max:255'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'All fields are required',
                'errors' => $validator->errors()
            ],422);
        }

        $comment = Comment::find($id);

        if(!$comment){
            return response()->json([
                'status' => false,
                'message' => 'Comment not found!'
            ],404);
        }

        $comment->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Comment updated successfully',
            'data' => new CommentResource($comment)
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::find($id);

        if(!$comment){
            return response()->json([
                'status' => false,
                'message' => 'Comment not found!'
            ],404);
        }

        $comment->delete();

        return response()->json([
            'status' => true,
            'message' => 'Comment deleted successfully'
        ],200);
    }
}
