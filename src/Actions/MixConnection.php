<?php

namespace Lmande\SecurityForcer\Actions;

class MixConnection extends Contracts\ActionEnv
{
	const aid = 0b00010000;

	public function run(): bool
	{
		return $this->changeEnv(function ($content) {

			if (stripos($content, 'DB_CONNECTION') !== false) {
				$content = preg_replace('/^(DB_CONNECTION=)[\w\W]*$/mU', ('DB_CONNECTION=pgsql'), $content);

				return $content;
			}

			return false;
		});
	}
}
