<?php

namespace App\Livewire\Platform;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $title;
    public $registerEnabled;

    public $email;
    public $password;

    public function mount()
    {
        $this->title = 'Platform Admin Login';
        $this->registerEnabled = false;
    }


    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email'    => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.',
        ]);

        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (!Auth::validate($credentials)) {
            $this->password = '';
            return $this->addError('loginError', 'Email atau password salah.');
        }

        $user = Auth::getProvider()->retrieveByCredentials($credentials);

        if (!$user->is_platform_admin) {
            $this->password = '';
            return $this->addError('loginError', 'Email atau password salah.');
        }

        Auth::login($user);
        session()->regenerate();

        return $this->redirect(route('platform.dashboard'), navigate: true);
    }

    public function render()
    {
        if (Auth::check()) {
            return $this->redirect(route('platform.dashboard', ['subdomain' => explode('.', request()->getHost())[0]]), navigate: true);
        }

        return view('livewire.auth.login')->layout('livewire.layouts.auth', [
            'title' => $this->title,
            'registerEnabled' => $this->registerEnabled
        ]);
    }
}
