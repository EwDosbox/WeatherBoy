<x-guest-layout>
    <h1 class="text-4xl font-bold mb-4">Welcome to <span class="text-blue-600">weatherBoy</span></h1>
    <p class="text-lg mb-6">Your personal weather companion. Check forecasts, track trends, and stay ahead of the
        storm.</p>

    <div class="flex justify-center gap-4">
        <x-primary-button>
            <a href="{{ route('login') }}">{{ __('Log in') }}</a>
        </x-primary-button>
        <x-primary-button>
            <a href="{{ route('register') }}">{{ __('Register') }}</a>
        </x-primary-button>
    </div>
    </div>
</x-guest-layout>