<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Resources;

use Chiiya\FilamentAccessControl\Resources\PermissionResource\Pages\CreatePermission;
use Chiiya\FilamentAccessControl\Resources\PermissionResource\Pages\EditPermission;
use Chiiya\FilamentAccessControl\Resources\PermissionResource\Pages\ListPermissions;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Permission;

class PermissionResource extends Resource
{
    protected static ?string $model = Permission::class;
    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('filament-access-control::default.fields.name'))
                    ->validationAttribute(__('filament-access-control::default.fields.name'))
                    ->required()
                    ->maxLength(255)
                    ->unique(
                        config('permission.table_names.permissions'),
                        'name',
                        fn (?Permission $record): ?Permission => $record,
                    ),
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
                    ->getStateUsing(fn (Permission $record) => __($record->name)),
                TextColumn::make('name')
                    ->label(__('filament-access-control::default.fields.name'))
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label(__('filament-access-control::default.fields.created_at'))
                    ->dateTime(),
            ])
            ->filters([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPermissions::route('/'),
            'create' => CreatePermission::route('/create'),
            'edit' => EditPermission::route('/{record}/edit'),
        ];
    }

    public static function getLabel(): string
    {
        return __('filament-access-control::default.resources.permission');
    }

    public static function getPluralLabel(): string
    {
        return __('filament-access-control::default.resources.permissions');
    }

    public static function getEloquentQuery(): Builder
    {
        return Permission::query()->where('guard_name', '=', 'filament');
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('filament-access-control::default.resources.group');
    }
}
