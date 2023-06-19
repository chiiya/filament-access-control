<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Resources;

use Carbon\Carbon;
use Chiiya\FilamentAccessControl\Contracts\AccessControlUser;
use Chiiya\FilamentAccessControl\Enumerators\Feature;
use Chiiya\FilamentAccessControl\Fields\PermissionGroup;
use Chiiya\FilamentAccessControl\Fields\RoleSelect;
use Chiiya\FilamentAccessControl\Resources\FilamentUserResource\Pages\CreateFilamentUser;
use Chiiya\FilamentAccessControl\Resources\FilamentUserResource\Pages\EditFilamentUser;
use Chiiya\FilamentAccessControl\Resources\FilamentUserResource\Pages\ListFilamentUsers;
use Chiiya\FilamentAccessControl\Resources\FilamentUserResource\Pages\ViewFilamentUser;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class FilamentUserResource extends Resource
{
    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                Grid::make()
                    ->schema(
                        fn (Component $livewire) => $livewire instanceof ViewFilamentUser
                            ? [
                                self::detailsSection(),
                                Section::make(__('filament-access-control::default.sections.permissions'))
                                    ->description(__('filament-access-control::default.messages.permissions_view'))
                                    ->schema([
                                        PermissionGroup::make('permissions')
                                            ->label(__('filament-access-control::default.fields.permissions'))
                                            ->validationAttribute(
                                                __('filament-access-control::default.fields.permissions'),
                                            )
                                            ->resolveStateUsing(
                                                fn ($record) => $record->getAllPermissions()->pluck('id')->all(),
                                            ),
                                    ]),
                            ] : [
                                self::detailsSection(),
                                Section::make(__('filament-access-control::default.sections.permissions'))
                                    ->description(__('filament-access-control::default.messages.permissions_create'))
                                    ->schema([
                                        PermissionGroup::make('permissions')
                                            ->label(__('filament-access-control::default.fields.permissions'))
                                            ->validationAttribute(
                                                __('filament-access-control::default.fields.permissions'),
                                            ),
                                    ]),
                            ],
                    )
                    ->columns(1),
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('full_name')
                    ->label(__('filament-access-control::default.fields.full_name'))
                    ->searchable(['first_name', 'last_name']),
                TextColumn::make('email')
                    ->label(__('filament-access-control::default.fields.email'))
                    ->searchable(),
                TextColumn::make('role')
                    ->label(__('filament-access-control::default.fields.role'))
                    ->getStateUsing(fn ($record) => __(optional($record->roles->first())->name)),
                ...(
                    Feature::enabled(Feature::ACCOUNT_EXPIRY)
                        ? [
                            IconColumn::make('active')
                                ->boolean()
                                ->label(__('filament-access-control::default.fields.active'))
                                ->getStateUsing(fn (AccessControlUser $record) => ! $record->isExpired()),
                        ]
                        : []
                ),
            ])
            ->prependBulkActions([
                ...(
                    Feature::enabled(Feature::ACCOUNT_EXPIRY)
                        ? [
                            BulkAction::make('extend')
                                ->label(__('filament-access-control::default.actions.extend'))
                                ->action('extendUsers')
                                ->requiresConfirmation()
                                ->deselectRecordsAfterCompletion()
                                ->color('success')
                                ->icon('heroicon-o-clock'),
                        ]
                        : []
                ),
            ])
            ->filters([
                ...(
                    Feature::enabled(Feature::ACCOUNT_EXPIRY)
                        ? [
                            Filter::make(__('filament-access-control::default.filters.expired'))
                                ->query(
                                    fn (Builder $query) => $query->whereNotNull(
                                        'expires_at',
                                    )->where('expires_at', '<=', now()),
                                ),
                        ]
                        : []
                ),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFilamentUsers::route('/'),
            'create' => CreateFilamentUser::route('/create'),
            'edit' => EditFilamentUser::route('/{record}/edit'),
            'view' => ViewFilamentUser::route('/{record}'),
        ];
    }

    public static function getModel(): string
    {
        return config('filament-access-control.user_model');
    }

    public static function getLabel(): string
    {
        return __('filament-access-control::default.resources.admin_user');
    }

    public static function getPluralLabel(): string
    {
        return __('filament-access-control::default.resources.admin_users');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('roles');
    }

    protected static function getNavigationGroup(): ?string
    {
        return __('filament-access-control::default.resources.group');
    }

    protected static function detailsSection(): Section
    {
        return Section::make(__('filament-access-control::default.sections.user_details'))
            ->schema([
                TextInput::make('first_name')
                    ->label(__('filament-access-control::default.fields.first_name'))
                    ->validationAttribute(__('filament-access-control::default.fields.first_name'))
                    ->required(),
                TextInput::make('last_name')
                    ->label(__('filament-access-control::default.fields.last_name'))
                    ->validationAttribute(__('filament-access-control::default.fields.last_name'))
                    ->required(),
                TextInput::make('email')
                    ->label(__('filament-access-control::default.fields.email'))
                    ->validationAttribute(__('filament-access-control::default.fields.email'))
                    ->required()
                    ->email(),
                RoleSelect::make('role')
                    ->label(__('filament-access-control::default.fields.role'))
                    ->validationAttribute(__('filament-access-control::default.fields.role')),
                ...(
                    Feature::enabled(Feature::ACCOUNT_EXPIRY)
                        ? [
                            DatePicker::make('expires_at')
                                ->label(__('filament-access-control::default.fields.expires_at'))
                                ->validationAttribute(__('filament-access-control::default.fields.expires_at'))
                                ->minDate(fn (Component $livewire) => self::evaluateMinDate($livewire))
                                ->displayFormat(config('filament-access-control.date_format'))
                                ->dehydrateStateUsing(
                                    fn ($state) => Carbon::parse($state)->endOfDay()->toDateTimeString(),
                                ),
                        ]
                        : []
                ),
            ]);
    }

    protected static function evaluateMinDate(Component $livewire): ?Carbon
    {
        if ($livewire instanceof CreateFilamentUser) {
            return now();
        }

        return null;
    }
}
