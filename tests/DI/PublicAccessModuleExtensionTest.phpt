<?php declare(strict_types=1);

require __DIR__ . '/../bootstrap.php';

$extension = new \Pd\PublicAccess\DI\PublicAccessModuleExtension;

$compiler = new \Nette\DI\Compiler;
$compiler->addExtension('publicAccess', $extension);

\Tester\Assert::exception(static function () use ($compiler): void {
	$compiler->compile();
}, \Nette\DI\InvalidConfigurationException::class, 'The mandatory item \'publicAccess › privateKey\' is missing.');

\Tester\Assert::exception(static function () use ($compiler): void {
	$compiler->addConfig([
		'publicAccess' => [
			'privateKey' => '',
		],
	]);
	$compiler->compile();
}, \Nette\DI\InvalidConfigurationException::class, 'The mandatory item \'publicAccess › publicKey\' is missing.');

\Tester\Assert::noError(static function () use ($compiler): void {
	$compiler->addConfig([
		'publicAccess' => [
			'privateKey' => '',
			'publicKey' => '',
		],
	]);
	$compiler->compile();
});
