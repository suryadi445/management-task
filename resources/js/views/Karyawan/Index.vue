<template>
    <div class="flex justify-between px-1 mb-4">
        <h3 class="font-bold">List karyawan</h3>
        <router-link to="/karyawan/add" class="px-2 text-white bg-blue-600 rounded-md">
            <i class="fas fa-plus"></i>
            Add karyawan
        </router-link>
    </div>

    <table-component :data="karyawanData" :columns="columns" :edit="edit" :remove="remove">
    </table-component>
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
            toast: useToast(),
            karyawanData: [],
            token: localStorage.getItem('access_token'),
            columns: [
                {
                    label: "NIK",
                    field: "nik",
                },
                {
                    label: "Nama",
                    field: "nama",
                },
                {
                    label: "Tanggal Lahir",
                    field: "tgl_lahir",
                },
                {
                    label: "Tempat Lahir",
                    field: "namaKab",
                },
                {
                    label: "No Handphone",
                    field: "no_hp",
                },
                {
                    label: "Pendidikan Terakhir",
                    field: "pendidikan_terakhir",
                },
                {
                    label: "Jenis Kelamin",
                    field: "jenis_kelamin",
                },
                {
                    label: "Alamat",
                    field: "alamat",
                },
                {
                    label: "Status",
                    field: "status",
                },
                {
                    label: "Jabatan",
                    field: "jabatan",
                },
                {
                    label: "Tanggal Join",
                    field: "tgl_join",
                },
                {
                    label: "Selesai Kontrak",
                    field: "selesai_kontrak",
                },
                {
                    label: "Keahlian",
                    field: "keahlian",
                },
                {
                    label: "NPWP",
                    field: "npwp",
                },
                {
                    label: "Rekening",
                    field: "rekening",
                },
                {
                    label: "Keterangan",
                    field: "keterangan",
                },
                {
                    label: 'Actions',
                    field: 'actions'
                },
            ],
        };
    },
    mounted() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            let loader = this.$loading.show();
            axios.get('api/karyawan', {
                headers: {
                    'Authorization': `Bearer ${this.token}`,
                    'Content-Type': 'application/json',
                },
            }).then(res => {
                this.karyawanData = res.data.Karyawan
                loader.hide();
            }).catch(err => {
                this.toast.error(err.response.data.message);
            })

        },
        edit(id) {
            this.$router.push('/karyawan/show/' + id);
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
                    axios.delete('api/karyawan/delete/' + id, {
                        headers: {
                            'Authorization': `Bearer ${this.token}`,
                            'Content-Type': 'application/json',
                        },
                    }).then(res => {
                        if (res.status == 200) {
                            this.toast.success(res.data.message);
                            this.karyawanData = this.karyawanData.filter(karyawan => karyawan.id !== id);
                        }
                    }).catch(err => {
                        this.toast.error(err.response.data.message);
                    })
                }
            });
        },
        getNamaKab(idKab) {
            console.log(idKab);
        }
    }
};
</script>
