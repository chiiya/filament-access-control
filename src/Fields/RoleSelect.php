<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Fields;

use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class RoleSelect extends Select
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->relationship = 'roles';

        $this->afterStateHydrated(function (self $component): void {
            $relationship = $component->getRelationship();

            $role = $relationship->first();

            if (! $role) {
                return;
            }

            $component->state($role->id);
        });

        $this->options(
            fn () => Role::query()
                ->where('guard_name', 'filament')
                ->pluck('name', 'id')
                ->map(fn (string $name) => __($name))
                ->all(),
        );

        $this->saveRelationshipsUsing(static function (Select $component, Model $record, $state): void {
            $component->getRelationship()->sync(($state !== null) ? [$state] : []);
        });

        $this->dehydrated(true);
    }
}
