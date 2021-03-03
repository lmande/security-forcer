<?php

namespace Lmande\SecurityForcer\Actions;

use Illuminate\Support\Facades\File;

abstract class ActionEnv extends Action
{
	final protected function changeEnv(Callable $func): bool
	{
		if (!File::exists($path = base_path('.env'))) {
			return false;
		}

		if (!File::isWritable($path)) {
			return false;
		}

		$content = $func(File::get($path));

		if ($content) {
			return File::put($path, $content);
		}

		return false;
	}
}
