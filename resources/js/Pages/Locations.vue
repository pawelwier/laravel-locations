<template>
    <layout>
        <div class="main-wrapper">
            <Map
                :locations="locations"
                @locations-updated="refreshLocations"
            ></Map>
        </div>
    </layout>
</template>

<script>
// import { Inertia } from "@inertiajs/inertia";
import Layout from "../Shared/Layout";
import Map from "../Shared/Map";

export default {
    props: {
        locations: Array,
    },
    components: {
        Layout,
        Map,
    },
    setup() {
        const refreshLocations = () => {
            console.log("dodane");
            // Inertia.reload({ only: ["locations"] });
        };

        return { refreshLocations };
    },
};
</script>

<style>
.main-wrapper {
    display: flex;
}
</style>
