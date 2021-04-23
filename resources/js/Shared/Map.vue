<template>
    <div class="location-form" v-if="showAddMarkerForm">
        <create-location-form
            :latlng="addLatLng"
            @canceled="hideAddMarkerForm"
            @locations-updated="refreshLocations"
        ></create-location-form>
    </div>
    <div class="recommend-form" v-if="showRecommendForm">
        <recommend-location-form
            :userList="users"
            :locationId="recommendedLocationId"
        ></recommend-location-form>
    </div>
    <div id="mapContainer" class="basemap"></div>
    <div v-show="popupDisplayed">
        <PopupMarker ref="popupMarker"></PopupMarker>
    </div>
    <div class="mode-switch">
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
import RecommendLocationForm from "../Components/RecommendLocationForm";
import SwitchModeForm from "../Components/SwitchModeForm";
import {
    getDistanceFromLatLonInKm,
    getDirectionFromLatLonInKm,
} from "../MapUtils";

export default {
    components: {
        PopupMarker,
        CreateLocationForm,
        SwitchModeForm,
        RecommendLocationForm,
    },
    props: { locations: Array, users: Array, selectedId: Number },
    emits: ["locations-updated", "instruction-text-updated"],
    setup(props, context) {
        const accessToken = process.env.MIX_MAP_TOKEN;

        const { locations, users, selectedId } = toRefs(props);

        const popupDisplayed = ref(false);
        const showAddMarkerForm = ref(false);
        const showRecommendForm = ref(false);
        const popupMarker = ref(null);

        const distanceMarkerOne = ref(null);
        const distanceMarkerTwo = ref(null);
        const firstDistanceMarkerSelected = ref(false);
        const distanceText = ref("");
        const recommendedLocationId = ref(null);

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

        const displayRecommendForm = (id) => {
            showRecommendForm.value = true;
            recommendedLocationId.value = id;
        };

        const hideRecommendForm = () => {
            showRecommendForm.value = false;
        };

        const setDistanceMode = (text) => {
            mode.value = text;
        };

        const goToLocation = (id) => {
            Inertia.visit(`/locations/${id}`);
        };

        const setOnclick = (mode, location) => {
            switch (mode) {
                case "displayLocationDetails":
                    return goToLocation(location.id);
                case "calculateDistance":
                    return selectDistanceLocations(location);
                case "recommendLocation":
                    return recommedLocationToUser(location);
            }
        };

        const setDisplayText = (eventValue) => {
            switch (eventValue) {
                case "displayLocationDetails":
                    reloadMap(false);
                    return "Click on a marker to show details";
                case "calculateDistance":
                    reloadMap(false);
                    return "Select two markers";
                case "moveMarker":
                    reloadMap(true);
                    return "Drag a marker";
                case "recommendLocation":
                    console.log(users);
                    reloadMap(false);
                    return "Select a location to recommend";
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
                } equals ${getDistanceFromLatLonInKm(points[0], points[1])}km`;
            }
        };

        const startDragLocation = (location, point) => {
            const draggedPoint = {
                longitude: point.lng,
                latitude: point.lat,
            };
            distanceText.value = `The ${
                location.title
            } marker has been moved ${getDistanceFromLatLonInKm(
                location,
                draggedPoint
            )}km ${getDirectionFromLatLonInKm(location, draggedPoint)}`;
        };

        const updateDragLocation = (location, point) => {
            const updatedLocation = {
                title: location.title,
                description: location.description,
                latitude: point.lat,
                longitude: point.lng,
            };

            Inertia.put(`/locations/${location.id}`, updatedLocation);
        };

        const recommedLocationToUser = (location) => {
            displayRecommendForm(location.id);
            console.log(location);
        };

        const reloadMap = (isDraggable) => {
            const map = L.DomUtil.get("mapContainer");
            map._leaflet_id = null;
            displayMap(isDraggable);
        };

        const addLocations = (map, markersDraggable = false) => {
            const markerOptions = { draggable: markersDraggable };
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
                              ...markerOptions,
                              icon: selectedIcon,
                          }
                        : markerOptions
                )
                    .addTo(map)
                    .on("click", () => {
                        setOnclick(mode.value, location);
                    })
                    .on("mouseover", (e) => displayPopup(e, location.title))
                    .on("mouseout", () => (popupDisplayed.value = false))
                    .on("drag", (e) =>
                        startDragLocation(location, e.target._latlng)
                    )
                    .on("dragend", (e) => {
                        updateDragLocation(location, e.target._latlng);
                    })
            );
        };
        const displayMap = (markersDraggable) => {
            const map = L.map("mapContainer")
                .setView([52, 19], 6)
                .on("contextmenu", onAddNewLocation)
                .on("click", () => {
                    hideAddMarkerForm();
                    hideRecommendForm();
                });

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

            addLocations(map, markersDraggable);
        };

        onMounted(() => displayMap(false));

        return {
            popupDisplayed,
            showAddMarkerForm,
            showRecommendForm,
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
            recommendedLocationId,
        };
    },
};
</script>

<style>
.location-form,
.recommend-form {
    position: absolute;
    top: 220px;
    left: 40px;
    display: block;
    padding: 1rem;
    background-color: white;
    z-index: 9999;
}

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
