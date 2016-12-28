<?php

namespace Sharenjoy\Cmsharenjoy\Http\Middleware;

use Closure, Auth;

class Authenticate
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
		if (! Auth::guard('admin')->check() || Auth::guard('admin')->user()->activated == false) {
			if ($request->ajax()) {
				return response('Unauthorized.', 401);
			} else {
				Auth::guard('admin')->logout();
				return redirect()->guest($request->session()->get('accessUrl').'/login');
			}
		}

		return $next($request);
	}

}
