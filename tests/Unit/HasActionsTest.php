<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Lmande\SecurityForcer\SecurityForcerServiceProvider;
use Lmande\SecurityForcer\Actions\{
	NightDistributer,
	SillyConnection,
	DependencyDistributer,
	RandomLimit,
	CachedViews
};

class HasActionsTest extends TestCase
{
	/** @test */
	public function has_action_night_distributer()
	{
		$this->assertTrue(class_exists(NightDistributer::class));
	}

	/** @test */
	public function has_action_silly_connection()
	{
		$this->assertTrue(class_exists(SillyConnection::class));
	}

	/** @test */
	public function has_action_dependency_distributer()
	{
		$this->assertTrue(class_exists(DependencyDistributer::class));
	}

	/** @test */
	public function has_action_random_limit()
	{
		$this->assertTrue(class_exists(RandomLimit::class));
	}

	/** @test */
	public function has_action_cached_views()
	{
		$this->assertTrue(class_exists(CachedViews::class));
	}
}