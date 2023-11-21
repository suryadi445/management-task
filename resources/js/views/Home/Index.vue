<template>
    <div class="grid grid-cols-1">
        <div class="grid grid-cols-1">
            <h2 class="text-3xl font-bold text-center text-stone-600">Login Page</h2>
        </div>
        <form @submit.prevent="login">
            <div class="grid grid-cols-1">
                <label for="">Email</label>
                <input
                    class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                    v-model="email" placeholder="Email" />
            </div>
            <br>
            <div class="grid grid-cols-1">
                <label for="">Password</label>
                <input type="password"
                    class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                    v-model="password" placeholder="Password" />
            </div>

            <div class="grid grid-cols-9 gap-4">
                <button type="submit" class="w-full col-span-5 col-start-3 py-2 mt-10 text-white bg-blue-600 rounded-md">
                    <span class="text-xl font-bold">
                        Log in
                    </span>
                </button>
            </div>

            <div class="grid grid-cols-9">
                <div class="col-span-5 col-start-3 mt-1 ml-2">
                    <router-link to="/" class="text-blue-500">
                        Forgot password?
                    </router-link>
                </div>
            </div>

            <div class="grid grid-cols-1 mt-4">
                <div class="text-center">
                    Create new account?
                    <router-link to="/registrasi" class="text-blue-500">
                        Registration
                    </router-link>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
import { useToast } from "vue-toastification";

export default {
    data() {
        return {
            email: '',
            password: '',
            toast: useToast(),
        };
    },
    methods: {
        async login() {
            try {
                const response = await axios.post("/api/login", {
                    email: this.email,
                    password: this.password,
                });

                this.toast.success(response.data.message);

                const token = response.data.token;

                localStorage.setItem('access_token', token);

                this.$router.push('/karyawan');
            } catch (error) {
                this.toast.error(error.response.data.message);
            }
        },
    },
};
</script>
