<?php

namespace App\Http\Middleware;

use Closure;
use App\Merchant;

class ConnectTenant
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
      if (config('myapp.multi_tenant')) {

        if (is_numeric($request->segment(1))) {

          $merchant = Merchant::findOrFail($request->segment(1));

          if ($merchant->mer_owner != $request->user()->id) {

            return abort(403);
          }

          session(['merchant' => $merchant]);
        }
      } else {

        $merchant = Merchant::firstOrFail();

        session(['merchant' => $merchant]);
      }

      return $next($request);
    }
}
