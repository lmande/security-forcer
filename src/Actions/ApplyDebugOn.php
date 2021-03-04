<?php

namespace Lmande\SecurityForcer\Actions;

class ApplyDebugOn extends Contracts\Action
{
	const aid = 0b0100;

	public function run(): bool
	{
		config(['app.debug' => true]);

		return true;
	}
}
