<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DetermineUserType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the current route name
        $routeName = $request->path();

         // Determine the user type based on the route name
         if (strpos($routeName, 'superadmin') === 0) {
            $request->merge(['whoIs' => 'superadmin']);
        } elseif (strpos($routeName, 'admin') === 0) {
            $request->merge(['whoIs' => 'admin']);
        } elseif (strpos($routeName, 'driver/') === 0) {
            $request->merge(['whoIs' => 'driver']);
        } elseif (strpos($routeName, 'customer/') === 0) {
            $request->merge(['whoIs' => 'customer']);
        } else {
            $request->merge(['whoIs' => null]);
        }
        return $next($request);
    }
}
