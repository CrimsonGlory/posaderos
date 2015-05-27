<?php namespace App\Http\Middleware;

use Closure;

class CleanFields {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if($request->first_name != NULL){
			$request->merge(array('first_name' => $this->clean($request->first_name)));
		}
		return $next($request);
	}
	private function clean($string){
		return trim(preg_replace('/\s+/',' ',$string));
	}

}
