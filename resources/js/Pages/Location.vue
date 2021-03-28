<template>
    <layout>
        <div class="title-container">
            <strong>Title:</strong>
            <form @submit.prevent="form.put(`/locations/${location.id}`)">
                <input v-model="form.title" />
                <button class="btn" type="submit">Zmień</button>
            </form>
        </div>
        <div><strong>Description:</strong> {{ location.description }}</div>
        <form @submit.prevent="form.delete(`/locations/${location.id}`)">
            <button type="submit" class="btn btn-outline-danger btn-sm">
                Usuń
            </button>
        </form>
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
        });

        return { form };
    },
};
</script>

<style>
.title-container {
    display: flex;
}
.title-container input {
    margin-left: 0.4em;
}
</style>
