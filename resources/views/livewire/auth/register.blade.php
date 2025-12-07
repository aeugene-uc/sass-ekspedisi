<form wire:submit.prevent="register" class="max-w-[90vw] w-md">
    <x-card class="px-8 py-10 flex flex-col shadow space-y-8">
        <div class="flex justify-center">
            <h3 class="font-semibold text-2xl">{{ $title }}</h3>
        </div>

        <x-errors />

        <x-input label="Full Name *" class="px-3 py-3" />
        <x-input label="Email *" class="px-3 py-3" type="email" />
        <x-password label="Password *" class="px-3 py-3" />
        <x-password label="Confirm Password *" class="px-3 py-3" />


        <x-button type="submit" class="bg-theme hover:text-white cursor-pointer duration-300">Register</x-button>


        <div class="text-center">
            <span class="text-sm text-gray-600">Sudah punya akun?</span>

            <button 
                wire:navigate 
                {{-- href="{{ route('login') }}" --}}
                class="text-sm text-theme font-semibold hover:underline cursor-pointer"
            >
                Masuk
            </button>
        </div>
    </x-card>
</form>
