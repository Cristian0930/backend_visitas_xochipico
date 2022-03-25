<?php

namespace App\Http\Middleware;


use Closure;
use Exception;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;

class JwtMiddleware
{
    public function handle($request, Closure $next): \Illuminate\Http\JsonResponse
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return response()->json(['status' => 'Token is Invalid'], 401);
            } else if ($e instanceof TokenExpiredException) {
                return response()->json(['status' => 'Token is Expired'], 401);
            } else {
                return response()->json(['status' => 'Authorization Token not found'], 401);
            }
        }
        return $next($request);
    }
}
