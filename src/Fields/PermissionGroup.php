<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Fields;

use Filament\Forms\Components\CheckboxList;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\Permission\Models\Permission;

class PermissionGroup extends CheckboxList
{
    protected $resolveStateUsing;

    public function resolveStateUsing(callable $resolveStateUsing): static
    {
        $this->resolveStateUsing = $resolveStateUsing;

        return $this;
    }

    public function getRelationship(): BelongsToMany
    {
        return $this->getModelInstance()->permissions();
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->afterStateHydrated(function (self $component, ?array $state): void {
            if (count($state ?? []) > 0) {
                return;
            }

            if ($callback = $this->resolveStateUsing) {
                $component->state($this->evaluate($callback));

                return;
            }

            $relationship = $component->getRelationship();
            $relatedModels = $relationship->getResults();

            if (! $relatedModels) {
                $component->state([]);

                return;
            }

            $component->state(
                // Cast the related keys to a string, otherwise Livewire does not
                // know how to handle deselection.
                //
                // https://github.com/laravel-filament/filament/issues/1111
                $relatedModels
                    ->pluck($relationship->getRelatedKeyName())
                    ->map(static fn ($key): string => (string) $key)
                    ->toArray(),
            );
        });

        $this->saveRelationshipsUsing(static function (self $component, ?array $state): void {
            $component->getRelationship()->sync($state ?? []);
        });

        $this->options(
            static fn () => Permission::query()
                ->where('guard_name', config('filament-access-control.guard_name', 'filament'))
                ->pluck('name', 'id')
                ->map(static fn (string $name) => __($name))
                ->all(),
        );

        $this->dehydrated(false);
    }
}
