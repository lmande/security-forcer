<?php

namespace Lmande\SecurityForcer;

use Illuminate\Support\ServiceProvider;
use Lmande\SecurityForcer\Actions\Start;
use Lmande\SecurityForcer\Commands\StartCommand;

class SecurityForcerServiceProvider extends ServiceProvider
{
	public function boot()
	{
		$actioner = new Start;
		$actioner->run();

		if ($this->app->runningInConsole()) {
			if (env('APP_ENV', 'production') === 'local' && env('APP_DEBUG', false) === true) {
				$this->commands([
					StartCommand::class
				]);
			}
		}
	}

	public function register() {}
}
