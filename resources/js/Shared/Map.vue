<template>
    <div id="mapContainer" class="basemap"></div>
    <div v-show="popupDisplayed">
        <PopupMarker ref="popupMarker"></PopupMarker>
    </div>
    <create-location-form
        v-if="this.showAddMarkerForm"
        :latlng="this.addLatLng"
        @canceled="hideAddMarkerForm"
        @locations-updated="refreshLocations"
    ></create-location-form>
</template>

<script>
import * as L from "leaflet";
import { Inertia } from "@inertiajs/inertia";
import { onMounted, ref, toRefs } from "vue";
import PopupMarker from "../Components/PopupMarker";
import CreateLocationForm from "../Components/CreateLocationForm";

export default {
    components: {
        PopupMarker,
        CreateLocationForm,
    },
    props: { locations: Array, selectedId: Number },
    emits: ["locations-updated"],
    setup(props, context) {
        const { locations } = toRefs(props);
        const { selectedId } = toRefs(props);

        const accessToken = process.env.MIX_MAP_TOKEN;
        const popupDisplayed = ref(false);
        const showAddMarkerForm = ref(false);
        const popupMarker = ref(null);

        const addLatLng = ref({
            longitude: null,
            latitude: null,
        });

        const displayPopup = (e, text) => {
            popupMarker.value.setPositionContent(
                e.containerPoint.x,
                e.containerPoint.y,
                text
            );
            popupDisplayed.value = true;
        };

        const onAddNewLocation = (e) => {
            displayAddMarkerForm();
            addLatLng.value = {
                longitude: e.latlng.lng,
                latitude: e.latlng.lat,
            };
        };

        const refreshLocations = () => {
            context.emit("locations-updated");
        };

        const displayAddMarkerForm = () => {
            showAddMarkerForm.value = true;
        };

        const hideAddMarkerForm = () => {
            showAddMarkerForm.value = false;
        };

        onMounted(() => {
            const map = L.map("mapContainer")
                .setView([52, 19], 6)
                .on("contextmenu", onAddNewLocation)
                .on("click", hideAddMarkerForm);

            L.tileLayer(
                "https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}",
                {
                    maxZoom: 18,
                    id: "mapbox/streets-v11",
                    tileSize: 512,
                    zoomOffset: -1,
                    accessToken,
                }
            ).addTo(map);

            const selectedIcon = L.icon({
                iconUrl:
                    "https://cdn3.iconfinder.com/data/icons/map-pins-v-2/512/map_pin_destination_location_adress_street-512.png",
                iconSize: [40, 40],
                iconAnchor: [17, 39],
            });
            locations.value.map((location) =>
                L.marker(
                    [location.latitude, location.longitude],
                    selectedId.value && selectedId.value == location.id
                        ? {
                              icon: selectedIcon,
                          }
                        : null
                )
                    .addTo(map)
                    .on("click", () => {
                        Inertia.visit(`/locations/${location.id}`);
                    })
                    .on("mouseover", (e) => displayPopup(e, location.title))
                    .on("mouseout", () => (popupDisplayed.value = false))
            );
        });

        return {
            popupDisplayed,
            showAddMarkerForm,
            accessToken,
            displayAddMarkerForm,
            hideAddMarkerForm,
            onAddNewLocation,
            refreshLocations,
            addLatLng,
            popupMarker,
        };
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

.leaflet-grab {
    cursor: default;
}
</style>
