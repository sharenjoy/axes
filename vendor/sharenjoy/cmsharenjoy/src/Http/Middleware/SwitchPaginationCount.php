<?php namespace Sharenjoy\Cmsharenjoy\Http\Middleware;

use Closure;

class SwitchPaginationCount {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		// switch pagination count
        if ($request->has('query_string'))
        {
            parse_str($request->input('query_string'), $query);
            
            $query['perPage'] = $request->input('perPage');
            
            unset($query['page']);

            return redirect(session('objectUrl').'?'.http_build_query($query));
        }

		return $next($request);
	}

}
