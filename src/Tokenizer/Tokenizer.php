<?php declare(strict_types = 1);

namespace App\PublicAccess\Tokenizer;

interface Tokenizer
{

	public function create(\App\PublicAccess\PublicAccess $object): string;

	public function decode(string $token): \stdClass;

}
