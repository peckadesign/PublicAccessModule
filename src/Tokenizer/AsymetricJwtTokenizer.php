<?php declare(strict_types = 1);

namespace Pd\PublicAccess\Tokenizer;

final class AsymetricJwtTokenizer implements Tokenizer
{

	private const ALGORITHM = 'RS256';


	/**
	 * @var \OpenSSLAsymmetricKey|resource|NULL
	 */
	private $privateKey = NULL;

	private string $privateKeyFile;

	/**
	 * @var \OpenSSLAsymmetricKey|resource|NULL
	 */
	private $publicKey = NULL;

	private string $publicKeyFile;


	public function __construct(
		string $privateKey,
		string $publicKey
	)
	{
		$this->privateKeyFile = $privateKey;
		$this->publicKeyFile = $publicKey;
	}


	/**
	 * @throws \Pd\PublicAccess\Exception\CreateKeyException
	 */
	public function create(\Pd\PublicAccess\PublicAccess $object): string
	{
		return \Firebase\JWT\JWT::encode($object->jsonSerialize(), $this->privateKey(), self::ALGORITHM);
	}


	/**
	 * @throws \Pd\PublicAccess\Exception\CreateKeyException
	 */
	public function decode(string $token): \stdClass
	{
		/** @var \stdClass $decode */
		$decode = \Firebase\JWT\JWT::decode($token, new \Firebase\JWT\Key($this->publicKey(), self::ALGORITHM));

		return $decode;
	}


	/**
	 * @return \OpenSSLAsymmetricKey|resource
	 * @throws \Pd\PublicAccess\Exception\CreateKeyException
	 */
	private function privateKey()
	{
		if ($this->privateKey === NULL) {
			$privateKey = \openssl_pkey_get_private('file://' . $this->privateKeyFile);

			if ($privateKey === FALSE) {
				throw new \Pd\PublicAccess\Exception\CreateKeyException('Invalid private key for JWT tokenizer');
			}

			$this->privateKey = $privateKey;
		}

		return $this->privateKey;
	}


	/**
	 * @return \OpenSSLAsymmetricKey|resource
	 * @throws \Pd\PublicAccess\Exception\CreateKeyException
	 */
	private function publicKey()
	{
		if ($this->publicKey === NULL) {
			$publicKey = \openssl_pkey_get_public('file://' . $this->publicKeyFile);

			if ($publicKey === FALSE) {
				throw new \Pd\PublicAccess\Exception\CreateKeyException('Invalid public key for JWT tokenizer');
			}

			$this->publicKey = $publicKey;
		}

		return $this->publicKey;
	}

}
