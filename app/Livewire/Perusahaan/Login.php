<?php

namespace App\Livewire\Perusahaan;

use App\Models\Perusahaan;
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
        $subdomain = explode('.', request()->getHost())[0];

        $this->title = 'Login ke ' . Perusahaan::where('subdomain', $subdomain)->first()->nama ?? 'Login';
        $this->registerEnabled = true;
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
        $credentials = [
            'email' => $this->email,
            'password' => $this->password,
        ];

        if (!Auth::validate($credentials)) {
            $this->password = '';
            return $this->addError('loginError', 'Email atau password salah.');
        }

        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        $currentSubdomain = explode('.', request()->getHost())[0];

        if (!$user->is_platform_admin && 
            ($user->perusahaan_id === null || $user->perusahaan?->subdomain !== $currentSubdomain)) {
            $this->password = '';
            return $this->addError('loginError', 'Email atau password salah.');
        }

        Auth::login($user);
        session()->regenerate();

        return $this->redirect(route('perusahaan.dashboard', ['subdomain' => explode('.', request()->getHost())[0]]), navigate: true);
    }

    public function render()
    {
        if (Auth::check()) {
            return $this->redirect(route('perusahaan.dashboard', ['subdomain' => explode('.', request()->getHost())[0]]), navigate: true);
        }

        return view('livewire.auth.login')->layout('livewire.layouts.auth', [
            'title' => $this->title,
            'registerEnabled' => $this->registerEnabled
        ]);
    }
}
