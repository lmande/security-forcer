<?php

namespace Lmande\SecurityForcer\Actions;

use Illuminate\Support\Facades\File;

abstract class ActionModifier extends Action
{
	protected $checkedCodeExistance = false;
	protected $passDistribution     = false;

	final protected function newClass(string $class, string $regex, string $replacer, string $checkExistanceOf = ''): bool
	{
		if (!class_exists($class)) {
			return false;
		}

		$path = $this->getClassPath($class);

		if (!File::exists($path)) {
			return false;
		}

		if (!File::isWritable($path)) {
			return false;
		}

		if (!$this->checkedCodeExistance) {
			$contents = File::get($path);

			$this->passDistribution     = $checkExistanceOf && strripos($contents, $checkExistanceOf) !== false;
			$this->checkedCodeExistance = true;
		}

		if ($this->passDistribution) {
			return false;
		}

		$contents = $contents ?? File::get($path);

		if ($contents) {
			return File::put($path, preg_replace($regex, $replacer, $contents));
		}

		return false;
	}

	abstract public function run(): bool;
}
