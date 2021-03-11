<template>
    <div id="mapContainer" class="basemap"></div>
</template>

<script>
import * as L from "leaflet";

export default {
    name: "Map",
    props: { locations: Array },
    data() {
        return {
            accessToken: process.env.MIX_MAP_TOKEN,
        };
    },
    mounted() {
        console.log(this.locations);
        const map = L.map("mapContainer").setView([52, 19], 6);

        L.tileLayer(
            "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}",
            {
                maxZoom: 18,
                id: "mapbox/streets-v11",
                tileSize: 512,
                zoomOffset: -1,
                accessToken: this.accessToken,
            }
        ).addTo(map);

        this.locations.map((location) =>
            L.marker([location.latitude, location.longitude])
                .addTo(map)
                .on("click", () => console.log(location.title))
        );
    },
};
</script>

<style>
.basemap {
    height: 38em;
    width: 40em;
}
</style>
