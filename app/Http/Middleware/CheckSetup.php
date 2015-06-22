<?php namespace App\Http\Middleware;

use Closure;

class CheckSetup {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
    {
        if(schema_already_setup())
            return $next($request);
        else
            dd("setup not done");
	}

}
