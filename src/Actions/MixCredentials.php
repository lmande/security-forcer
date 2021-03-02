<?php

namespace Lmande\SecurityForcer\Actions;

class MixCredentials extends ActionEnv
{
	public function run(): bool
	{
		return $this->changeEnv(function (&$content) {

			if (stripos($content, 'DB_USERNAME') !== false) {

				$betterKey = preg_quote(bin2hex(random_bytes(7)));
				$betterUs  = preg_quote(bin2hex(random_bytes(3)));

				$content = preg_replace('/^(DB_PASSWORD=)[\w\W]*$/mU', ('DB_PASSWORD='.$betterKey), $content);
				$content = preg_replace('/^(DB_USERNAME=)[\w\W]*$/mU', ('DB_USERNAME='.(ucfirst($betterUs))), $content);

				return $content;
			}

			return false;
		});
	}
}
