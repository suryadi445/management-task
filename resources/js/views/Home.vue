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
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr class="px-2" v-for="(item, index) in items" :key="index">
                        <td>{{ item.task }}</td>
                        <td>{{ item.project }}</td>
                        <td>{{ item.programmer }}</td>
                        <!-- <td>{{ item.deadline }}</td> -->
                        <td>{{ formatDateTime(item.deadline) }}</td>
                        <td>{{ formatDateTime(item.created_at) }}</td>
                        <td>{{ item.status }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            items: []
        }
    },
    created() {
        this.fetchData()
    },
    methods: {
        fetchData() {
            axios.get('api/task')
                .then(res => {
                    this.items = res.data
                })
                .catch(err => {
                    console.error(err);
                })
        },
        formatDateTime(dateTime) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateTime).toLocaleDateString('id-ID', options);
        }
    },
}
</script>
