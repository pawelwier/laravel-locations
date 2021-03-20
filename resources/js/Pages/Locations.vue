<template>
    <layout>
        <div class="main-wrapper">
            <Map :locations="locations"></Map>
        </div>
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

<style>
.main-wrapper {
    display: flex;
}
</style>
