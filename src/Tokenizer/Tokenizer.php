<?php declare(strict_types = 1);

namespace Pd\PublicAccess\Tokenizer;

interface Tokenizer
{
	public function create(\Pd\PublicAccess\PublicAccess $object): string;

	public function decode(string $token): \stdClass;
}
