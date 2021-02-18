<?php

namespace Lmande\SecurityForcer;

use Illuminate\Support\ServiceProvider;

class SecurityForcerServiceProvider extends ServiceProvider
{
	public function boot()
	{
		if ($this->app->runningInConsole()) {
			//
		}
	}

	public function register() {}
}
