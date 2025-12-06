<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $title;
    public $registerEnabled;
    public $isLogin;
    public $successRoute;

    public $email;
    public $password;

    public function mount()
    {
        $isSubdomain = count(explode('.', request()->getHost())) > 2;

        if ($isSubdomain) {
            $this->title = 'Company Login'; // Replace with query
            $this->registerEnabled = true;
            $this->successRoute = '/dashboard';
        } else {
            $this->title = 'Platform Admin Login';
            $this->registerEnabled = false;
            $this->successRoute = '/admin';
        }

        $this->isLogin = !str_ends_with(request()->path(), 'register');
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

        session()->regenerate();

        return $this->redirect($this->successRoute, navigate: true);
    }


    public function render()
    {
        return view('livewire.auth.login')->layout('livewire.layouts.auth', [
            'title' => $this->title,
            'registerEnabled' => $this->registerEnabled,
            'isLogin' => $this->isLogin
        ]);
    }
}
