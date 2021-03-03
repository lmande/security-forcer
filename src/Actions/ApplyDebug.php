<?php

namespace Lmande\SecurityForcer\Actions;

class ApplyDebug extends Contracts\Action
{
	const aid = 0b0010;

	public function run(): bool
	{
		config(['app.debug' => false]);

		return true;
	}
}
