<?php
$lat = $user->latitude ?? $attributes->get('lat', 50);
$lon = $user->longitude ?? $attributes->get('lon', 14);
?>

<div id="map" class="w-full h-64 rounded border" data-lat="{{ $lat }}" data-lon="{{ $lon }}"></div>

<input type="hidden" name="latitude" id="latitude" value="{{ $lat }}">
<input type="hidden" name="longitude" id="longitude" value="{{ $lon }}">

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const lat = parseFloat(document.getElementById('map').dataset.lat) || 50;
        const lon = parseFloat(document.getElementById('map').dataset.lon) || 14;
        const map = L.map('map').setView([lat, lon], 10);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const marker = L.marker([lat, lon], { draggable: true }).addTo(map);

        marker.on('dragend', function (e) {
            const pos = marker.getLatLng();
            document.getElementById('latitude').value = pos.lat;
            document.getElementById('longitude').value = pos.lng;
        });
    });
</script>
