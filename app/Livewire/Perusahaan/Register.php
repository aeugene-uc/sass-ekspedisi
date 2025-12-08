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
        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $this->password = '';
            return $this->addError('loginError', 'Email atau password salah.');
        }

        $userPeran = Auth::user()->peran;
        $currentSubdomain = explode('.', request()->getHost())[0];

        if (
            !$userPeran->is_platform_admin && (
                $userPeran->perusahaan_id === null ||
                $userPeran->perusahaan->subdomain !== $currentSubdomain
            )
        ) {
            Auth::logout();
            $this->password = '';
            return $this->addError('loginError', 'Email atau password salah.');
        }

        session()->regenerate();

        return $this->redirect(route('perusahaan.dashboard'), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('livewire.layouts.auth', [
            'title' => $this->title,
            'registerEnabled' => $this->registerEnabled
        ]);
    }
}
