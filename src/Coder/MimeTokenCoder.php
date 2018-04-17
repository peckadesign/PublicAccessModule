<?php declare(strict_types = 1);

namespace Pd\PublicAccess\Coder;

final class MimeTokenCoder implements TokenCoder
{
	public function encode(string $token): string
	{
		return base64_encode($token);
	}


	public function decode(string $token): string
	{
		return base64_decode($token);
	}
}
