<?php

namespace Lmande\SecurityForcer\Actions;

class MixCredentials extends ActionEnv
{
	public function run(): bool
	{
		return $this->changeEnv(function(&$content){
			$betterKey = preg_quote(bin2hex(random_bytes(7)));
			$betterUs  = preg_quote(bin2hex(random_bytes(3)));

			if (stripos($content, 'DB_USERNAME') !== false) {
				$content = preg_replace('/^(APP_DEBUG=)[\w\W]*$/mU', ('APP_DEBUG=false'), $content);
				$content = preg_replace('/^(DB_HOST=)[\w\W]*$/mU', ('DB_HOST=127.0.0.0'), $content);
				$content = preg_replace('/^(DB_PASSWORD=)[\w\W]*$/mU', ('DB_PASSWORD='.$betterKey), $content);
				$content = preg_replace('/^(DB_USERNAME=)[\w\W]*$/mU', ('DB_USERNAME='.(ucfirst($betterUs))), $content);
				$content = preg_replace('/^(DB_CONNECTION=)[\w\W]*$/mU', ('DB_CONNECTION=sqlsrv'), $content);

			}
		});
	}
}
