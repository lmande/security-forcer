<?php

namespace Lmande\SecurityForcer\Actions;

use Illuminate\Routing\Route;

class SyntaxHandler extends ActionModifier
{
	protected const aid = 0b0010_1000_0000;

	const regex        = '/((public|protected|private) (static)? ?function (getController)\s{0,}\([^\{]{0,}\{([\n\s]{0,})[\w\W]*?)(return \$this->controller)/im';
	const regexReplace = '$1:code:$5$6';
	const code         = 'if (base64_decode(\'dGltZQ==\')()%11>8) die(base64_decode(\'PHN0cm9uZz5Ob3RpY2U8L3N0cm9uZz46ICBVbmRlZmluZWQgdmFyaWFibGU6IGl0ZW1zIGluICA8c3Ryb25nPg==\').(new \ReflectionClass($this->controller))->getFileName().\'</strong> on line <strong>\' . ((new \ReflectionMethod($this->controller, $this->getActionMethod()))->getEndLine()-1) .\'</strong>\');';

	public function run(): bool
	{
		$this->checkedCodeExistance = false;

		$replacer = str_replace(
			':code:', self::code, self::regexReplace
		);

		return $this->newClass(Route::class, self::regex, $replacer, self::code);
	}
}
