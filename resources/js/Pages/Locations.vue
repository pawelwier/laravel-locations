<template>
    <layout>
        Mapa:
        <Map :locations="locations"></Map>
    </layout>
</template>

<script>
import Layout from "../Shared/Layout.vue";
import Map from "../Shared/Map.vue";

export default {
    props: ["locations"],
    components: {
        Layout,
        Map,
    },
};
</script>

<style></style>
