<template>
    <layout>
        <div class="title-container">
            <form @submit.prevent="form.put(`/locations/${location.id}`)">
                <strong>Title:</strong>
                <input v-model="form.title" />
                <div>
                    <div><strong>Description:</strong></div>
                    <textarea v-model="form.description" />
                </div>
                <button class="btn btn-outline-success" type="submit">
                    Save
                </button>
            </form>
        </div>

        <div>
            <inertia-link
                class="btn btn-outline-info btn-sm"
                href="/locations"
                :data="{ id: location.id }"
                >Show on map</inertia-link
            >
        </div>
        <form @submit.prevent="form.delete(`/locations/${location.id}`)">
            <button type="submit" class="btn btn-outline-danger btn-sm">
                Delete
            </button>
        </form>
        <div>
            <inertia-link class="navbar-brand" href="/dashboard"
                >Dashboard</inertia-link
            >
        </div>
        <div>
            <inertia-link class="navbar-brand" href="/locations"
                >Locations</inertia-link
            >
        </div>
    </layout>
</template>

<script>
import { ref, toRefs } from "vue";
import { useForm } from "@inertiajs/inertia-vue3";
import Layout from "../Shared/Layout";

export default {
    props: {
        location: Object,
    },
    components: {
        Layout,
    },
    setup(props) {
        const { location } = toRefs(props);
        const form = useForm({
            title: location.value.title,
            description: location.value.description,
        });

        return { form };
    },
};
</script>

<style>
textarea {
    width: 100%;
}
.title-container {
    display: flex;
}
.title-container input {
    margin-left: 0.4em;
}
</style>
