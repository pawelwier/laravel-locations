<template>
    <main>
        <header
            class="navbar navbar-expand-md navbar-light bg-white shadow-sm navbar-main"
        >
            <inertia-link class="navbar-brand" href="/">Locations</inertia-link>
            <div v-if="user_info">
                <div class="navbar-brand">{{ user_info.name }}</div>
                <inertia-link href="" class="navbar-brand" @click="logout"
                    >Logout</inertia-link
                >
            </div>
        </header>
        <article>
            <slot />
        </article>
    </main>
</template>
<script>
import { computed } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
export default {
    setup() {
        const user_info = computed(() => usePage().props.value.user_info);

        return { user_info };
    },

    methods: {
        logout() {
            this.$inertia.post(route("logout"));
        },
    },
};
</script>
<style>
.navbar-main {
    position: sticky;
    top: 0;
    z-index: 1;
    display: flex;
    justify-content: space-between;
}
</style>
