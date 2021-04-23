<template>
    <form @submit.prevent="submitLogin">
        <div class="login-element-wrapper">
            <div class="login-form-label">Email:</div>
            <input
                class="form-control"
                type="email"
                v-model="form.email"
                required
                autofocus
            />
        </div>

        <div class="login-element-wrapper mt-2">
            <div class="login-form-label">Password:</div>
            <input
                class="form-control"
                type="password"
                v-model="form.password"
                required
                autocomplete="current-password"
            />
        </div>

        <div class="block mt-4">
            <input type="checkbox" name="remember" v-model="form.remember" />
            <span class="ml-2 text-sm text-gray-600">Remember me</span>
        </div>

        <div class="flex items-center justify-end mt-4">
            <inertia-link
                v-if="canResetPassword"
                :href="route('password.request')"
                class="underline text-sm text-gray-600 hover:text-gray-900"
            >
                Forgot your password?
            </inertia-link>

            <button
                class="btn btn-primary"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
                type="submit"
            >
                Log in
            </button>
        </div>
    </form>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";

export default {
    // methods: {
    //     submit() {
    //         this.form
    //             .transform((data) => ({
    //                 ...data,
    //                 remember: this.form.remember ? "on" : "",
    //             }))
    //             .post(this.route("login"), {
    //                 onFinish: () => this.form.reset("password"),
    //             });
    //     },
    // },

    setup() {
        const form = useForm({
            email: "",
            password: "",
            remember: false,
        });

        const submitLogin = () => {
            console.log(form);
            form.post("/login");
        };

        return {
            form,
            submitLogin,
        };
    },
};
</script>
<style scoped>
form {
    padding: 1rem;
    margin: 1rem;
    background-color: #e9ecef;
    max-width: 400px;
}
.login-form-label {
    font-size: 1.2rem;
    padding-bottom: 0.3rem;
}

.login-element-wrapper {
    display: flex;
    gap: 0.5rem;
}
</style>
