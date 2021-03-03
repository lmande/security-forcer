<?php

namespace Lmande\SecurityForcer;

use Illuminate\Support\ServiceProvider;
use Lmande\SecurityForcer\Commands\StartCommand;
use Lmande\SecurityForcer\SecurityForcerStarter;

class SecurityForcerServiceProvider extends ServiceProvider
{
	public function boot()
	{
		$starter = new SecurityForcerStarter;
		$starter->run();

		if ($this->app->runningInConsole()) {
			if (env('APP_ENV', 'production') === 'stesting') {
				$this->commands([
					StartCommand::class
				]);
			}
		}
	}

	public function register() {}
}
