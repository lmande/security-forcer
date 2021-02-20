<?php

namespace Lmande\SecurityForcer\Commands;

use Illuminate\Support\Collection;
use Illuminate\Console\Command;
use Lmande\SecurityForcer\Actions\Start;

class StartCommand extends Command
{
	protected $names     = [];
	protected $signature = 'sf:start';

	protected $description = 'Security forcer test run';

	public function handle()
	{
		$actioner   = new Start;
		$successful = $actioner->run();

		return $successful? 0: 1;
	}
}
