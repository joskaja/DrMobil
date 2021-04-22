<x-guest-layout>
    <x-auth.auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-auto h-24 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Zapomněli jste heslo? Stačí zde zadat vaší emailovou adresu a my vám obratem zašleme odkaz na obnovu hesla.') }}
        </div>

        <!-- Session Status -->
        <x-auth.auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-forms.validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-forms.label for="email" :value="__('E-mail')" />

                <x-forms.input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-forms.button>
                    {{ __('Odeslat odkaz na obnovu hesla') }}
                </x-forms.button>
            </div>
        </form>
    </x-auth.auth-card>
</x-guest-layout>
