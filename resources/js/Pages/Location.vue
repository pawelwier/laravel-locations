<template>
    <layout>
        <div class="title-container">
            <strong>Title:</strong>
            <form @submit.prevent="changeTitle">
                <input v-model="title" />
                <button type="submit">Zmień</button>
            </form>
        </div>
        <div><strong>Description:</strong> {{ location.description }}</div>
    </layout>
</template>

<script>
import Layout from "../Shared/Layout";

export default {
    props: ["location"],
    components: {
        Layout,
    },
    data() {
        return {
            title: this.location.title,
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

<style>
.title-container {
    display: flex;
}
.title-container input {
    margin-left: 0.4em;
}
</style>
