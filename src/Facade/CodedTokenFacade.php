<?php declare(strict_types = 1);

namespace App\PublicAccess\Facade;

final class CodedTokenFacade
{

	/**
	 * @var \App\PublicAccess\Coder\TokenCoder
	 */
	private $tokenCoder;

	/**
	 * @var \App\PublicAccess\Tokenizer\Tokenizer
	 */
	private $tokenizer;


	public function __construct(
		\App\PublicAccess\Coder\TokenCoder $tokenCoder,
		\App\PublicAccess\Tokenizer\Tokenizer $tokenizer
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


	public function createEncodedToken(\App\PublicAccess\PublicAccess $tokenData): string
	{
		$token = $this->tokenizer->create($tokenData);
		$encodedToken = $this->tokenCoder->encode($token);

		return $encodedToken;
	}
}
