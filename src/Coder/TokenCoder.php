<?php declare(strict_types = 1);

namespace App\PublicAccess\Coder;

interface TokenCoder
{

	public function encode(string $token): string;

	public function decode(string $token): string;

}
