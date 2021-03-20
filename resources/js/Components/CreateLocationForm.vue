<template>
    <form @submit.prevent="addLocation">
        Title: <input v-model="form.title" /><br />
        Description: <input v-model="form.description" /><br />
        <button class="btn">Anuluj</button>
        <button class="btn btn-primary" type="submit">Dodaj</button>
    </form>
</template>

<script>
import { computed } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";

export default {
    setup() {
        const user_info = computed(() => usePage().props.value.user_info);
        return { user_info };
    },
    name: "CreateLocationForm",
    props: {
        latlng: {
            longitude: null,
            latitude: null,
        },
    },
    data() {
        return {
            form: {
                longitude: null,
                latitude: null,
                title: null,
                description: null,
                user_id: null,
            },
        };
    },
    methods: {
        addLocation() {
            this.$inertia.post("/locations", {
                ...this.form,
                longitude: this.latlng.longitude,
                latitude: this.latlng.latitude,
                user_id: this.user_info.id,
            });
        },
    },
};
</script>

<style></style>
