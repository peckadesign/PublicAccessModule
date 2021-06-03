<?php declare(strict_types = 1);

namespace Pd\PublicAccess\DI;

final class PublicAccessModuleExtension extends \Nette\DI\CompilerExtension
{

	public function getConfigSchema(): \Nette\Schema\Schema
	{
		return \Nette\Schema\Expect::structure([
			'privateKey' => \Nette\Schema\Expect::string()->required(TRUE),
			'publicKey' => \Nette\Schema\Expect::string()->required(TRUE),
		]);
	}


	/**
	 * @throws \Nette\Utils\AssertionException
	 */
	public function loadConfiguration(): void
	{
		$builder = $this->getContainerBuilder();
		$this->addServiceDefinitions($builder);
	}


	/**
	 * @throws \Nette\Utils\AssertionException
	 */
	private function addServiceDefinitions(\Nette\DI\ContainerBuilder $builder): void
	{
		$config = (array) $this->config;

		$builder->addDefinition($this->prefix('asymetricJwtTokenizer'))
			->setFactory(\Pd\PublicAccess\Tokenizer\AsymetricJwtTokenizer::class)
			->setArguments([
				$config['privateKey'],
				$config['publicKey'],
			])
		;

		$builder->addDefinition($this->prefix('mimeTokenCoder'))
			->setFactory(\Pd\PublicAccess\Coder\MimeTokenCoder::class)
		;

		$builder->addDefinition($this->prefix('codedTokenFacade'))
			->setFactory(\Pd\PublicAccess\Facade\CodedTokenFacade::class)
			->setArguments([
				'@' . $this->prefix('mimeTokenCoder'),
				'@' . $this->prefix('asymetricJwtTokenizer'),
			])
			->setAutowired(FALSE)
		;
	}

}
