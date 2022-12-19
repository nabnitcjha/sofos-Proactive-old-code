<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
     /**
 * @OA\SecurityScheme(
 *     type="http",
 *     description="First Login with Email=admin@proactive.com  Password=proactive@admin123 then copy authentication token and paste below input field",
 *     name="Token based Based",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="apiAuth",
 * )
 */
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if (!$request->user()->hasRole($role)) {
            // Redirect...
            return redirect('/#/home');
            //return redirect(RouteServiceProvider::HOME);
        }

        return $next($request);
    }
}
