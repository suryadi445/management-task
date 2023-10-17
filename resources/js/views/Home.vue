<template>
    <div class="flex items-center justify-between px-1 mb-4">
        <h3 class="text-lg font-bold">List Task</h3>
        <router-link to="task" class="px-3 py-1 text-white bg-blue-600 rounded-md">
            <i class="fa-solid fa-circle-plus"></i>
            Add Task
        </router-link>
    </div>
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
        <div class="w-full overflow-x-auto">
            <table class="w-full text-center">
                <thead class="py-5 bg-gray-200">
                    <tr>
                        <th>Nama Task</th>
                        <th>Project</th>
                        <th>Programmer</th>
                        <th>Deadline</th>
                        <th>Tanggal Dibuat</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="px-2" v-for="(item, index) in items" :key="index">
                        <td>{{ item.task }}</td>
                        <td>{{ item.project }}</td>
                        <td>{{ item.programmer }}</td>
                        <td>{{ formatDateTime(item.deadline) }}</td>
                        <td>{{ formatDateTime(item.created_at) }}</td>
                        <td>{{ item.status }}</td>
                        <td>
                            <div class="flex justify-center">
                                <router-link :to="'task/show/' + item.id"
                                    class="px-2 py-1 mr-2 text-yellow-400 hover:text-yellow-500 hover:rounded-md hover:px-1 hover:text-xl"
                                    title="edit">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </router-link>
                                <button @click="deleteTask(item.id)"
                                    class="px-2 py-1 ml-2 text-red-400 hover:rounded-md hover:px-1 hover:text-red-700 hover:text-xl"
                                    title="delete">
                                    <i class="fas fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <pagination :current-page="currentPage" :total-pages="totalPages" @page-changed="onPageChanged" />
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { useToast } from "vue-toastification";
import Swal from "sweetalert2";
import Pagination from '../components/PaginationComponent.vue';



export default {
    data() {
        return {
            items: [],
            toast: useToast(),
            currentPage: 1,
            totalPages: 1,
            pageSize: 5,
        }
    },
    components: {
        Pagination
    },
    mounted() {
        this.fetchData()
    },
    methods: {
        fetchData() {
            axios.get(`api/task?page=${this.currentPage}&pageSize=${this.pageSize}`)
                .then(res => {
                    console.log(res);
                    this.items = res.data.tasks.data
                    this.totalPages = res.data.totalPages;

                })
                .catch(err => {
                    console.error(err);
                })
        },
        formatDateTime(dateTime) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateTime).toLocaleDateString('id-ID', options);
        },
        deleteTask(id) {
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
                    axios.delete('api/task/' + id)
                        .then(res => {
                            if (res.status == 200) {
                                this.toast.success(res.data.message);
                                this.items = this.items.filter(item => item.id !== id);
                            }
                        })
                        .catch(err => {
                            this.toast.error(err.response.data.message);
                            console.error(err);
                        })
                }
            });
        }, onPageChanged(page) {
            this.currentPage = page;

            this.fetchData()
        },
    },
}
</script>

