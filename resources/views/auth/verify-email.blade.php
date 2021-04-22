<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-auto h-24 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Děkujeme Vám za registraci, nyní potřebujeme potvrdit Váš účet tím, že kliknete na odkaz, který jsme vám právě zaslali na zadanou e-mailovou adresu.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Nový odkaz pro potvrzení byl zaslán na vaší e-mailovou adresu..') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-forms.button>
                        {{ __('Odeslat potvrzovací odkaz znovu') }}
                    </x-forms.button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Odhlásit se') }}
                </button>
            </form>
        </div>
    </x-auth-card>
</x-guest-layout>
