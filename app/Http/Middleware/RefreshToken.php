<?php

namespace App\Http\Middleware;

use Closure;

class RefreshToken extends \Tymon\JWTAuth\Http\Middleware\BaseMiddleware
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
        $token = $this->auth->setRequest($request)->getToken();
        $token = $this->auth->refresh();
        $response = $next($request);
        $response->headers->set('Authorization', 'Bearer '.$token);

        return $response;
    }
}
