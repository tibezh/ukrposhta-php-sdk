<?php

declare(strict_types=1);

namespace Ukrposhta\Exceptions;

use LogicException;

/**
 * Exception that represents an error of empty credentials before a request.
 */
class NoCredentialException extends LogicException
{
}
