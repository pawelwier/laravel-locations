<template>
    <layout>
        <div class="p-3">
            <h3>User info</h3>
            <div class="mb-4">
                <ul class="list-group">
                    <li
                        class="list-group-item d-flex justify-content-between align-items-start"
                    >
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Name:</div>
                            {{ userInfo.name }}
                        </div>
                    </li>
                    <li
                        class="list-group-item d-flex justify-content-between align-items-start"
                    >
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Email:</div>
                            {{ userInfo.email }}
                        </div>
                    </li>
                    <li
                        class="list-group-item d-flex justify-content-between align-items-start"
                    >
                        <div class="ms-2 me-auto">
                            <div class="fw-bold">Joined:</div>
                            {{ new Date(userInfo.created_at).toLocaleString() }}
                        </div>
                    </li>
                </ul>
            </div>
            <div v-if="locations.length">
                <h3>User locations</h3>
                <div>
                    <button
                        class="btn btn-outline-info"
                        @click="toggleShowLocations"
                    >
                        {{ toggleButtonText }}
                    </button>
                    <div v-if="showAllLocations" class="list-group">
                        <inertia-link
                            v-for="location in locations"
                            :key="location.id"
                            class="list-group-item list-group-item-action"
                            :href="`/locations/${location.id}`"
                            >{{ location.title }}</inertia-link
                        >
                    </div>
                </div>
            </div>
            <div class="mt-3" v-if="recommendedLocations.length">
                <h3>Recommended locations</h3>
                <div>
                    <div
                        v-for="location in recommendedLocations"
                        :key="location.id"
                        class="list-group-item list-group-item-action"
                    >
                        {{ makeRecommendMessage(location) }}
                    </div>
                </div>
            </div>
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
        allLocations: Array,
        allUsers: Array,
        recommendedLocations: Array,
    },
    setup(props) {
        const userInfo = computed(() => usePage().props.value.user_info);
        const showAllLocations = ref(false);
        const showallText = `Show all (${props.locations.length})`;
        const toggleButtonText = ref(showallText);

        const recommendedLocations = props.recommendedLocations;

        const toggleShowLocations = () => {
            toggleButtonText.value = showAllLocations.value
                ? showallText
                : "Hide";
            showAllLocations.value = !showAllLocations.value;
        };

        const makeRecommendMessage = (recommendedLocation) => {
            const { user_id, location_id } = recommendedLocation;
            const user = props.allUsers.find((u) => u.id === user_id);
            const location = props.allLocations.find(
                (l) => l.id === location_id
            );
            return `User ${user.name} recommends you The following location: ${location.title} (${location.description}) to you.`;
        };

        return {
            userInfo,
            showAllLocations,
            toggleShowLocations,
            toggleButtonText,
            recommendedLocations,
            makeRecommendMessage,
        };
    },
};
</script>
<style scoped>
h3 {
    padding-top: 0.4 rem;
}
</style>
