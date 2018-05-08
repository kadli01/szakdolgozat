<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use \Illuminate\Http\Response as Res;

class AuthMiddleware extends \Tymon\JWTAuth\Http\Middleware\BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    { 

            // $response = $next($request);
        if (! $token = $this->auth->setRequest($request)->getToken()) {
            return response()->json([
                'status' => 'error',
                'status_code' => Res::HTTP_UNAUTHORIZED,
                'message' => 'You need to log in first!',
            ]);
        }
        try {
            $user = $this->auth->authenticate($token);

        } catch (TokenExpiredException $exception) {
            try {
                $newtoken = $this->auth->setRequest($request)->parseToken()->refresh();
                $response = $next($request);
                return $response->header('Authorization', 'Bearer '.$newtoken);
            } catch (JWTException $e) {

                return response()->json([
                    'status' => 'error',
                    'status_code' => Res::HTTP_UNAUTHORIZED,
                    'message' => 'You need to log in again!',
                ]);
            }
            // return response()->json([
            //     'status' => 'error',
            //     'status_code' => Res::HTTP_UNAUTHORIZED,
            //     'message' => 'You need to log in again!',
            // ]);
        } catch (JWTException $exception) {
            return response()->json([
                'status' => 'error',
                'status_code' => Res::HTTP_UNAUTHORIZED,
                'message' => 'You need to log in again!',
            ]);
        }

        // if (!isset($user)) {
        //     return response()->json([
        //         'status' => 'error',
        //         'status_code' => Res::HTTP_UNAUTHORIZED,
        //         'message' => 'User not found!',
        //     ]);
        // }
        // $this->events->fire('tymon.jwt.valid', $user);
        $response = $next($request);
        if (isset($newtoken)) {
            return $this->setAuthenticationHeader($response, $token);
            // return $response->header('Authorization', 'Bearer '.$newtoken);
        } else {
            return $response;
        }

    }


}