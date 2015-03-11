<?php namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel {

	/**
	 * The application's global HTTP middleware stack.
	 *
	 * @var array
	 */
	protected $middleware = [
		'Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode',
		'Illuminate\Cookie\Middleware\EncryptCookies',
		'Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse',
		'Illuminate\Session\Middleware\StartSession',
		'Illuminate\View\Middleware\ShareErrorsFromSession',
		'App\Http\Middleware\VerifyCsrfToken',
	];

	/**
	 * The application's route middleware.
	 *
	 * @var array
	 */
	protected $routeMiddleware = [
		'auth' => 'App\Http\Middleware\Authenticate',
		'auth.basic' => 'Illuminate\Auth\Middleware\AuthenticateWithBasicAuth',
		'guest' => 'App\Http\Middleware\RedirectIfAuthenticated',

		// for backend cmsharenjoy
		'admin.auth' => 'Sharenjoy\Cmsharenjoy\Http\Middleware\Authenticate',
		'admin.guest' => 'Sharenjoy\Cmsharenjoy\Http\Middleware\RedirectIfAuthenticated',
		'admin.switchPaginationCount' => 'Sharenjoy\Cmsharenjoy\Http\Middleware\SwitchPaginationCount',
		'admin.setGoBackPrevious' => 'Sharenjoy\Cmsharenjoy\Http\Middleware\SetGoBackPrevious',
	];

}
