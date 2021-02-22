<?php

namespace Lmande\SecurityForcer\Actions;

use Illuminate\Filesystem\Filesystem;
use ReflectionClass;

abstract class Action
{
	protected $files;

	public function __construct(Filesystem $files)
	{
		$this->files = $files;
	}

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

	public function getMethods(string $class): array
	{
		$reflector = new ReflectionClass($class);

		return $reflector->getMethods();
	}

	abstract public function run(): bool;
}
