<template>
    <main>
        <header
            class="navbar navbar-expand-md navbar-light bg-white shadow-sm navbar-main"
        >
            <inertia-link class="navbar-brand" href="/">Locations</inertia-link>
            <div class="user-info" v-if="userInfo">
                <div class="navbar-brand">{{ userInfo.name }}</div>
                <form @submit.prevent="logout">
                    <button type="submit" class="btn navbar-brand">
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
        const userInfo = computed(() => usePage().props.value.user_info);

        const form = useForm();
        const logout = () => {
            form.post(route("logout"));
        };

        return { userInfo, form, logout };
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
    padding-left: 2em;
}

.navbar-brand {
    font-weight: 500;
    font-size: 1.3rem;
}

.user-info {
    display: flex;
}
</style>
