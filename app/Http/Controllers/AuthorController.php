<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthorController extends Controller
{
    public function registerAuthor(RegisterAuthorRequest $request)
    {

        $author = Author::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'address' => $request['address'],
            'phone' => $request['phone'],
            'age' => $request['age'],
            'api_key' => Str::random(32),
        ]);

        return response()->json([
            'message' => 'Author registered successfully',
            'author' => new AuthorResource($author),
        ],200);
    }

    public function loginAuthor(Request $request)
    {

    }

    public function logoutAuthor(Request $request)
    {

    }

    public function updateAuthor(Request $request, $id)
    {
        $validator = Validator::make ($request->all(),[
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => 'All fields are required',
                'errors' => $validator->errors()
            ],422);
        }

        $author = Author::find($id);

        if(!$author){
            return response()->json([
                'status' => false,
                'message' => 'Author not found!'
            ],404);
        }

        $author->update($request->all());

        return response()-> json([
            'status' => true,
            'messages' => 'Author updated successfully',
            'data' => new AuthorResource($author)
        ],200);
    }

    public function deleteAuthor($id)
    {
        $author = Author::find($id);
        if(!$author){
            return response()->json([
                'message' => 'auther not found',
            ],404);
        }

        $author->delete();

        return response()->json([
            'ststus' => true,
            'message' => 'Author deleted successfully'
        ],200);
    }

    public function showAuthor($id)
    {
         $author = Author::find($id);

         if (!$author) {
             return response()->json([
                 'message' => 'Author not found',
             ], 404);
         }

         return response()->json([
            'status' => true,
            'message' => 'Auther retrieved successfully',
            'data' => new AuthorResource($author),
         ],200);
    }

    public function showAuthors(Request $request)
    {
        $authors = Author::all();

        return response()->json([
            'status' => true,
            'message' => 'Authors retrieved successfully',
            'data' => AuthorResource::collection($authors)
        ],200);
    }
}
