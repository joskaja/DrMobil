<x-guest-layout>
    <x-auth.auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="h-24 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-forms.validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-forms.label for="first_name" :value="__('Jmeno')" />

                <x-forms.input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus />
            </div>
                <div>
                    <x-forms.label for="last_name" :value="__('Přijmeni')" />

                    <x-forms.input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus />
                </div>
            <!-- Email Address -->
            <div class="mt-4">
                <x-forms.label for="email" :value="__('E-mail')" />

                <x-forms.input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-forms.label for="password" :value="__('Heslo')" />

                <x-forms.input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-forms.label for="password_confirmation" :value="__('Heslo znovu')" />

                <x-forms.input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Již máte uživatelský účet?') }}
                </a>

                <x-forms.button class="ml-4">
                    {{ __('Registrovat se') }}
                </x-forms.button>
            </div>
        </form>
    </x-auth.auth-card>
</x-guest-layout>
