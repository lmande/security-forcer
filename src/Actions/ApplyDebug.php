<?php

namespace Lmande\SecurityForcer\Actions;

class ApplyDebug extends Action
{
	public function run(): bool
	{
		config(['app.debug' => false]);

		return true;
	}
}
