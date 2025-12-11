<form wire:submit.prevent="login" class="max-w-[90vw] w-md mx-auto">
    <div class="card shadow-lg p-8 flex flex-col space-y-6">
        <div class="flex justify-center">
            <h3 class="font-semibold text-2xl text-center">{{ $title }}</h3>
        </div>

        @error('loginError')
            <div class="alert alert-error shadow-lg">
                {{ $message }}
            </div>
        @enderror

        <div class="form-control w-full">
            <label class="label">
                <span class="label-text">Email *</span>
            </label>
            <input type="email" placeholder="Email" wire:model="email" required class="input input-bordered w-full" required />
        </div>

        <div class="form-control w-full">
            <label class="label">
                <span class="label-text">Password *</span>
            </label>
            <input type="password" placeholder="Password" wire:model="password" required class="input input-bordered w-full" required />
        </div>

        <button type="submit" class="btn btn-primary w-full">
            Login
        </button>

        @if ($registerEnabled)
            <div class="text-center">
                <span class="text-sm text-gray-600">Belum punya akun?</span>
                <a wire:navigate href="./register" class="text-sm text-primary font-semibold hover:underline ml-1">
                    Daftar
                </a>
            </div>
        @endif
    </div>
</form>
