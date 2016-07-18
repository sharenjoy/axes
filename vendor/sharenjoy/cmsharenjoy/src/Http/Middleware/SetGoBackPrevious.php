<?php namespace Sharenjoy\Cmsharenjoy\Http\Middleware;

use Closure;

class SetGoBackPrevious {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        session()->put('goBackPrevious', $request->fullUrl());

		return $next($request);
	}

}
