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
		if($request->last_name != NULL){
			$request->merge(array('last_name' => $this->clean($request->last_name)));
		}
		if($request->dni != NULL){
                        $request->merge(array('dni' => $this->clean($request->dni)));
                }
		if($request->address != NULL){
                        $request->merge(array('last_name' => $this->clean($request->last_name)));
                }
		if($request->name != NULL){
                        $request->merge(array('name' => $this->clean($request->name)));
                }
		return $next($request);
	}
	private function clean($string){
		return trim(preg_replace('/\s+/',' ',$string));
	}

}
