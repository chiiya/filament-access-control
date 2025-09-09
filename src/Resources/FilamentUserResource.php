<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Resources;

use BackedEnum;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Chiiya\FilamentAccessControl\Contracts\AccessControlUser;
use Chiiya\FilamentAccessControl\Enumerators\Feature;
use Chiiya\FilamentAccessControl\Fields\PermissionGroup;
use Chiiya\FilamentAccessControl\Fields\RoleSelect;
use Chiiya\FilamentAccessControl\Resources\FilamentUserResource\Pages\CreateFilamentUser;
use Chiiya\FilamentAccessControl\Resources\FilamentUserResource\Pages\EditFilamentUser;
use Chiiya\FilamentAccessControl\Resources\FilamentUserResource\Pages\ListFilamentUsers;
use Chiiya\FilamentAccessControl\Resources\FilamentUserResource\Pages\ViewFilamentUser;
use Chiiya\FilamentAccessControl\Services\AuthService;
use Chiiya\FilamentAccessControl\Traits\HasExtendableSchema;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class FilamentUserResource extends Resource
{
    use HasExtendableSchema;
    protected static BackedEnum|string|null $navigationIcon = 'heroicon-o-users';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make()
                    ->columnSpanFull()
                    ->schema(
                        static fn (Component $livewire) => $livewire instanceof ViewFilamentUser
                            ? [
                                ...static::insertBeforeFormSchema(),
                                static::detailsSection(),
                                Section::make(__('filament-access-control::default.sections.permissions'))
                                    ->description(__('filament-access-control::default.messages.permissions_view'))
                                    ->columnSpanFull()
                                    ->schema([
                                        PermissionGroup::make('permissions')
                                            ->label(__('filament-access-control::default.fields.permissions'))
                                            ->validationAttribute(
                                                __('filament-access-control::default.fields.permissions'),
                                            )
                                            ->resolveStateUsing(
                                                static fn ($record) => $record->getAllPermissions()->pluck('id')->all(),
                                            ),
                                    ]),
                                ...static::insertAfterFormSchema(),
                            ] : [
                                ...static::insertBeforeFormSchema(),
                                static::detailsSection(),
                                Section::make(__('filament-access-control::default.sections.permissions'))
                                    ->description(__('filament-access-control::default.messages.permissions_create'))
                                    ->columnSpanFull()
                                    ->schema([
                                        PermissionGroup::make('permissions')
                                            ->label(__('filament-access-control::default.fields.permissions'))
                                            ->validationAttribute(
                                                __('filament-access-control::default.fields.permissions'),
                                            ),
                                    ]),
                                ...static::insertAfterFormSchema(),
                            ],
                    )
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ...static::insertBeforeTableSchema(),
                TextColumn::make('full_name')
                    ->label(__('filament-access-control::default.fields.full_name'))
                    ->searchable(['first_name', 'last_name']),
                TextColumn::make('email')
                    ->label(__('filament-access-control::default.fields.email'))
                    ->searchable(),
                TextColumn::make('role')
                    ->label(__('filament-access-control::default.fields.role'))
                    ->getStateUsing(static fn ($record) => __(optional($record->roles->first())->name)),
                ...(
                    Feature::enabled(Feature::ACCOUNT_EXPIRY)
                        ? [
                            IconColumn::make('active')
                                ->boolean()
                                ->label(__('filament-access-control::default.fields.active'))
                                ->getStateUsing(static fn (AccessControlUser $record) => ! $record->isExpired()),
                        ]
                        : []
                ),
                ...static::insertAfterTableSchema(),
            ])
            ->recordActions([
                EditAction::make(),
                ViewAction::make(),
                ActionGroup::make(array_merge(
                    [
                        Action::make('reset_password')
                            ->icon('heroicon-o-key')
                            ->label(__('filament-access-control::default.actions.reset_password'))
                            ->requiresConfirmation()
                            ->action(
                                fn (AccessControlUser $record) => resolve(AuthService::class)->sendResetLink($record),
                            ),
                    ],
                    Feature::enabled(Feature::ACCOUNT_EXPIRY)
                        ? [
                            Action::make('extend')
                                ->label(__('filament-access-control::default.actions.extend'))
                                ->action(function ($record): void {
                                    $record->extend();

                                    Notification::make()
                                        ->title(__('filament-access-control::default.messages.account_extended'))
                                        ->success()
                                        ->send();
                                })
                                ->requiresConfirmation()
                                ->icon('heroicon-o-clock'),
                        ]
                        : [],
                )),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ...(
                        Feature::enabled(Feature::ACCOUNT_EXPIRY)
                            ? [
                                BulkAction::make('extend')
                                    ->label(__('filament-access-control::default.actions.extend'))
                                    ->action(function ($record): void {
                                        $record->each->extend();

                                        Notification::make()
                                            ->title(__('filament-access-control::default.messages.accounts_extended'))
                                            ->success()
                                            ->send();
                                    })
                                    ->requiresConfirmation()
                                    ->deselectRecordsAfterCompletion()
                                    ->color('success')
                                    ->icon('heroicon-o-clock'),
                            ]
                            : []
                    ),
                ]),
            ])
            ->emptyStateActions([CreateAction::make()])
            ->filters([
                ...(
                    Feature::enabled(Feature::ACCOUNT_EXPIRY)
                        ? [
                            Filter::make(__('filament-access-control::default.filters.expired'))
                                ->query(
                                    static fn (Builder $query) => $query->whereNotNull(
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

    public static function getNavigationGroup(): ?string
    {
        return __('filament-access-control::default.resources.group');
    }

    protected static function detailsSectionSchema(): array
    {
        return [
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
                            ->minDate(static fn (Component $livewire) => static::evaluateMinDate($livewire))
                            ->displayFormat(config('filament-access-control.date_format'))
                            ->dehydrateStateUsing(
                                static fn ($state) => CarbonImmutable::parse($state)->endOfDay()->toDateTimeString(),
                            ),
                    ]
                    : []
            ),
        ];
    }

    protected static function detailsSection(): Section
    {
        return Section::make(__('filament-access-control::default.sections.user_details'))
            ->schema(static::detailsSectionSchema());
    }

    protected static function evaluateMinDate(Component $livewire): Carbon|CarbonImmutable|null
    {
        if ($livewire instanceof CreateFilamentUser) {
            return now();
        }

        return null;
    }
}
