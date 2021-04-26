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
                        v-for="recommendation in recommendedLocations"
                        :key="recommendation.id"
                        class="list-group-item list-group-item-action recommend-wrapper"
                    >
                        <div>
                            <strong>{{
                                getRecommendationDetails(recommendation).user
                                    .name
                            }}</strong>
                            recommends the following location:
                            <strong>{{
                                getRecommendationDetails(recommendation)
                                    .location.title
                            }}</strong>
                            to you, with message:
                            <strong>{{
                                getRecommendationDetails(recommendation).message
                            }}</strong
                            >.
                        </div>
                        <div>
                            <button
                                @click="
                                    () =>
                                        acceptRecommendation(
                                            getRecommendationDetails(
                                                recommendation
                                            ),
                                            recommendation.id
                                        )
                                "
                                class="btn btn-success"
                            >
                                Accept
                            </button>
                            <button
                                @click="
                                    () =>
                                        rejectRecommendation(recommendation.id)
                                "
                                class="btn btn-danger mx-2"
                            >
                                Reject
                            </button>
                        </div>
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
import { Inertia } from "@inertiajs/inertia";

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

        const getLocationById = (id) => {
            return props.allLocations.find((l) => l.id === id);
        };
        const getUserById = (id) => {
            return props.allUsers.find((u) => u.id === id);
        };

        const getRecommendationDetails = (recommendedLocation) => {
            const { user_id, location_id, message } = recommendedLocation;
            const user = getUserById(user_id);
            const location = getLocationById(location_id);
            return {
                user,
                location,
                message,
            };
        };

        const acceptRecommendation = (recommendation, id) => {
            const {
                longitude,
                latitude,
                title,
                description,
            } = recommendation.location;
            const req = {
                longitude: longitude,
                latitude: latitude,
                user_id: userInfo.value.id,
                title: title,
                description: description,
            };
            Inertia.post("/locations", req);
            // Inertia.delete(`/recommendations/${id}`);
        };

        const rejectRecommendation = (id) => {
            Inertia.delete(`/recommendations/${id}`);
        };

        return {
            userInfo,
            showAllLocations,
            toggleShowLocations,
            toggleButtonText,
            recommendedLocations,
            getRecommendationDetails,
            acceptRecommendation,
            rejectRecommendation,
        };
    },
};
</script>
<style scoped>
h3 {
    padding-top: 0.4 rem;
}

.recommend-wrapper {
    display: flex;
    gap: 2rem;
    justify-content: space-between;
    align-items: center;
}
</style>
