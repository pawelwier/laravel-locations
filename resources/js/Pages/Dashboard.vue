<template>
    <layout>
        <h2>Dashboard</h2>
        <div>User info</div>
        <ul>
            <li>
                ID: <strong>{{ userInfo.id }}</strong>
            </li>
            <li>
                Name: <strong>{{ userInfo.name }}</strong>
            </li>
            <li>
                Email: <strong>{{ userInfo.email }}</strong>
            </li>
            <li>
                Joined:
                <strong>{{
                    new Date(userInfo.created_at).toLocaleString()
                }}</strong>
            </li>
        </ul>
        <div>
            User's locations
            <button class="btn btn-outline-info" @click="toggleShowLocations">
                {{ toggleButtonText }}
            </button>
            <ul v-if="showAllLocations">
                <li v-for="location in locations" :key="location.id">
                    <inertia-link :href="`/locations/${location.id}`">{{
                        location.title
                    }}</inertia-link>
                </li>
            </ul>
        </div>
    </layout>
</template>

<script>
import { ref, computed } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import Layout from "../Shared/Layout";

export default {
    components: {
        Layout,
    },
    props: {
        locations: Array,
    },
    setup(props) {
        const userInfo = computed(() => usePage().props.value.user_info);
        const showAllLocations = ref(false);
        const showallText = `Show all (${props.locations.length})`;
        const toggleButtonText = ref(showallText);

        const toggleShowLocations = () => {
            toggleButtonText.value = showAllLocations.value
                ? showallText
                : "Hide";
            showAllLocations.value = !showAllLocations.value;
        };

        return {
            userInfo,
            showAllLocations,
            toggleShowLocations,
            toggleButtonText,
        };
    },
};
</script>
