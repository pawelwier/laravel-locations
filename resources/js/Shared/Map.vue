<template>
    <div id="map-relative">
        <div id="map"></div>
    </div>
</template>

<script>
import mapboxgl from "mapbox-gl/dist/mapbox-gl.js";

export default {
    name: "Map",
    data() {
        return {};
    },

    mounted() {
        mapboxgl.accessToken = process.env.MIX_MAP_TOKEN;
        const map = new mapboxgl.Map({
            container: "map",
            style: "mapbox://styles/mapbox/streets-v11",
            center: [19.0676, 51.9577],
            zoom: 5.2,
        });

        var el = document.createElement("div");
        el.className = "marker";
        el.innerText = "X";
        el.style.width = "10px";
        el.style.height = "12px";

        // Position it accordingly
        el.style.marginLeft = "-5px";
        el.style.marginTop = "18px";

        new mapboxgl.Marker(el, {
            offset: [-5, -12],
        })
            .setLngLat([20, 53])
            .addTo(map);
    },
};
</script>

<style>
#map-relative {
    position: relative;
    height: 600px;
}
#map {
    position: absolute;
    top: 0;
    bottom: 0;
    width: 100%;
    height: 600px;
}
.marker {
    display: block;
    border: none;
    cursor: pointer;
    padding: 0;
    position: relative;
    display: inline-block;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
}
</style>
