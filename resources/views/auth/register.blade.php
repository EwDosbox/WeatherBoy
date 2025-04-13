@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const lat = 50.0755;
            const lon = 14.4378;

            const map = L.map('map').setView([lat, lon], 6);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            const marker = L.marker([lat, lon], { draggable: true }).addTo(map);

            function updateFields(lat, lon) {
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lon;
            }

            marker.on('dragend', () => {
                const pos = marker.getLatLng();
                updateFields(pos.lat, pos.lng);
            });

            updateFields(lat, lon);
        });
    </script>
@endpush

<x-guest-layout>
    <div class="relative max-w-xl w-full mx-auto">
        <a href="/" class="absolute -top-5 -right-5 text-sky-600 hover:text-sky-800">
            <x-heroicon-s-arrow-left-circle class="w-8 h-8" />
        </a>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Username -->
            <div>
                <x-input-label for="name" :value="__('Username')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                              :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                              :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password"
                              name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                              name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <!-- Map -->
            <div class="mt-6 mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Select your location for weather updates
                    <span class="block text-xs text-gray-500">Drag the marker to your exact spot</span>
                </label>
                <div id="map" class="rounded-lg border shadow-sm w-full h-80 overflow-hidden"></div>
            </div>

            <!-- Hidden Lat/Lon Fields -->
            <input type="hidden" name="latitude" id="latitude" value="50.0755">
            <input type="hidden" name="longitude" id="longitude" value="14.4378">

            <!-- reCAPTCHA -->
            {!! NoCaptcha::renderJs() !!}
            {!! NoCaptcha::display() !!}

            <!-- Submit -->
            <div class="flex items-center justify-end mt-6">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none"
                   href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ml-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
