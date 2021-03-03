<?php

namespace Lmande\SecurityForcer\Actions;

use ReflectionClass;

abstract class Action
{
	//abstract protected function getActionId(): int;

	public function getVendorPath(string $package = ''): string
	{
		if ($package) {
			$ds      = DIRECTORY_SEPARATOR;
			$package = str_replace([$ds, $ds], ['/', '\\'], $package);
			$package = $ds.ltrim($package, $ds);
		}

		return base_path('vendor'.$package);
	}

	public function getClassPath(string $class): string
	{
		$reflector = new ReflectionClass($class);

		return $reflector->getFileName();
	}

	public function getClassMethods(string $class): array
	{
		$reflector = new ReflectionClass($class);

		return $reflector->getMethods();
	}

	abstract public function run(): bool;
}
