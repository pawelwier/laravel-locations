<template>
    <layout>
        <div class="main-wrapper">
            <Map :locations="locations"></Map>
            <create-location-form></create-location-form>
        </div>
    </layout>
</template>

<script>
import Layout from "../Shared/Layout";
import Map from "../Shared/Map";
import CreateLocationForm from "../Components/CreateLocationForm";

export default {
    props: ["locations"],
    components: {
        Layout,
        Map,
        CreateLocationForm,
    },
};
</script>

<style>
.main-wrapper {
    display: flex;
}
</style>
