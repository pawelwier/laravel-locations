<template>
    <main>
        <header
            class="navbar navbar-expand-md navbar-light bg-white shadow-sm navbar-main"
        >
            <inertia-link class="navbar-brand" href="/">Locations</inertia-link>
            <div class="user-info" v-if="user_info">
                <div class="navbar-brand">{{ user_info.name }}</div>
                <form @submit.prevent="logout">
                    <button type="submit" class="btn btn-outline">
                        Logout
                    </button>
                </form>
            </div>
        </header>
        <article>
            <slot />
        </article>
    </main>
</template>
<script>
import { computed } from "vue";
import { usePage, useForm } from "@inertiajs/inertia-vue3";
export default {
    setup() {
        const user_info = computed(() => usePage().props.value.user_info);

        const form = useForm();
        const logout = () => {
            form.value.post(route("logout"));
        };

        return { user_info, form, logout };
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

.user-info {
    display: flex;
}
</style>
