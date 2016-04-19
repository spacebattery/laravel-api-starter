<?php

namespace App\Http\Middleware;

use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Middleware\BaseMiddleware;
use JWTAuth;

class RefreshToken extends BaseMiddleware {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, \Closure $next)
    {
        $response = $next($request);
        $newToken = null;

        try {
            JWTAuth::parseToken()->authenticate();
        } catch (TokenExpiredException $e) {
            try {
                $newToken = $this->auth->setRequest($request)->parseToken()->refresh();
            } catch (TokenExpiredException $ex) {
                return $this->respond('tymon.jwt.expired', 'token_expired', $ex->getStatusCode(), [$ex]);
            }
        } catch (JWTException $e) {
            return $this->respond('tymon.jwt.invalid', 'token_invalid', $e->getStatusCode(), [$e]);
        }

        // send the refreshed token back to the client
        if ($newToken) {
            $response->headers->set('Authorization', 'Bearer '.$newToken);
        }

        return $response;
    }
}
