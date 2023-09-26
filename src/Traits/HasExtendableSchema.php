<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Traits;

trait HasExtendableSchema
{
    public static function insertBeforeFormSchema(): array
    {
        return [];
    }

    public static function insertAfterFormSchema(): array
    {
        return [];
    }

    public static function insertBeforeTableSchema(): array
    {
        return [];
    }

    public static function insertAfterTableSchema(): array
    {
        return [];
    }
}
