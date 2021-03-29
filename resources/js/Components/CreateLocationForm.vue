<template>
    <form @submit.prevent="onLocationsUpdated">
        Title: <input v-model="form.title" /><br />
        Description: <input v-model="form.description" /><br />
        <button class="btn" @click="onCancel">Anuluj</button>
        <button class="btn btn-primary" type="submit">Dodaj</button>
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
            form.value.post("/locations");
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
