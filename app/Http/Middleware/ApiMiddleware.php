<?php

namespace App\Http\Middleware;

use Closure;
use \Illuminate\Http\Response;

class ApiMiddleware
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
        if ($request->api_key && $request->api_key == env('API_KEY')) 
        {
            return $next($request);
        }
        else
        {
            return response()->json([
                'status' => 'error',
                'status_code' => Response::HTTP_UNAUTHORIZED,
                'message' => 'Bad api key.',
            ]);
        }
    }
}
