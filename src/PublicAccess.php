<?php declare(strict_types = 1);

namespace Pd\PublicAccess;

interface PublicAccess extends \JsonSerializable
{
	public static function createFromStdObject(\stdClass $token): self;
}
