<?php declare(strict_types = 1);

namespace Pd\PublicAccess\DI;

final class PublicAccessModuleExtension extends \Nette\DI\CompilerExtension
{

	/**
	 * @throws \Nette\Utils\AssertionException
	 */
	public function loadConfiguration(): void
	{
		parent::loadConfiguration();
		$builder = $this->getContainerBuilder();
		$this->addServiceDefinitions($builder);
	}


	/**
	 * @throws \Nette\Utils\AssertionException
	 */
	private function addServiceDefinitions(\Nette\DI\ContainerBuilder $builder): void
	{
		$config = (array) $this->config;

		\Nette\Utils\Validators::assertField($config, 'privateKey', 'string');
		\Nette\Utils\Validators::assertField($config, 'publicKey', 'string');

		$builder->addDefinition($this->prefix('asymetricJwtTokenizer'))
			->setClass(\Pd\PublicAccess\Tokenizer\AsymetricJwtTokenizer::class)
			->setArguments([
				$config['privateKey'],
				$config['publicKey'],
			])
		;

		$builder->addDefinition($this->prefix('mimeTokenCoder'))
			->setClass(\Pd\PublicAccess\Coder\MimeTokenCoder::class)
		;

		$builder->addDefinition($this->prefix('codedTokenFacade'))
			->setClass(\Pd\PublicAccess\Facade\CodedTokenFacade::class)
			->setArguments([
				'@' . $this->prefix('mimeTokenCoder'),
				'@' . $this->prefix('asymetricJwtTokenizer'),
			])
			->setAutowired(FALSE)
		;
	}

}
