@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let map = L.map('map').setView([50.0755, 14.4378], 6); // Centered on Prague for fun
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            let marker = L.marker([50.0755, 14.4378], { draggable: true }).addTo(map);

            function updateLatLngFields(lat, lng) {
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = lng;
            }

            marker.on('dragend', function (e) {
                const position = marker.getLatLng();
                updateLatLngFields(position.lat, position.lng);
            });

            // Initial set
            updateLatLngFields(50.0755, 14.4378);
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

            <!-- Name -->
            <div>
                <x-input-label for="Username" :value="__('Username')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                    autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="mt-6 mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Select your location for weather updates
                    <span class="text-xs text-gray-500">(Drag the marker to your exact location)</span>
                </label>
                <div id="map" class="h-80 w-full rounded-lg shadow-md border border-gray-300"></div>
            </div>

            <input type="hidden" name="latitude" id="latitude" value="50.0755">
            <input type="hidden" name="longitude" id="longitude" value="14.4378">

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>