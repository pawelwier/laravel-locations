<template>
    <layout>
        <div class="main-wrapper">
            <Map
                :locations="locations"
                :selectedId="selectedId"
                @locations-updated="refreshLocations"
                @instruction-text-updated="updateInstructionText"
            ></Map>
        </div>
        <div class="add-location-info">
            Right click on the map to add location.<br />
            {{ instructionText }}
        </div>
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
        const instructionText = ref("");

        const refreshLocations = () => {
            console.log("dodane");
            // Inertia.reload({ only: ["locations"] });
            // Inertia.visit("/locations", {
            //     // only: ["locations"],
            // });
        };

        const updateInstructionText = (e) => {
            instructionText.value =
                e.target.value === "displayLocationDetails"
                    ? "Click on a marker to show details"
                    : e.target.value === "calculateDistance"
                    ? "Select two points"
                    : "";
        };

        return {
            refreshLocations,
            selectedId,
            updateInstructionText,
            instructionText,
        };
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
