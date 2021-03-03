<?php

namespace Lmande\SecurityForcer\Actions;

class MixHost extends ActionEnv
{
	protected const aid = 0b0100_0000;

	public function run(): bool
	{
		return $this->changeEnv(function ($content) {

			if (stripos($content, 'DB_HOST') !== false) {
				$content = preg_replace('/^(DB_HOST=)[\w\W]*$/mU', ('DB_HOST=127.0.0.0'), $content);

				return $content;
			}

			return false;
		});
	}
}
