<form wire:submit.prevent="login" class="max-w-[90vw] w-md">
    <x-card class="px-8 py-10 flex flex-col shadow space-y-8">
        <div class="flex justify-center">
            <h3 class="font-semibold text-2xl">{{ $title }}</h3>
        </div>

        @error('loginError')
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded border border-red-300">
                Error: {{ $message }}
            </div>
            {{-- <x-alert color="red"  title="Error" :text="$message" /> --}}
        @enderror

        <x-input label="Email *" class="px-3 py-3" type="email" wire:model="email" required />
        <x-password label="Password *" class="px-3 py-3" wire:model="password" required />


        <x-button type="submit" class="bg-theme hover:text-white cursor-pointer duration-300">Login</x-button>

        @if($registerEnabled)
            <div class="text-center">
                <span class="text-sm text-gray-600">Belum punya akun?</span>

                <button 
                    wire:navigate 
                    href="./register"
                    class="text-sm text-theme font-semibold hover:underline cursor-pointer"
                >
                    Daftar
                </button>
            </div>
        @endif
    </x-card>
</form>