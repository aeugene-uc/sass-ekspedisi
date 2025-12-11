<?php

namespace App\Livewire\Perusahaan;

use App\Models\Perusahaan;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Register extends Component
{
    public $title;
    public $registerEnabled;
    public $subdomain;

    public $full_name;
    public $email;
    public $password;
    public $password_confirmation;

    public function mount()
    {
        $this->subdomain = explode('.', request()->getHost())[0];

        $this->title = 'Daftar ke ' . Perusahaan::where('subdomain', $this->subdomain)->first()->nama ?? 'Login';
        $this->registerEnabled = true;
    }


    public function register()
    {
        $this->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ], [
            'password_confirmation.same' => 'Password harus sama dengan konfirmasi password.',
        ]);

        $currentSubdomain = explode('.', request()->getHost())[0];

        $perusahaan_id = Perusahaan::where('subdomain', $currentSubdomain)->first()->id;
        $user = new User();
        $user->perusahaan_id = $perusahaan_id;
        $user->full_name = $this->full_name;
        $user->email = $this->email;
        $user->password = bcrypt($this->password);
        $user->is_platform_admin = false;
        $user->peran_id = 5; // Default peran: customer
        $user->save();

        Auth::login($user);

        session()->regenerate();

        return $this->redirect(route('perusahaan.dashboard', ['subdomain' => $currentSubdomain]), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('livewire.layouts.auth', [
            'title' => $this->title,
            'registerEnabled' => $this->registerEnabled
        ]);
    }
}
