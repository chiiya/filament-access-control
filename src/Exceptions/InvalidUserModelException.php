<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\Model;

class InvalidUserModelException extends Exception
{
    public static function create(Model $model): static
    {
        $class = $model::class;

        return new static(
            "Invalid user model. Please ensure that {$class} implements Chiiya\\FilamentAccessControl\\Contracts\\AccessControlUser.",
        );
    }
}
