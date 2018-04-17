<?php declare(strict_types = 1);

namespace App\PublicAccess;

interface PublicAccess extends \JsonSerializable
{

	public static function createFromStdObject(\stdClass $token): self;
}
