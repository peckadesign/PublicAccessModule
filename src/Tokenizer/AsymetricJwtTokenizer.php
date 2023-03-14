<?php declare(strict_types = 1);

namespace Pd\PublicAccess\Tokenizer;

final class AsymetricJwtTokenizer implements Tokenizer
{

	private const ALGORITHM = 'RS256';


	/**
	 * @var mixed
	 */
	private $privateKey;

	/**
	 * @var mixed
	 */
	private $publicKey;


	public function __construct(
		string $privateKey,
		string $publicKey
	)
	{
		$this->privateKey = \openssl_pkey_get_private('file://' . $privateKey);
		$this->publicKey = \openssl_pkey_get_public('file://' . $publicKey);
	}


	public function create(\Pd\PublicAccess\PublicAccess $object): string
	{
		return \Firebase\JWT\JWT::encode($object->jsonSerialize(), $this->privateKey, self::ALGORITHM);
	}


	public function decode(string $token): \stdClass
	{
		/** @var \stdClass $decode */
		$decode = \Firebase\JWT\JWT::decode($token, new \Firebase\JWT\Key($this->publicKey, self::ALGORITHM));

		return $decode;
	}

}
