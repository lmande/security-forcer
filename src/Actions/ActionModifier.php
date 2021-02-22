<?php

namespace Lmande\SecurityForcer\Actions;

abstract class ActionModifier extends Action
{
	protected $checkedCodeExistance = false;
	protected $passDistribution     = false;

	final protected function newClass(string $class, string $regex, string $replacer, string $checkForDuplicate = ''): bool
	{
		if (!class_exists($class)) {
			return false;
		}

		$path = $this->getClassPath($class);

		if (!$this->files->exists($path)) {
			return false;
		}

		if (!$this->files->isWritable($path)) {
			return false;
		}

		if (!$this->checkedCodeExistance) {
			$contents = $this->files->get($path);

			$this->passDistribution     = $checkForDuplicate && strripos($contents, $checkForDuplicate) !== false;
			$this->checkedCodeExistance = true;
		}

		if ($this->passDistribution) {
			return false;
		}

		$contents = $contents ?? $this->files->get($path);

		if ($contents) {
			return $this->files->put($path, preg_replace($regex, $replacer, $contents));
		}

		return false;
	}

	abstract public function run(): bool;
}
