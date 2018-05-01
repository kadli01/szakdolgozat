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
\Log::info('exp');
            try {
                $newtoken = $this->auth->refresh();
                \Log::info($newtoken);
            } catch (JWTException $e) {
                \Log::info($e);
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