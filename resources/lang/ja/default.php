<?php

return [
    'fields' => [
        'first_name' => '名',
        'last_name' => '姓',
        'email' => 'メールアドレス',
        'role' => 'ロール',
        'permissions' => 'パーミッション',
        'name' => '名前',
        'full_name' => '名前',
        'description' => '説明',
        'id' => 'ID',
        'created_at' => '作成日時',
        'password' => 'パスワード',
        'password_confirm' => '確認用パスワード',
        'active' => 'アクティブ',
        'expires_at' => '有効期限日',
        'code' => '認証コード',
    ],
    'resources' => [
        'admin_user' => '管理者',
        'admin_users' => '管理者',
        'role' => 'ロール',
        'roles' => 'ロール',
        'permission' => 'パーミッション',
        'permissions' => 'パーミッション',
        'group' => '管理者',
    ],
    'sections' => [
        'permissions' => 'パーミッション',
        'user_details' => 'ユーザー詳細',
    ],
    'messages' => [
        'permissions_create' => 'ユーザーは自分のロールから他のパーミッションを持つことができます。実際のパーミッションはビューページに表示されます。',
        'permissions_view' => '直接のパーミッションだけでなく、ロールによるパーミッションも表示されます。',
        'account_expired' => 'このアカウントは有効期限が切れています。管理者に連絡してください。',
        'accounts_extended' => '選択されたアカウントは延長されています。',
        'invalid_user' => '無効なユーザーです、もう一度お試しください。',
        'code_expired' => 'この認証コードは有効期限が切れています。先ほどお送りした新しいコードをお使いください。',
        'invalid_code' => '認証コードが無効です。',
        'enter_code' => 'ログインを確認するには、あなたのメールアドレスに送信された認証コードを入力してください。',
    ],
    'pages' => [
        'reset_password' => 'パスワードのリセット',
        'account_expired' => 'アカウントは期限切れです。',
        'two_factor' => 'ログイン認証',
    ],
    'notifications' => [
        'salutation' => 'よろしくお願いします',
        'password_reset' => [
            'title' => ':host の管理者パスワード',
            'message' => 'このメールを受け取っているのは、あなたのアカウントのパスワードリセットが要求されたからです。',
            'button' => 'パスワードをリセット',
            'expiry' => 'このパスワードリセットリンクは :count 分で失効します。パスワードリセットを要求していない場合は、これ以上のアクションは必要ありません。',
        ],
        'password_set' => [
            'title' => ':host 管理者のアカウント',
            'message' => 'このメールを受け取っているのは、最近 :host 管理用にあなたの管理アカウントが作成されたからです。次のリンクをクリックして、パスワードを設定してください:',
            'button' => 'パスワードを設定',
            'expiry' => 'このパスワード設定リンクは、:count 分で失効します。リンクが期限切れになった場合は、[パスワードの手動リセット]を試してみてください(:url)。',
        ],
        'two_factor' => [
            'title' => ':host 管理者の認証コード',
            'message' => 'ログインを確認するために、以下の認証コードを使用してください。コードは5分間有効です。',
        ],
    ],
    'buttons' => [
        'back_to_login' => 'ログインに戻る',
        'forgot_password' => 'パスワードをお忘れですか？',
        'submit' => '送信',
    ],
    'filters' => [
        'expired' => '期限切れ',
    ],
    'actions' => [
        'extend' => '有効期限を延長する',
    ],
];
