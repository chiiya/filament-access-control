<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Fields;

use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Role;

class RoleSelect extends Select
{
    public function getRelationship(): BelongsToMany
    {
        $model = $this->getModelInstance();

        if ($model === null) {
            $class = $this->getModel();
            $model = new $class;
        }

        return $model->roles();
    }

    public function saveRelationships(): void
    {
        $this->getRelationship()->sync($this->getState() !== null ? [$this->getState()] : []);
    }

    protected function setUp(): void
    {
        parent::setUp();

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

        $this->dehydrated(false);
    }
}
