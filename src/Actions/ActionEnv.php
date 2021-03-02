<?php

namespace Lmande\SecurityForcer\Actions;

class ActionEnv extends Action
{
	final protected function changeEnv(Callable $func): bool
	{
		if (!$this->files->exists($path = base_path('.env'))) {
			return false;
		}

		if (!$this->files->isWritable($path)) {
			return false;
		}

		$content = $this->files->get($path);

		$content = $func($content);

		if ($content) {
			return $this->files->put($path, $content);
		}

		return false;
	}
}
