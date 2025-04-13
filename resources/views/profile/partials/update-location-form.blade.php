<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">Update Location</h2>
        <p class="mt-1 text-sm text-gray-600">
            This will be used for weather updates.
        </p>
    </header>

    <form method="POST" action="{{ route('profile.location.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('PATCH')

        <x-location-map :lat="Auth::user()->latitude" :lon="Auth::user()->longitude" />

        <div class="flex items-center gap-4">
            <x-primary-button>Save</x-primary-button>
            @if (session('status') === 'location-updated')
                <p class="text-sm text-gray-600">Saved.</p>
            @endif
        </div>
    </form>
</section>
