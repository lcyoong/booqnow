<?php

namespace App\Http\Middleware;

use Closure;

class Permitted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
      if ($request->user()->can($permission) || $request->user()->hasRole('super_admin')) {

        return $next($request);

      } else {

        return abort(403);
        
      }
    }
}
