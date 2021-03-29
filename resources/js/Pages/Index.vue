<template>
    <layout>
        <h2>index</h2>
        <inertia-link v-if="userInfo" class="navbar-brand" href="/locations"
            >Locations</inertia-link
        >
        <inertia-link v-if="userInfo" class="navbar-brand" href="/dashboard"
            >Dashboard</inertia-link
        >
        <inertia-link v-if="!userInfo" class="navbar-brand" href="/login"
            >Login</inertia-link
        >
    </layout>
</template>

<script>
import { computed } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import Layout from "../Shared/Layout.vue";

export default {
    components: {
        Layout,
    },
    setup(props) {
        const userInfo = computed(() => usePage().props.value.user_info);

        return { userInfo };
    },
};
</script>

<style>
inertia-link {
    display: block;
}
</style>
