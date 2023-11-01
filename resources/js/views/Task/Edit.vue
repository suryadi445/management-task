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
                    <option v-for="(item, index) in lists" :key="index">
                        {{ item.nama_project }}
                    </option>
                </select>
                <span v-if="errors.project" class="text-red-500">{{ errors.project[0] }}</span>
                <div class="flex justify-end mt-1">
                    <small class="px-2 text-white bg-purple-600 rounded-full" @click="openModal()">
                        <button type="button">
                            <i class="fa-solid fa-layer-group"></i>
                            Project
                        </button>
                    </small>
                </div>

            </div>
            <div class="mb-3">
                <label for="" class="font-bold text-gray-600">Karyawan</label>
                <select v-model="formData.karyawan"
                    class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    placeholder="Input Task Here">
                    <option value="" disabled selected>Pilih Karyawan</option>
                    <option value="Suryadi">Suryadi</option>
                    <option value="Aas">Aas</option>
                </select>
                <span v-if="errors.karyawan" class="text-red-500">{{ errors.karyawan[0] }}</span>
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

        <div v-if="isModalOpen" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75">
            <div class="gap-8 sm:flex sm:items-center sm:justify-center lg:columns-2">
                <!-- list modal -->
                <div class="p-6 mb-5 bg-white rounded-lg md:mb-0">
                    <h2 class="mb-4 text-lg font-bold text-center text-gray-700 capitalize">List Project</h2>
                    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
                        <div class="w-full overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gray-400">
                                        <th class="px-4 py-3 text-sm font-semibold text-center uppercase">Name</th>
                                        <th class="px-4 py-3 text-sm font-semibold text-center uppercase">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-700">
                                    <tr v-for="(item, index) in lists" :key="index">
                                        <td class="px-4 py-1 text-sm font-semibold text-center uppercase">
                                            <input type="text"
                                                class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                                                v-model="item.nama_project">
                                        </td>
                                        <td class="px-4 py-3 text-sm font-semibold text-center uppercase">
                                            <button type="button" @click="updateList(item.id, item.nama_project)"
                                                title="edit" class="mr-3">
                                                <i class="text-orange-300 fas fa-edit"></i>
                                            </button>
                                            <button type="button" @click="deleteList(item.id)" title="delete" class="ml-3">
                                                <i class="text-red-500 fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- add modal -->
                <div class="p-6 mb-4 bg-white rounded-lg sm:mb-0">
                    <h2 class="mb-4 text-lg font-bold text-center text-gray-700 capitalize ">Add Project</h2>
                    <form @submit.prevent="addModal">
                        <label for="" class="font-bold text-gray-600 capitalize">
                            Nama Project
                        </label>
                        <input type="text" v-model="formModal.nama_project"
                            class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <button @click="closeModal" class="px-4 py-2 text-white bg-gray-400 rounded-md">Close</button>
                            <button type="submit" class="px-4 py-2 text-white bg-purple-600 rounded-md">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { useToast } from "vue-toastification";

export default {
    data() {
        return {
            formData: {
                id: null,
                task: '',
                project: '',
                karyawan: '',
                deadline: '',
                status: '',
            },
            formModal: {
                nama_project: ''
            },
            isModalOpen: false,
            errors: {},
            lists: [],
            toast: useToast(),
        }
    },
    mounted() {
        this.fetchDataEdit();
        this.fetchModalData();
    },
    methods: {
        fetchDataEdit() {
            this.formData.id = this.$route.params.id;
            axios.get("/api/task/edit/" + this.formData.id)
                .then(res => {
                    this.formData.task = res.data.task
                    this.formData.project = res.data.project
                    this.formData.karyawan = res.data.karyawan
                    this.formData.deadline = res.data.deadline
                    this.formData.status = res.data.status
                })
                .catch(err => {
                    console.error(err);
                })
        },
        fetchModalData() {
            let loader = this.$loading.show();
            axios.get('/api/project').then(res => {
                loader.hide();
                this.lists = res.data.data
            }).catch(err => {
                this.toast.error(err.response.data.message);
            })
        },
        openModal() {
            this.formModal.nama_project = '';
            this.fetchModalData()
            this.isModalOpen = true;
        },
        closeModal() {
            this.isModalOpen = false
        },
        addModal() {
            axios.post('/api/project/save', this.formModal)
                .then(res => {
                    this.toast.success(res.data.message);
                    this.isModalOpen = false
                    this.fetchModalData()
                })
                .catch(err => {
                    this.toast.error(err.response.data.message);
                })
        },
        updateList(id, nama_project) {
            this.formModal.nama_project = nama_project;

            axios.put('/api/project/update/' + id, this.formModal).then(res => {
                this.fetchModalData()
                this.isModalOpen = false
                this.toast.success(res.data.message);
            }).catch(err => {
                this.toast.error(err.response.data.message);
            })
        },
        deleteList(id) {
            Swal.fire({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this task!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                confirmButtonColor: "#d11818",
                cancelButtonText: "No, keep it",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete('/api/project/' + id).then(res => {
                        if (res.status == 200) {
                            this.toast.success(res.data.message);
                            this.isModalOpen = false;
                            this.fetchModalData()
                        }
                    }).catch(err => {
                        this.toast.error(err.response.data.message);
                    })
                }
            });
        },
        submitAction() {
            axios.put('/api/task/update/' + this.formData.id, this.formData)
                .then(res => {
                    this.toast.success(res.data.message)
                    this.$router.push('/task');
                })
                .catch(err => {
                    this.errors = err.response.data.errors;
                    this.toast.error(err.response.data.message)
                })
        }



    }
}
</script>