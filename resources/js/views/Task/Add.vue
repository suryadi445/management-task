<template>
    <div class="flex items-center justify-between px-1 mb-4">
        <h3 class="text-lg font-bold">Add Task</h3>
        <router-link to="/" class="px-3 py-1 text-white bg-yellow-400 rounded-md">
            <i class="fa-solid fa-rotate-left"></i>
        </router-link>
    </div>
    <div>
        <form @submit.prevent="submitAction">
            <div class="mb-3">
                <label for="" class="font-bold text-gray-600">Task</label>
                <input type="text" v-model="formData.task"
                    class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Input Task Here">
                <span v-if="errors.task" class="text-red-500">{{ errors.task[0] }}</span>
            </div>
            <div class="mb-3">
                <label for="" class="font-bold text-gray-600">Project</label>
                <select v-model="formData.project"
                    class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Input Task Here">
                    <option value="" disabled selected>Pilih Project</option>
                    <option value="Project 1">Project 1</option>
                    <option value="Project 2">Project 2</option>
                    <option value="Project 3">Project 3</option>
                </select>
                <span v-if="errors.project" class="text-red-500">{{ errors.project[0] }}</span>
            </div>
            <div class="mb-3">
                <label for="" class="font-bold text-gray-600">Programmer</label>
                <select v-model="formData.programmer"
                    class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Input Task Here">
                    <option value="" disabled selected>Pilih Programmer</option>
                    <option value="Suryadi">Suryadi</option>
                    <option value="Aas">Aas</option>
                </select>
                <span v-if="errors.programmer" class="text-red-500">{{ errors.programmer[0] }}</span>
            </div>
            <div class="mb-3">
                <label for="" class="font-bold text-gray-600">Deadline</label>
                <input type="date" ref="deadlineInput" v-model="formData.deadline"
                    class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Input Task Here">
                <span v-if="errors.deadline" class="text-red-500">{{ errors.deadline[0] }}</span>
            </div>
            <div class="mb-3">
                <label for="" class="font-bold text-gray-600">Status</label>
                <select v-model="formData.status"
                    class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Input Task Here">
                    <option value="" disabled selected>Pilih Status Task</option>
                    <option value="Fast">Fast</option>
                    <option value="Medium">Medium</option>
                    <option value="Slow">Slow</option>
                </select>
                <span v-if="errors.status" class="text-red-500">{{ errors.status[0] }}</span>
            </div>

            <button type="submit" class="w-full py-2 mt-10 text-white bg-blue-600 rounded-md">
                <i class="fas fa-save"></i>
                Submit
            </button>
        </form>
    </div>
</template>

<script>
import { useToast } from "vue-toastification";

export default {
    data() {
        return {
            formData: {
                task: '',
                project: '',
                programmer: '',
                deadline: '',
                status: '',
            },
            errors: {},
            items: [],
            toast: useToast(),
        }
    },
    mounted() {
        this.setDefaultDeadline();
    },
    methods: {
        submitAction() {
            axios.post('/api/task', this.formData)
                .then(response => {
                    console.log(response);
                    if (response.status === 200) {
                        this.toast.success(response.data.message);
                        this.$router.push('/');
                    }
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                        this.toast.error(error.response.data.message);
                    }
                });
        },
        setDefaultDeadline() {
            const today = new Date();
            const threeDaysLater = new Date(today.getTime() + (3 * 24 * 60 * 60 * 1000));
            const day = threeDaysLater.getDay();
            if (day === 0) {
                threeDaysLater.setDate(threeDaysLater.getDate() + 1);
            } else if (day === 6) {
                threeDaysLater.setDate(threeDaysLater.getDate() + 2);
            }
            const formattedDate = threeDaysLater.toISOString().slice(0, 10);
            this.formData.deadline = formattedDate;
            this.$refs.deadlineInput.value = formattedDate;
        }
    }
}
</script>