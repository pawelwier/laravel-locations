<template>
    <layout>
        <div><strong>Title:</strong> {{ location.title }}</div>
        <div><strong>Description:</strong> {{ location.description }}</div>
        <form @submit.prevent="changeTitle">
            <input v-model="title" />
            <button type="submit">Zmień</button>
        </form>
    </layout>
</template>

<script>
import Layout from "../Shared/Layout.vue";

export default {
    props: ["location"],
    components: {
        Layout,
    },
    data() {
        return {
            title: null,
        };
    },
    methods: {
        changeTitle() {
            this.$inertia.put(`/locations/${this.location.id}`, {
                title: this.title,
            });
        },
    },
};
</script>

<style></style>
