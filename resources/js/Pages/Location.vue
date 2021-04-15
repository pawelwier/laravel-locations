<template>
    <layout>
        <div class="form-container">
            <form
                class="mb-5"
                @submit.prevent="form.put(`/locations/${location.id}`)"
            >
                <div class="input-group">
                    <span class="input-group-text"
                        ><strong>Title:</strong></span
                    >
                    <input
                        type="text"
                        v-model="form.title"
                        class="form-control"
                    />
                </div>
                <div class="input-group py-3">
                    <span class="input-group-text"
                        ><strong>Description:</strong></span
                    >
                    <textarea
                        class="form-control"
                        v-model="form.description"
                        aria-label="Description"
                    ></textarea>
                </div>
                <div
                    class="btn-group"
                    role="group"
                    aria-label="Basic outlined example"
                >
                    <button class="btn btn-outline-success" type="submit">
                        Save
                    </button>
                    <inertia-link
                        class="btn btn-outline-info"
                        href="/locations"
                        :data="{ id: location.id }"
                        >Show on map</inertia-link
                    >
                    <form
                        class="delete-form"
                        @submit.prevent="
                            form.delete(`/locations/${location.id}`)
                        "
                    >
                        <button type="submit" class="btn btn-outline-danger">
                            Delete
                        </button>
                    </form>
                </div>
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
        </div>
    </layout>
</template>

<script>
import { _, toRefs } from "vue";
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
            latitude: location.value.latitude,
            longitude: location.value.longitude,
        });

        return { form };
    },
};
</script>

<style>
.form-container {
    padding: 2rem;
}

.delete-form {
    margin-left: 1rem;
}
</style>
