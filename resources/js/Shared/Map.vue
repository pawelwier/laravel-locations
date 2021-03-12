<template>
    <div id="mapContainer" class="basemap"></div>
    <div v-show="popupDisplayed">
        <popup-marker ref="popupMarker"></popup-marker>
    </div>
</template>

<script>
import * as L from "leaflet";
import PopupMarker from "../Components/PopupMarker";

export default {
    name: "Map",
    components: {
        PopupMarker,
    },
    props: { locations: Array },
    data() {
        return {
            accessToken: process.env.MIX_MAP_TOKEN,
            popupDisplayed: false,
        };
    },
    methods: {
        displayPopup(e, text) {
            this.$refs.popupMarker.setPositionContent(
                e.layerPoint.x,
                e.layerPoint.y,
                text
            );
            this.popupDisplayed = true;
        },
    },
    mounted() {
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
                .on("click", () => {
                    this.$inertia.get(`/locations/${location.id}`);
                })
                .on("mouseover", (e) => this.displayPopup(e, location.title))
                .on("mouseout", () => (this.popupDisplayed = false))
        );
    },
};
</script>

<style>
.basemap {
    height: 38em;
    width: 40em;
}

.popup-marker {
    position: absolute;
    top: 140px;
    z-index: 9999;
}
</style>
