<template>
    <div class="flex flex-col sm:flex-row">
        <div class="w-full mx-3 my-3 ml-0 bg-gray-100 rounded-md sm:w-1/2 sm:order-first">
            <div class="p-4">
                <form @submit.prevent="register">
                    <div class="grid grid-cols-1">
                        <label for="">Name</label>
                        <input
                            class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                            v-model="name" placeholder="Name" />
                        <small v-if="errors">
                            <span class="text-red-500">{{ errors.name[0] }}</span>
                        </small>
                    </div>
                    <br>
                    <div class="grid grid-cols-1">
                        <label for="">Email</label>
                        <input
                            class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                            v-model="email" placeholder="Email" />
                        <small v-if="errors">
                            <span class="text-red-500">{{ errors.email[0] }}</span>
                        </small>
                    </div>
                    <br>
                    <div class="grid grid-cols-1">
                        <label for="">Password</label>
                        <input
                            class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                            v-model="password" type="password" placeholder="Password" />
                        <small v-if="errors">
                            <span class="text-red-500">{{ errors.password[0] }}</span>
                        </small>
                    </div>
                    <div class="grid grid-cols-9 gap-4">
                        <button type="submit"
                            class="w-full col-span-9 py-2 mx-auto mt-10 text-white bg-blue-600 rounded-md">
                            <span class="text-2xl font-bold">Sign Up</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 mt-4">
                        <div class="text-center">
                            Already Have an Account?
                            <router-link to="/" class="text-blue-500">
                                Login
                            </router-link>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="flex flex-col justify-center w-full p-4 sm:w-1/2 sm:order-last">
            <div class="font-serif font-medium text-center text-blue-500 sm:text-sm md:text-base lg:text-lg xl:text-xl">
                MANAGEMENT TASK
            </div>

            <div class="px-10 mt-5 text-center sm:text-sm md:text-base lg:text-lg xl:text-xl">
                Mempermudah banyak kegiatan dalam mengontrol aktifitas pekerjaan karyawan.
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            name: '',
            email: '',
            password: '',
            errors: ''
        };
    },
    methods: {
        async register() {
            try {
                const response = await axios.post('/api/register', {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                });

                const token = response.data.token;

                localStorage.setItem('access_token', token);

                this.$router.push('/karyawan');

            } catch (error) {
                this.errors = error.response.data.errors;
            }
        },
    },
};
</script>
