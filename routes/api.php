<?php

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Middleware\Authenticate;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::apiResource('post', PostController::class);
Route::apiResource('comment', CommentController::class);

Route::post('/author-register', [AuthorController::class, 'registerAuthor']);

Route::post('/author-login', [AuthorController::class, 'loginAuthor']);
Route::post('/author-logout', [AuthorController::class, 'logoutAuthor']);
Route::put('/author-update/{id}', [AuthorController::class, 'updateAuthor']);//->middleware(Authenticate::class);
Route::delete('/author-delete/{id}', [AuthorController::class, 'deleteAuthor']);
Route::get('/author-view/{id}', [AuthorController::class, 'showAuthor']); //->middleware(Authenticate::class);
Route::get('/author-viewall', [AuthorController::class, 'showAuthors']);