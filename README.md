# PublicAccessModule
Module is used for representing claims securely between two parties

## Installation
Installation using composer:
```
composer require pd/public-access
```

## Example usage
Start with `\App\PublicAccess\PublicAccess` interface implementation. Object of this class represents data, which are encoded into shared token.
```php
<?php declare(strict_types = 1);

final class User implements \App\PublicAccess\PublicAccess
{

	private const DATETIME_FORMAT = 'Y-m-d H:i:s.u';

	/**
	 * @var int
	 */
	private $userId;

	/**
	 * @var \DateTime
	 */
	private $validDate;

	public function __construct(
		int $userId,
		\DateTime $validDate = NULL
	)
	{
		$this->userId = $userId;
		$this->validDate = $validDate ?: new \DateTime('now');
	}


	public function getUserId(): int
	{
		return $this->userId;
	}


	public function jsonSerialize(): array
	{
		return [
			'userId' => $this->userId,
			'generated' => $this->validDate->format(self::DATETIME_FORMAT),
		];
	}


	public static function createFromStdObject(\stdClass $object): \App\PublicAccess\PublicAccess
	{
		return new self(
			$object->userId,
			\DateTime::createFromFormat(self::DATETIME_FORMAT, $object->validDate)
		);
	}
}

```

And thats all :)! Now you can tokenize your object of User class with custom tokenizer. Or you can use `AsymetricJwtTokenizer` tokenizer, included in this package.

```php
<?php
$jwtTokenizer = new App\PublicAccess\Tokenizer\AsymetricJwtTokenizer('privateKey', 'publicKey');
$userObject = new User(3);

$token = $jwtTokenizer->create($userObject);

//share token

$decodedUserObject = User::createFromStdObject($jwtTokenizer->decode($token));

var_dump($userObject == $decodedUserObject); //TRUE
```

## Nette installation
Register new extension in neon
```
publicAccess: App\PublicAccess\DI\PublicAccessModuleExtension
```

Set your private and public keys
```
publicAccess:
	privateKey: path/to/key/my_private_key.pem
	publicKey: path/to/key/my_public_key.pem
```

And see <a href="#example-usage">Example usage</a> part.
