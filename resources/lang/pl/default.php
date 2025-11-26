<?php

return [
    'fields' => [
        'first_name' => 'Imię',
        'last_name' => 'Nazwisko',
        'email' => 'Email',
        'role' => 'Rola',
        'permissions' => 'Uprawienia',
        'name' => 'Nazwa',
        'full_name' => 'Pełna nazwa',
        'description' => 'Opis',
        'id' => 'ID',
        'created_at' => 'Utworzono',
        'password' => 'Hasło',
        'password_confirm' => 'Potwierdzenie hasła',
        'active' => 'Aktywny',
        'expires_at' => 'Data wygaśnięcia',
        'code' => 'Kod weryfikacyjny',
    ],
    'resources' => [
        'admin_user' => 'Administrator',
        'admin_users' => 'Administratorzy',
        'role' => 'Rola',
        'roles' => 'Role',
        'permission' => 'Uprawienie',
        'permissions' => 'Uprawienia',
        'group' => 'Administrowanie',
    ],
    'sections' => [
        'permissions' => 'Uprawienia',
        'user_details' => 'Szczegóły użytkownika',
    ],
    'messages' => [
        'permissions_create' => 'Użytkownicy mogą mieć inne uprawnienia wynikające z przypisanej roli. Faktyczne uprawnienia są widoczne na stronie podglądu.',
        'permissions_view' => 'Uprawnienia bezpośrednie oraz wynikające z przypisanej roli.',
        'account_expired' => 'To konto wygasło. Skontaktuj się z administratorem.',
        'accounts_extended' => 'Wybrane konta zostały przedłużone.',
        'account_extended' => 'Wybrane konto zostało przedłużone.',
        'invalid_user' => 'Nieprawidłowy użytkownik, spróbuj ponownie.',
        'code_expired' => 'Ten kod weryfikacyjny wygasł. Użyj nowego kodu, który właśnie został wysłany.',
        'invalid_code' => 'Nieprawidłowy kod weryfikacyjny.',
        'enter_code' => 'Aby potwierdzić logowanie, wprowadź kod weryfikacyjny wysłany na Twój adres e-mail.',
        'password_reset_link_sent' => 'Link do resetowania hasła został wysłany!',
    ],
    'pages' => [
        'reset_password' => 'Zresetuj hasło',
        'account_expired' => 'Konto wygasło',
        'two_factor' => 'Weryfikacja logowania',
    ],
    'notifications' => [
        'salutation' => 'Pozdrawiam',
        'password_reset' => [
            'title' => 'Twoje hasło do panelu administracyjnego :host',
            'message' => 'Otrzymujesz tę wiadomość, ponieważ otrzymaliśmy prośbę o zresetowanie hasła do Twojego konta.',
            'button' => 'Zresetuj hasło',
            'expiry' => 'Ten link do resetowania hasła wygaśnie za :count minut. Jeśli nie prosiłeś o zresetowanie hasła, nie musisz podejmować żadnych działań.',
        ],
        'password_set' => [
            'title' => 'Twoje konto do panelu administracyjnego :host',
            'message' => 'Otrzymujesz tę wiadomość, ponieważ utworzono dla Ciebie konto administratora w panelu :host. Kliknij poniższy link, aby ustawić swoje hasło:',
            'button' => 'Ustaw hasło',
            'expiry' => 'Ten link do ustawienia hasła wygaśnie za :count minut. Jeśli link wygasł, możesz spróbować [zresetować hasło ręcznie](:url).',
        ],
        'two_factor' => [
            'title' => 'Twój kod weryfikacyjny do panelu administracyjnego :host',
            'message' => 'Aby potwierdzić logowanie, użyj poniższego kodu weryfikacyjnego. Kod jest ważny przez 5 minut.',
        ],
    ],

    'buttons' => [
        'back_to_login' => 'Powrót do logowania',
        'forgot_password' => 'Przypomnij hasło',
        'submit' => 'Wyślij',
    ],
    'filters' => [
        'expired' => 'Wygasłe',
    ],
    'actions' => [
        'extend' => 'Przedłuż date wygaśnięcia',
        'reset_password' => 'Resetuj hasło',
    ],
];
