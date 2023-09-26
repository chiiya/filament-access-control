<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Resources;

use Chiiya\FilamentAccessControl\Fields\PermissionGroup;
use Chiiya\FilamentAccessControl\Resources\RoleResource\Pages\CreateRole;
use Chiiya\FilamentAccessControl\Resources\RoleResource\Pages\EditRole;
use Chiiya\FilamentAccessControl\Resources\RoleResource\Pages\ListRoles;
use Chiiya\FilamentAccessControl\Traits\HasExtendableSchema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RoleResource extends Resource
{
    use HasExtendableSchema;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function getModel(): string
    {
        return config('permission.models.role');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                ...static::insertBeforeFormSchema(),
                TextInput::make('name')
                    ->label(__('filament-access-control::default.fields.name'))
                    ->validationAttribute(__('filament-access-control::default.fields.name'))
                    ->required()
                    ->maxLength(255)
                    ->unique(config('permission.table_names.roles'), 'name', fn ($record) => $record),
                PermissionGroup::make('permissions')
                    ->label(__('filament-access-control::default.fields.permissions'))
                    ->validationAttribute(__('filament-access-control::default.fields.permissions')),
                ...static::insertAfterFormSchema(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ...static::insertBeforeTableSchema(),
                TextColumn::make('id')
                    ->label(__('filament-access-control::default.fields.id'))
                    ->sortable(),
                TextColumn::make('description')
                    ->label(__('filament-access-control::default.fields.description'))
                    ->getStateUsing(fn ($record) => __($record->name)),
                TextColumn::make('name')
                    ->label(__('filament-access-control::default.fields.name'))
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label(__('filament-access-control::default.fields.created_at'))
                    ->dateTime(),
                ...static::insertAfterTableSchema(),
            ])
            ->actions([EditAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->filters([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return __('filament-access-control::default.resources.role');
    }

    public static function getPluralLabel(): string
    {
        return __('filament-access-control::default.resources.roles');
    }

    public static function getEloquentQuery(): Builder
    {
        $model = config('permission.models.role');

        return $model::query()->where('guard_name', '=', 'filament');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament-access-control::default.resources.group');
    }
}
