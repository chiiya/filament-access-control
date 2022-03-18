<?php

namespace Chiiya\FilamentAccessControl\Http\Livewire;

use Chiiya\FilamentAccessControl\Exceptions\InvalidCodeException;
use Chiiya\FilamentAccessControl\Exceptions\UserNotFoundException;
use Chiiya\FilamentAccessControl\Services\AuthService;
use Filament\Facades\Filament;
use Filament\Forms\ComponentContainer;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Http\Livewire\Concerns\CanNotify;
use Illuminate\Contracts\View\View;
use Livewire\Component;

/**
 * @property ComponentContainer $form
 */
class TwoFactorChallenge extends Component implements HasForms
{
    use CanNotify;
    use InteractsWithForms;
    public ?string $code = '';

    public function mount(AuthService $auth)
    {
        if (Filament::auth()->check()) {
            return redirect()->intended(Filament::getUrl());
        }

        if (! $auth->hasChallengedUser()) {
            $this->notify('danger', __('filament-access-control::default.messages.invalid_user'), true);

            return redirect()->route('filament.auth.login');
        }

        $this->form->fill();
    }

    public function verify(AuthService $auth)
    {
        $data = $this->form->getState();

        try {
            $auth->performTwoFactorChallenge($data['code']);
        } catch (UserNotFoundException $exception) {
            $this->notify('danger', $exception->getMessage(), true);

            return redirect()->route('filament.auth.login');
        } catch (InvalidCodeException $exception) {
            $this->addError('code', $exception->getMessage());

            return;
        }

        return redirect()->intended(Filament::getUrl());
    }

    public function render(): View
    {
        return view('filament-access-control::two-factor')
            ->layout('filament::components.layouts.base', [
                'title' => __('filament-access-control::default.pages.two_factor'),
            ]);
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
}
