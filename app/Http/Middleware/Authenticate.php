<?php

namespace App\Http\Middleware;

use App\Models\Author;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $apikey = $request->header('X-API-KEY');

        if(!$apikey){
            return response()->json([
                'status' => false,
                'message' => 'Aunauthorized access'
            ],401);
        }

        $author = Author::find($request->id);

        if($author->api_key !== $apikey){
            return response()->json([
                'status' => false,
                'message' => 'Authoer API key is invalid'
            ],401);
        }

        return $next($request);
    }
}
