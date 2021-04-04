<template>
    <layout>
        <div class="main-wrapper">
            <Map
                :locations="locations"
                :selectedId="selectedId"
                @locations-updated="refreshLocations"
            ></Map>
        </div>
        <div class="add-location-info">(right click to add new location)</div>
    </layout>
</template>

<script>
import { ref } from "vue";
// import { Inertia } from "@inertiajs/inertia";
import Layout from "../Shared/Layout";
import Map from "../Shared/Map";

export default {
    props: {
        locations: Array,
        selectedId: Number,
    },
    components: {
        Layout,
        Map,
    },
    setup() {
        const urlParams = new URLSearchParams(window.location.search);
        const selectedId = ref(urlParams.get("id"));

        const refreshLocations = () => {
            console.log("dodane");
            // Inertia.reload({ only: ["locations"] });
            // Inertia.visit("/locations", {
            //     // only: ["locations"],
            // });
        };

        return { refreshLocations, selectedId };
    },
};
</script>

<style>
.main-wrapper {
    display: flex;
}

.add-location-info {
    padding: 0.5rem 0 0 3rem;
}
</style>
