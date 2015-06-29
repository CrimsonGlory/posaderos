<?php namespace App\Http\Middleware;

use Closure;
use App\User;
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
        if(schema_already_setup() && User::count()!=0)
        {
            return $next($request);
        }
        else
        {
            return redirect('/setup');
        }
    }

}
