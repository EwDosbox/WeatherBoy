<x-app-layout>
    {{-- Welcome Message --}}
    <div class="py-6 px-6">
        <h1 class="text-3xl font-bold text-gray-900">
            {{ __('Welcome back, :name!', ['name' => Auth::user()->name]) }}
        </h1>
    </div>

    {{-- Location Info --}}
    <div class="px-6 pb-4">
        <div class="bg-gradient-to-r from-blue-500 to-teal-500 text-white shadow-lg rounded-lg p-6 mb-6 transform transition duration-300 hover:scale-105 hover:shadow-xl">
            <h2 class="text-2xl font-semibold mb-4">📍 Your Location</h2>
            <p class="text-sm">Latitude: <span class="font-medium">{{ Auth::user()->latitude }}</span></p>
            <p class="text-sm">Longitude: <span class="font-medium">{{ Auth::user()->longitude }}</span></p>
        </div>

        {{-- Weather Info --}}
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6 transform transition duration-300 hover:scale-105 hover:shadow-xl">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">🌤️ Weather Information</h2>
            <p class="text-gray-600">Temperature: <span class="font-medium">{{ $last['temperature'] }}°C</span></p>
            <p class="text-gray-600">Wind: <span class="font-medium">{{ $last['wind_speed'] ?? '-' }} km/h</span></p>
            <p class="text-gray-600">Direction: <span class="font-medium">{{ $last['wind_direction'] ?? '-' }}°</span></p>
            <p class="text-gray-600">Daytime: <span class="font-medium">{{ $last['is_day'] ? '☀️ Day' : '🌙 Night' }}</span></p>
            <p class="text-gray-500 text-sm mt-2">As of {{ \Carbon\Carbon::parse($last['weather_time'])->format('H:i, M jS') }}</p>
        </div>
    </div>

    {{-- Graphs --}}
    <div class="bg-white shadow-lg rounded-lg p-6 mt-6 transform transition duration-300 hover:scale-105 hover:shadow-xl">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">📈 Temperature Over Time</h2>
        <div id="temperatureChart" style="height: 400px;"></div>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-6 mt-6 transform transition duration-300 hover:scale-105 hover:shadow-xl">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">💨 Wind Speed</h2>
        <div id="windSpeedChart" style="height: 400px;"></div>
    </div>

    <div class="bg-white shadow-lg rounded-lg p-6 mt-6 transform transition duration-300 hover:scale-105 hover:shadow-xl">
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">🧭 Wind Direction</h2>
        <div id="windDirectionChart" style="height: 400px;"></div>
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script>
        google.charts.load('current', { 'packages': ['corechart'] });
        google.charts.setOnLoadCallback(drawTemperatureChart);
        google.charts.setOnLoadCallback(drawWindSpeedChart);
        google.charts.setOnLoadCallback(drawWindDirectionChart);

        function drawTemperatureChart() {
            const data = google.visualization.arrayToDataTable([
                ['Time', 'Temperature (°C)'],
                @foreach ($all as $entry)
                    ['{{ \Carbon\Carbon::parse($entry->weather_time)->format('H:i') }}', {{ $entry->temperature }}],
                @endforeach
            ]);

            const options = {
                curveType: 'function',
                legend: { position: 'bottom' },
                colors: ['#3B82F6'],
                hAxis: {
                    title: 'Time',
                },
                vAxis: {
                    title: 'Temperature (°C)',
                    minValue: -20,
                    maxValue: 40
                }
            };

            const chart = new google.visualization.LineChart(document.getElementById('temperatureChart'));
            chart.draw(data, options);
        }

        function drawWindSpeedChart() {
            const data = google.visualization.arrayToDataTable([
                ['Time', 'Wind Speed (km/h)'],
                @foreach ($all as $entry)
                    ['{{ \Carbon\Carbon::parse($entry->weather_time)->format('H:i') }}', {{ $entry->wind_speed ?? 'null' }}],
                @endforeach
            ]);

            const options = {
                colors: ['#10B981'],
                legend: { position: 'bottom' },
                hAxis: {
                    title: 'Time',
                },
                vAxis: {
                    title: 'Wind Speed (km/h)',
                    minValue: 0
                }
            };

            const chart = new google.visualization.LineChart(document.getElementById('windSpeedChart'));
            chart.draw(data, options);
        }

        function drawWindDirectionChart() {
            const data = google.visualization.arrayToDataTable([
                ['Time', 'Direction (°)'],
                @foreach ($all as $entry)
                    ['{{ \Carbon\Carbon::parse($entry->weather_time)->format('H:i') }}', {{ $entry->wind_direction ?? 'null' }}],
                @endforeach
            ]);

            const options = {
                colors: ['#6366F1'],
                legend: { position: 'bottom' },
                hAxis: {
                    title: 'Time',
                },
                vAxis: {
                    title: 'Direction (°)',
                    minValue: 0,
                    maxValue: 360
                }
            };

            const chart = new google.visualization.LineChart(document.getElementById('windDirectionChart'));
            chart.draw(data, options);
        }
    </script>

    <script>
        window.addEventListener('resize', function () {
            drawTemperatureChart();
            drawWindSpeedChart();
            drawWindDirectionChart();
        });
    </script>
</x-app-layout>
