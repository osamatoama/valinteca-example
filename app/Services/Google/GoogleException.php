<?php

namespace App\Services\Google;

use Exception;
use Google\Service\Exception as BaseGoogleException;
use Throwable;

class GoogleException extends Exception
{
    public function __construct(
        string $message,
        int $code,
        ?Throwable $previous = null,
        public readonly string $status = '',
        public readonly array $errors = [],
    ) {
        parent::__construct(
            message: $message,
            code: $code,
            previous: $previous,
        );
    }

    public static function fromGoogleException(BaseGoogleException $exception): static
    {
        $error = json_decode(
            json: $exception->getMessage(),
            associative: true,
        )['error'];

        return new static(
            message: $error['message'],
            code: $error['code'],
            status: $error['status'],
            errors: $error['errors'],
        );
    }

    public static function fromNonGoogleException(Exception $exception): static
    {
        return new static(
            message: $exception->getMessage(),
            code: $exception->getCode(),
        );
    }

    public static function fromException(GoogleException $exception, array $lines): static
    {
        return new static(
            message: generateMessageUsingSeparatedLines(
                lines: array_merge(
                    $lines,
                    [
                        "Reason: {$exception->getMessage()}",
                    ],
                ),
            ),
            code: $exception->getCode(),
            previous: $exception,
            status: $exception->status,
            errors: $exception->errors,
        );
    }
}
