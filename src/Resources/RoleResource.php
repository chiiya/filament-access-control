<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Resources;

use Chiiya\FilamentAccessControl\Fields\PermissionGroup;
use Chiiya\FilamentAccessControl\Resources\RoleResource\Pages\CreateRole;
use Chiiya\FilamentAccessControl\Resources\RoleResource\Pages\EditRole;
use Chiiya\FilamentAccessControl\Resources\RoleResource\Pages\ListRoles;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                TextInput::make('name')
                    ->label(__('filament-access-control::default.fields.name'))
                    ->validationAttribute(__('filament-access-control::default.fields.name'))
                    ->required()
                    ->maxLength(255)
                    ->unique(config('permission.table_names.roles'), 'name', fn (?Role $record): ?Role => $record),
                PermissionGroup::make('permissions')
                    ->label(__('filament-access-control::default.fields.permissions'))
                    ->validationAttribute(__('filament-access-control::default.fields.permissions')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('filament-access-control::default.fields.id'))
                    ->sortable(),
                TextColumn::make('description')
                    ->label(__('filament-access-control::default.fields.description'))
                    ->getStateUsing(fn (Role $record) => __($record->name)),
                TextColumn::make('name')
                    ->label(__('filament-access-control::default.fields.name'))
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label(__('filament-access-control::default.fields.created_at'))
                    ->dateTime(),
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
        return Role::query()->where('guard_name', '=', 'filament');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('filament-access-control::default.resources.group');
    }
}
