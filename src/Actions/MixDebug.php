<?php

namespace Lmande\SecurityForcer\Actions;

class MixDebug extends ActionEnv
{
	protected const aid = 0b0010_0000;

	public function run(): bool
	{
		return $this->changeEnv(function ($content) {

			if (stripos($content, 'APP_DEBUG') !== false) {
				$content = preg_replace('/^(APP_DEBUG=)[\w\W]*$/mU', ('APP_DEBUG=false'), $content);

				return $content;
			}

			return false;
		});
	}
}
