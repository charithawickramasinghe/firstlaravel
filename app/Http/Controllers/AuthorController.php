<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterAuthorRequest;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
        ]);
    }

    public function loginAuthor(Request $request)
    {

    }

    public function logoutAuthor(Request $request)
    {

    }

    public function updateAuthor(Request $request)
    {

    }

    public function deleteAuthor(Request $request)
    {

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
            'author' => new AuthorResource($author),
        ]);
    }

    public function showAuthors(Request $request)
    {

    }
}
