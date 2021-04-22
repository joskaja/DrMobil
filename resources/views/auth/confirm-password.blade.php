<x-guest-layout>
    <x-auth.auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-auto h-24 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Tato část aplikace je zabezpečena. Potvrďte prosím své heslo než budete pokračovat') }}
        </div>

        <!-- Validation Errors -->
        <x-forms.validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div>
                <x-forms.label for="password" :value="__('Heslo')" />

                <x-forms.input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <div class="flex justify-end mt-4">
                <x-forms.button>
                    {{ __('Potvrdit') }}
                </x-forms.button>
            </div>
        </form>
    </x-auth.auth-card>
</x-guest-layout>
