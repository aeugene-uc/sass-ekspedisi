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

        // Lakukan autentikasi
        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $this->password = '';
            return $this->addError('loginError', 'Email atau password salah.');
        }

        if (!Auth::user()->peran->is_platform_admin) {
            Auth::logout();
            $this->password = '';
            return $this->addError('loginError', 'Email atau password salah.');
        }

        session()->regenerate();

        return $this->redirect(route('platform.dashboard'), navigate: true);
    }


    public function render()
    {
        return view('livewire.auth.login')->layout('livewire.layouts.auth', [
            'title' => $this->title,
            'registerEnabled' => $this->registerEnabled
        ]);
    }
}
