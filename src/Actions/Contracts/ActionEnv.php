<?php

namespace Lmande\SecurityForcer\Actions\Contracts;

use Illuminate\Support\Facades\File;

abstract class ActionEnv extends Action
{
	private $envContent;

	final protected function changeEnv(Callable $func): bool
	{
		if (!File::exists($path = base_path('.env'))) {
			return false;
		}

		if (!File::isWritable($path)) {
			return false;
		}

		if ($content = $func($this->getEnvContents($path))) {
			return File::put($path, $content);
		}

		return false;
	}

	private function getEnvContents(string $path): string
	{
		if (!$this->envContent) {
			$this->envContent = File::get($path);
		}

		return $this->envContent;
	}
}
