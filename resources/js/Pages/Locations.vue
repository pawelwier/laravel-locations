<template>
    <layout
        ><div class="add-location-info">
            Right click on the map to add location<br />
            {{ instructionText }}
        </div>
        <div class="main-wrapper">
            <Map
                :locations="locations"
                :users="users"
                :selectedId="selectedId"
                @locations-updated="refreshLocations"
                @instruction-text-updated="updateInstructionText"
            ></Map>
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
        users: Array,
        selectedId: Number,
    },
    components: {
        Layout,
        Map,
    },
    setup() {
        const urlParams = new URLSearchParams(window.location.search);
        const selectedId = ref(urlParams.get("id"));
        const instructionText = ref("Choose a mode");

        const refreshLocations = () => {
            console.log("dodane");
            // Inertia.reload({ only: ["locations"] });
            // Inertia.visit("/locations", {
            //     // only: ["locations"],
            // });
        };

        const updateInstructionText = (text) => {
            instructionText.value = text;
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
    flex-direction: column;
    padding: 2rem;
}

.add-location-info {
    padding: 0.5rem 0 0.5rem 2rem;
    background-color: #e9ecef;
    font-size: 1.2em;
    font-weight: 500;
}
</style>
