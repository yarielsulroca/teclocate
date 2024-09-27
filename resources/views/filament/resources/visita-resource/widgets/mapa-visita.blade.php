<div id="map" style="width: 100%; height: 500px;"></div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var map = L.map('map').setView([{{ $latitude }}, {{ $longitude }}], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        L.marker([{{ $latitude }}, {{ $longitude }}]).addTo(map)
            .bindPopup('Visita en: {{ $latitude }}, {{ $longitude }}');
    });
</script>