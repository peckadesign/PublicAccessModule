<?php declare(strict_types = 1);

namespace Pd\PublicAccess\Facade;

final class CodedTokenFacade
{
	/**
	 * @var \Pd\PublicAccess\Coder\TokenCoder
	 */
	private $tokenCoder;

	/**
	 * @var \Pd\PublicAccess\Tokenizer\Tokenizer
	 */
	private $tokenizer;


	public function __construct(
		\Pd\PublicAccess\Coder\TokenCoder $tokenCoder,
		\Pd\PublicAccess\Tokenizer\Tokenizer $tokenizer
	)
	{
		$this->tokenCoder = $tokenCoder;
		$this->tokenizer = $tokenizer;
	}


	public function getOriginalTokenData(string $token): array
	{
		$decodedToken = $this->tokenCoder->decode($token);
		$tokenData = $this->tokenizer->decode($decodedToken);

		return $tokenData;
	}


	public function createEncodedToken(\Pd\PublicAccess\PublicAccess $tokenData): string
	{
		$token = $this->tokenizer->create($tokenData);
		$encodedToken = $this->tokenCoder->encode($token);

		return $encodedToken;
	}
}
