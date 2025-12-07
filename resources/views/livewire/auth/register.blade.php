<form wire:submit.prevent="register" class="max-w-[90vw] w-md mx-auto">
    <div class="card shadow-lg p-8 flex flex-col space-y-6">
        <div class="flex justify-center">
            <h3 class="font-semibold text-2xl">{{ $title }}</h3>
        </div>

        @if ($errors->any())
            <div class="alert alert-error shadow-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-control w-full">
            <label class="label">
                <span class="label-text">Full Name *</span>
            </label>
            <input type="text" placeholder="Full Name" wire:model="name" class="input input-bordered w-full" />
        </div>

        <div class="form-control w-full">
            <label class="label">
                <span class="label-text">Email *</span>
            </label>
            <input type="email" placeholder="Email" wire:model="email" class="input input-bordered w-full" />
        </div>

        <div class="form-control w-full">
            <label class="label">
                <span class="label-text">Password *</span>
            </label>
            <input type="password" placeholder="Password" wire:model="password" class="input input-bordered w-full" />
        </div>

        <div class="form-control w-full">
            <label class="label">
                <span class="label-text">Confirm Password *</span>
            </label>
            <input type="password" placeholder="Confirm Password" wire:model="password_confirmation" class="input input-bordered w-full" />
        </div>

        <button type="submit" class="btn btn-primary w-full">
            Register
        </button>

        <div class="text-center">
            <span class="text-sm text-gray-600">Sudah punya akun?</span>
            <button 
                wire:navigate
                href="./login"
                class="text-sm text-primary font-semibold hover:underline ml-1"
            >
                Masuk
            </button>
        </div>
    </div>
</form>
