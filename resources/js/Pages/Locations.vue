<template>
    <layout>
        <Map :locations="locations"></Map>
    </layout>
</template>

<script>
import Layout from "../Shared/Layout";
import Map from "../Shared/Map";

export default {
    props: ["locations"],
    components: {
        Layout,
        Map,
    },
};
</script>

<style></style>
