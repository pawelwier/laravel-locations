<template>
    <form @submit.prevent="onLocationsUpdated">
        <div>Title: <input v-model="form.title" /></div>
        <div class="my-1">
            Description: <input v-model="form.description" />
        </div>
        <button class="btn" @click="onCancel">Cancel</button>
        <button class="btn btn-primary" type="submit">Add</button>
    </form>
</template>

<script>
import { computed, toRefs } from "vue";
import { usePage, useForm } from "@inertiajs/inertia-vue3";

export default {
    props: {
        latlng: {
            longitude: null,
            latitude: null,
        },
    },
    emits: ["locations-updated", "canceled"],
    setup(props, context) {
        const userInfo = computed(() => usePage().props.value.user_info);

        const { latlng } = toRefs(props);

        const form = useForm({
            longitude: latlng.value.longitude,
            latitude: latlng.value.latitude,
            user_id: userInfo.value.id,
            title: null,
            description: null,
        });

        const onLocationsUpdated = () => {
            form.post("/locations");
            context.emit("locations-updated");
        };

        const onCancel = () => {
            context.emit("canceled");
        };

        return { userInfo, form, onLocationsUpdated, onCancel };
    },
};
</script>

<style></style>
