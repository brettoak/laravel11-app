<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Pages\Page;

class Login extends BaseLogin
{
    protected string $view = 'filament.pages.auth.login';
}
