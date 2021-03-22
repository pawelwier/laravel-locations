<template>
    <layout>
        <div class="main-wrapper">
            <Map
                :locations="locations"
                @locations-updated-parent="refreshLocationsParent"
            ></Map>
        </div>
    </layout>
</template>

<script>
import { Inertia } from "@inertiajs/inertia";
import Layout from "../Shared/Layout";
import Map from "../Shared/Map";

export default {
    props: ["locations"],
    components: {
        Layout,
        Map,
    },
    methods: {
        refreshLocationsParent() {
            console.log(123456);
            Inertia.reload({ only: ["locations"] });
        },
    },
};
</script>

<style>
.main-wrapper {
    display: flex;
}
</style>
