<template>
    <div id="mapContainer" class="basemap"></div>
    <div v-show="popupDisplayed">
        <PopupMarker ref="popupMarker"></PopupMarker>
    </div>
    <div class="mode-switch">
        <create-location-form
            v-if="this.showAddMarkerForm"
            :latlng="this.addLatLng"
            @canceled="hideAddMarkerForm"
            @locations-updated="refreshLocations"
        ></create-location-form>
        <switch-mode-form @type-updated="onTypeChanged"></switch-mode-form>
    </div>
    <div v-if="distanceText">{{ distanceText }}</div>
</template>

<script>
import * as L from "leaflet";
import { Inertia } from "@inertiajs/inertia";
import { onMounted, ref, toRefs } from "vue";
import PopupMarker from "../Components/PopupMarker";
import CreateLocationForm from "../Components/CreateLocationForm";
import SwitchModeForm from "../Components/SwitchModeForm";
import { getDistanceFromLatLonInKm } from "../MapUtils";

export default {
    components: {
        PopupMarker,
        CreateLocationForm,
        SwitchModeForm,
    },
    props: { locations: Array, selectedId: Number },
    emits: ["locations-updated", "instruction-text-updated"],
    setup(props, context) {
        const accessToken = process.env.MIX_MAP_TOKEN;

        const { locations, selectedId } = toRefs(props);

        const popupDisplayed = ref(false);
        const showAddMarkerForm = ref(false);
        const popupMarker = ref(null);

        const distanceMarkerOne = ref(null);
        const distanceMarkerTwo = ref(null);
        const firstDistanceMarkerSelected = ref(false);
        const distanceText = ref("");

        const mode = ref("");

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

        const setDistanceMode = (text) => {
            mode.value = text;
        };

        const goToLocation = (id) => {
            Inertia.visit(`/locations/${id}`);
        };

        const setOnclick = (mode, location) => {
            switch (mode) {
                case "calculateDistance":
                    return selectDistanceLocations(location);
                case "displayLocationDetails":
                    return goToLocation(location.id);
            }
        };

        const setDisplayText = (eventValue) => {
            switch (eventValue) {
                case "displayLocationDetails":
                    return "Click on a marker to show details";
                case "calculateDistance":
                    return "Select two markers";
            }
        };

        const onTypeChanged = (e) => {
            setDistanceMode(e.target.value);
            context.emit(
                "instruction-text-updated",
                setDisplayText(e.target.value)
            );
            distanceText.value = "";
        };

        const selectDistanceLocations = (location) => {
            if (!firstDistanceMarkerSelected.value) {
                distanceMarkerOne.value = location;
                firstDistanceMarkerSelected.value = true;
                distanceText.value = `Distance from ${location.title}`;
            } else {
                distanceMarkerTwo.value = location;
                firstDistanceMarkerSelected.value = false;
                const points = [
                    distanceMarkerOne.value,
                    distanceMarkerTwo.value,
                ];
                if (points[0].id === points[1].id) {
                    distanceText.value = "Select two different points";
                    return;
                }
                distanceText.value += ` to ${
                    location.title
                } equals ${getDistanceFromLatLonInKm(
                    points[0]?.latitude,
                    points[0]?.longitude,
                    points[1]?.latitude,
                    points[1]?.longitude
                )}km`;
            }
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
                        setOnclick(mode.value, location);
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
            mode,
            setDistanceMode,
            onTypeChanged,
            distanceMarkerOne,
            distanceMarkerTwo,
            firstDistanceMarkerSelected,
            distanceText,
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

.mode-switch {
    padding: 2rem 0;
    display: block;
}
</style>
