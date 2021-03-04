<template>
    <div>
        <div id="map" class="map-main"></div>
    </div>
</template>

<script>
import mapboxgl from 'mapbox-gl/dist/mapbox-gl.js';

export default {
    name: 'Map',
    data() {
        return {};
    },

    mounted() {
        mapboxgl.accessToken = process.env.MIX_MAP_TOKEN;
        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [19.0676, 51.9577],
            zoom: 5.2,
        });
    },
};
</script>

<style>
.map-main {
    width: 550px;
    height: 550px;
}

.mapboxgl-ctrl-bottom-right {
    display: none;
}
</style>
