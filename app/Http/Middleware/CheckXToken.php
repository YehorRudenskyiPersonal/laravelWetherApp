<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckXToken
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('x-token') !== env('X_TOKEN')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        
        return $next($request);
    }
}
