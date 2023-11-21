<template>
    <div class="flex items-center justify-between px-1 mb-4">
        <h3 class="text-lg font-bold">List Task</h3>
        <router-link to="task/add" class="px-3 py-1 text-white bg-blue-600 rounded-md">
            <i class="fa-solid fa-circle-plus"></i>
            Add Task
        </router-link>
    </div>
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
        <table-component :data="items" :columns="columns" :edit="edit" :remove="remove">
        </table-component>
    </div>
</template>

<script>
import { useToast } from "vue-toastification";
import TableComponent from "../../components/TableComponent.vue";


export default {
    components: {
        TableComponent
    },
    data() {
        return {
            items: [],
            toast: useToast(),
            columns: [
                {
                    label: "Task",
                    field: "task",
                },
                {
                    label: "Project",
                    field: "project",
                },
                {
                    label: "Karyawan",
                    field: "karyawan",
                },
                {
                    label: "Deadline",
                    field: "deadline",
                },
                {
                    label: "Status",
                    field: "status",
                },
                {
                    label: 'Actions',
                    field: 'actions'
                },
            ],
            token: localStorage.getItem('access_token'),
        }
    },
    mounted() {
        this.fetchData()
    },
    methods: {
        fetchData() {
            let loader = this.$loading.show();

            axios.get(`api/task`, {
                headers: {
                    'Authorization': `Bearer ${this.token}`,
                    'Content-Type': 'application/json',
                },
            }).then(res => {
                this.items = res.data.tasks
                loader.hide()
            }).catch(err => {
                loader.hide()
                this.toast.error(err.response.data.message);
            })
        },
        formatDateTime(dateTime) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateTime).toLocaleDateString('id-ID', options);
        },
        edit(id) {
            this.$router.push('/task/show/' + id);
        },
        remove(id) {
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
                    axios.delete('api/task/' + id, {
                        headers: {
                            'Authorization': `Bearer ${this.token}`,
                            'Content-Type': 'application/json',
                        },
                    }).then(res => {
                        if (res.status == 200) {
                            this.toast.success(res.data.message);
                            this.items = this.items.filter(item => item.id !== id);
                        }
                    }).catch(err => {
                        this.toast.error(err.response.data.message);
                    })
                }
            });
        },
    },
}
</script>

