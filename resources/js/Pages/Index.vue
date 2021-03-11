<template>
    <layout>
        <h2>index</h2>
        <inertia-link class="navbar-brand" href="/locations"
            >Locations</inertia-link
        >
        <inertia-link class="navbar-brand" href="/dashboard"
            >Dashboard</inertia-link
        >
        <inertia-link class="navbar-brand" href="/login">Login</inertia-link>
    </layout>
</template>

<script>
import Layout from "../Shared/Layout.vue";

export default {
    components: {
        Layout,
    },
};
</script>

<style>
inertia-link {
    display: block;
}
</style>
