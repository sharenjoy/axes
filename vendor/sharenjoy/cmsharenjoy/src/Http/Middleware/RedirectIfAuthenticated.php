<?php

namespace Sharenjoy\Cmsharenjoy\Http\Middleware;

use Closure, Auth;

class RedirectIfAuthenticated
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
		if (Auth::guard('admin')->check()) {
			return redirect($request->session()->get('accessUrl'));
		}

		return $next($request);
	}

}
