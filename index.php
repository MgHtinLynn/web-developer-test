<!DOCTYPE html>
<html>

<head>
    <title>Web Developer Test Map</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <link rel="stylesheet" type="text/css" href="./style.css" />
    <script src="./index.js"></script>
</head>

<body>
<div id="map"></div>

<!-- Async script executes immediately and must be after any DOM elements used in callback. -->
<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBzlLYISGjL_ovJwAehh6ydhB56fCCpPQw&callback=initMap&libraries=&v=weekly"
    async></script>
</body>

</html>
