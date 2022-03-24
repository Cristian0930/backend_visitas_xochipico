<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->isAdmin) {
            return $next($request);
        }

        return response()->json([
            'error' => 'you don\'t have permissions'
        ], 403);
    }
}
