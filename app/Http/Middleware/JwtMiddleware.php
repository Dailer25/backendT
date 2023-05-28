<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;


class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        try {
            JWTAuth::parseToken()->authenticate();
        } catch (Exception $error) {
            if ($error instanceof TokenInvalidException) {
                return response()->json([
                    'status' => 'Token invalido'
                ], 401);
            }
            if ($error instanceof TokenExpiredException) {
                return response()->json([
                    'status' => 'Token Expirado'
                ], 401);
            }
            return response()->json([
                'status' => 'Token no valido'
            ], 401);
        }

        return $next($request);
    }
}
