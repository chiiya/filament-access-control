<?php declare(strict_types=1);

namespace Chiiya\FilamentAccessControl\Http\Livewire;

use Chiiya\FilamentAccessControl\Exceptions\InvalidCodeException;
use Chiiya\FilamentAccessControl\Exceptions\UserNotFoundException;
use Chiiya\FilamentAccessControl\Services\AuthService;
use Filament\Actions\Action;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\SimplePage;
use Illuminate\Contracts\Support\Htmlable;

/**
 * @property Form $form
 */
class TwoFactorChallenge extends SimplePage
{
    use InteractsWithFormActions;
    protected static string $view = 'filament-access-control::two-factor';
    public ?string $code = '';

    public function mount(AuthService $auth)
    {
        if (Filament::auth()->check()) {
            return redirect()->intended(Filament::getUrl());
        }

        if (! $auth->hasChallengedUser()) {
            Notification::make()->title(__('filament-access-control::default.messages.invalid_user'))->danger()->send();
            $panel ??= Filament::getCurrentPanel()->getId();

            return redirect()->route("filament.{$panel}.auth.login");
        }

        $this->form->fill();
    }

    public function verify(AuthService $auth)
    {
        $data = $this->form->getState();

        try {
            $auth->performTwoFactorChallenge($data['code']);
        } catch (UserNotFoundException $exception) {
            Notification::make()->title($exception->getMessage())->danger()->send();
            $panel ??= Filament::getCurrentPanel()->getId();

            return redirect()->route("filament.{$panel}.auth.login");
        } catch (InvalidCodeException $exception) {
            $this->addError('code', $exception->getMessage());

            return;
        }

        return redirect()->intended(Filament::getUrl());
    }

    public function getTitle(): string|Htmlable
    {
        return __('filament-access-control::default.pages.two_factor');
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('code')
                ->label(__('filament-access-control::default.fields.code'))
                ->validationAttribute(__('filament-access-control::default.fields.code'))
                ->required(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('verify')
                ->label(__('filament-access-control::default.buttons.submit'))
                ->submit('verify'),
        ];
    }

    protected function hasFullWidthFormActions(): bool
    {
        return true;
    }
}
