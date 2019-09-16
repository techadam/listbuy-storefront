<?php namespace App\Http\Middleware;

use App\Traits\ApiResponseTrait;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

/**
 * makes sure the "Authorization" header is present
 * and that it contains a valid JWT token
 */

class JwtAuthenticate
{
    use ApiResponseTrait;

    public function handle(Request $request, Closure $next)
    {
        if ($request->header('Authorization')) {
            try {
                $jwt_auth = JWTAuth::parseToken();

                $jwt_auth->authenticate();

                return $next($request);
            } catch (TokenExpiredException $e) {
                return $this->custom(null, 'token expired', false, $e->getStatusCode());
            } catch (TokenInvalidException $e) {
                return $this->custom(null, 'token invalid', false, $e->getStatusCode());
            } catch (JWTException $e) {
                return $this->custom(null, 'token absent', false, $e->getStatusCode());
            }
        }
        return $this->badRequest('no "Authorization" header found');
    }
}
