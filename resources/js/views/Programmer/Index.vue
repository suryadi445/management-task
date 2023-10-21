<template>
    <div>
        <div class="flex justify-between px-1 mb-4">
            <h3 class="font-bold">List Programmer</h3>
            <router-link to="/programmer/add" class="px-2 text-white bg-blue-600 rounded-md">
                <i class="fas fa-plus"></i>
                Add Programmer
            </router-link>
        </div>

        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
            <div class="w-full overflow-x-auto">
                <table class="w-full text-center">
                    <thead class="py-5 bg-gray-200">
                        <tr>
                            <th>Nik</th>
                            <th>Nama Programmer</th>
                            <th>Tanggal Lahir</th>
                            <th>Tempat Lahir</th>
                            <th>Alamat</th>
                            <th>Jenis Kelamin</th>
                            <th>Jabatan</th>
                            <th>Tanggal Join</th>
                            <th>Keahlian</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">

                    </tbody>
                </table>
                <!-- <pagination-component :current-page="currentPage" :total-pages="totalPages" @page-changed="onPageChanged" /> -->
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        this.fetchData()
    },
    methods: {
        fetchData() {
            axios.get('api/programmer')
                .then(res => {
                    console.log(res)
                })
                .catch(err => {
                    console.error(err);
                })
        }
    },
}
</script>