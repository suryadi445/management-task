<template>
    <div class="flex items-center justify-between px-1 mb-4">
        <h3 class="text-lg font-bold">Add karyawan</h3>
        <router-link to="/" class="px-3 py-1 text-white bg-yellow-400 rounded-md">
            <i class="fa-solid fa-rotate-left"></i>
        </router-link>
    </div>
    <div>
        <form @submit.prevent="submitForm">
            <div class="grid grid-cols-1 gap-4 mb-3 sm:grid-cols-2">
                <div>
                    <label for="" class="font-bold text-gray-600">NIK</label>
                    <input type="number" v-model="formData.nik"
                        class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                        placeholder="Input NIK Here" />
                </div>
                <div>
                    <label for="" class="font-bold text-gray-600">Nama</label>
                    <input type="text" v-model="formData.nama"
                        class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                        placeholder="Input Nama Here" />
                    <span v-if="errors.nama" class="text-red-500">{{ errors.nama[0] }}</span>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 mb-3 sm:grid-cols-2">
                <div>
                    <label for="" class="font-bold text-gray-600">Tanggal Lahir</label>
                    <input type="date" v-model="formData.tgl_lahir"
                        class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" />
                </div>
                <div class="columns-2">
                    <label for="" class="font-bold text-gray-600">Provinsi Kelahiran</label>
                    <select v-model="formData.provinsi_kelahiran" @change="getKabupaten(formData.provinsi_kelahiran)"
                        class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                        <option value="" selected disabled>Pilih Provinsi</option>
                        <option :value="item.value" v-for="(item, index) in provinsi" :key="index">
                            {{ item.label }}
                        </option>
                    </select>
                    <label for="" class="font-bold text-gray-600">Kabupaten Kelahiran</label>
                    <select v-model="formData.tempat_lahir" @change="changeKab(formData.tempat_lahir)"
                        class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                        <option value="" selected disabled>Pilih Kabupaten</option>
                        <option :value="item.value" v-for="(item, index) in kabupaten" :key="index">
                            {{ item.label }}
                        </option>
                    </select>


                </div>
                <input type="hidden" v-model="formData.namaProv"
                    class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" />
                <input type="hidden" v-model="formData.namaKab"
                    class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" />
            </div>

            <div class="grid grid-cols-1 gap-4 mb-3 sm:grid-cols-2">
                <div>
                    <label for="" class="font-bold text-gray-600">Nomor Handphone</label>
                    <input type="number" v-model="formData.no_hp"
                        class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" />
                </div>
                <div>
                    <label for="" class="font-bold text-gray-600">Pendidikan Terakhir</label>
                    <select v-model="formData.pendidikan_terakhir"
                        class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                        <option value="" selected disabled>Pilih Pendidikan Terakhir</option>
                        <option value="S3">S3</option>
                        <option value="S2">S2</option>
                        <option value="S1">S1</option>
                        <option value="D3">D3</option>
                        <option value="D2">D2</option>
                        <option value="D1">D1</option>
                        <option value="SMA">SMA</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 mb-3 sm:grid-cols-2">
                <div>
                    <label for="" class="font-bold text-gray-600">Jenis Kelamin</label>
                    <div class="flex items-center mt-2">
                        <input type="radio" value="pria" v-model="formData.jenis_kelamin" name="radio"
                            class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                        <label for="pria" class="ml-2 mr-5 text-gray-700">Laki-Laki</label>
                        <input type="radio" value="wanita" v-model="formData.jenis_kelamin" name="radio"
                            class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                        <label for="wanita" class="ml-2 text-gray-700">Perempuan</label>
                    </div>
                </div>
                <div>
                    <label for="" class="font-bold text-gray-600">Alamat</label>
                    <textarea v-model="formData.alamat" id="description" name="description" rows="3"
                        class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 mb-3 sm:grid-cols-2">
                <div>
                    <label for="" class="font-bold text-gray-600">Status</label>
                    <select v-model="formData.status"
                        class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                        <option value="" selected disabled>Pilih Status Karyawan</option>
                        <option v-for="option in status" :value="option.value" :key="option.id">{{ option.label }}</option>
                    </select>
                    <div class="flex justify-end mt-1">
                        <small class="px-2 text-white bg-purple-600 rounded-full" @click="openModal('status')">
                            <button type="button">
                                <i class="fa-solid fa-layer-group"></i>
                                Status
                            </button>
                        </small>
                    </div>
                </div>
                <div>
                    <label for="" class="font-bold text-gray-600">Jabatan</label>
                    <select v-model="formData.jabatan"
                        class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                        <option value="" selected disabled>Pilih Jabatan</option>
                        <option v-for="option in jabatan" :value="option.value" :key="option.id">{{ option.label }}
                        </option>
                    </select>
                    <div class="flex justify-end mt-1">
                        <small class="px-2 text-white bg-purple-600 rounded-full" @click="openModal('jabatan')">
                            <button type="button">
                                <i class="fa-solid fa-layer-group"></i>
                                Jabatan
                            </button>
                        </small>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 mb-3 sm:grid-cols-2">
                <div>
                    <label for="" class="font-bold text-gray-600">Tanggal Join</label>
                    <input type="date" v-model="formData.tgl_join" @change="changeKontrak(formData.tgl_join)"
                        class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" />
                </div>
                <div>
                    <label for="" class="font-bold text-gray-600">Selesai Kontrak</label>
                    <input type="date" v-model="formData.selesai_kontrak"
                        class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" />
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 mb-3 sm:grid-cols-2">
                <div>
                    <label for="" class="font-bold text-gray-600">Keahlian</label>
                    <select v-model="formData.keahlian"
                        class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                        <option value="" selected disabled>Pilih Keahlian</option>
                        <option v-for="option in keahlian" :value="option.value" :key="option.id">
                            {{ option.label }}
                        </option>
                    </select>
                    <div class="flex justify-end mt-1">
                        <small class="px-2 text-white bg-purple-600 rounded-full" @click="openModal('keahlian')">
                            <button type="button">
                                <i class="fa-solid fa-layer-group"></i>
                                Keahlian
                            </button>
                        </small>
                    </div>
                </div>
                <div>
                    <label for="" class="font-bold text-gray-600">Npwp</label>
                    <input type="text" v-model="formData.npwp"
                        class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" />
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 mb-3 sm:grid-cols-2">
                <div>
                    <label for="" class="font-bold text-gray-600">Rekening</label>
                    <input type="text" v-model="formData.rekening"
                        class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" />
                </div>
                <div>
                    <label for="" class="font-bold text-gray-600">Keterangan</label>
                    <textarea v-model="formData.keterangan" rows="3"
                        class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                </div>
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
                    <h2 class="mb-4 text-lg font-bold capitalize">List {{ modalTitle }}</h2>
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
                                    <tr class="bg-gray-100" v-for="(list, index) in lists" :key="index">
                                        <td class="px-4 py-1 text-sm font-semibold text-center uppercase">
                                            <input type="text"
                                                class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                                                v-model="list.name">
                                        </td>
                                        <td class="px-4 py-3 text-sm font-semibold text-center uppercase">
                                            <button type="button" @click="updateList(list.id, list.name)" title="edit"
                                                class="mr-3">
                                                <i class="text-orange-300 fas fa-edit"></i>
                                            </button>
                                            <button type="button" @click="deleteList(list.id)" title="delete" class="ml-3">
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
                    <h2 class="mb-4 text-lg font-bold capitalize">Add {{ modalTitle }}</h2>
                    <form @submit.prevent="addModal">
                        <label for="" class="font-bold text-gray-600 capitalize">{{ modalTitle }}</label>
                        <input type="text" v-model="formModal.name"
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
            isModalOpen: false,
            modalTitle: '',
            title: '',
            formModal: {
                name: ''
            },
            formData: {
                nik: '',
                nama: '',
                tgl_lahir: '',
                provinsi_kelahiran: '',
                namaProv: '',
                namaKab: '',
                tempat_lahir: '',
                no_hp: '',
                pendidikan_terakhir: '',
                jenis_kelamin: '',
                alamat: '',
                status: '',
                jabatan: '',
                tgl_join: '',
                selesai_kontrak: '',
                keahlian: '',
                npwp: '',
                rekening: '',
                keterangan: '',
            },
            errors: {},
            formEdit: [],
            status: [],
            jabatan: [],
            keahlian: [],
            toast: useToast(),
            lists: [],
            provinsi: [],
            kabupaten: [],
        }
    },
    mounted() {
        this.getProvinsi()
        this.getStatus()
        this.getJabatan()
        this.getKeahlian()
    },
    methods: {
        getKeahlian() {
            axios.get('/api/keahlian').then(res => {
                this.keahlian = res.data.data.map(item => {
                    return {
                        id: item.id,
                        value: item.name,
                        label: item.name,
                    };
                });
            }).catch(err => {
                this.toast.error(err);
            });
        },
        getStatus() {
            axios.get('/api/status').then(res => {
                this.status = res.data.data.map(item => {
                    return {
                        id: item.id,
                        value: item.name,
                        label: item.name,
                    };
                });
            }).catch(err => {
                this.toast.error(err);
            });
        },
        getJabatan() {
            axios.get('/api/jabatan').then(res => {
                this.jabatan = res.data.data.map(item => {
                    return {
                        id: item.id,
                        value: item.name,
                        label: item.name,
                    };
                });
            }).catch(err => {
                this.toast.error(err);
            });
        },
        getProvinsi() {
            axios.get("https://dev.farizdotid.com/api/daerahindonesia/provinsi").then((response) => {
                let data = response.data.provinsi;
                if (Array.isArray(data)) {
                    this.provinsi = data.map(item => {
                        return {
                            value: item.id,
                            label: item.nama,
                        };
                    });
                } else {
                    console.error("Response data is not an array.");
                }
            }).catch((error) => {
                console.error(error);
            });
        },
        getKabupaten(idKab) {
            let loader = this.$loading.show();

            const selectedProvinsi = this.provinsi.find(item => item.value === idKab);
            if (selectedProvinsi) {
                this.formData.namaProv = selectedProvinsi.label;
                this.formData.namaKab = '';
            }

            axios.get("https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=" + idKab).then((response) => {
                let data = response.data.kota_kabupaten;
                if (Array.isArray(data)) {
                    this.kabupaten = data.map(item => {
                        return {
                            value: item.id,
                            label: item.nama,
                        };
                    });
                    loader.hide();
                } else {
                    console.error("Response data is not an array.");
                }
            }).catch((error) => {
                console.error(error);
            });
        },
        changeKab(idKab) {
            const selectedKabupaten = this.kabupaten.find(item => item.value === idKab);
            if (selectedKabupaten) {
                this.formData.namaKab = selectedKabupaten.label;
            }
        },
        closeModal() {
            this.isModalOpen = false
        },
        openModal(param) {
            let loader = this.$loading.show();
            this.isModalOpen = true;
            this.modalTitle = param

            axios.get('/api/' + param)
                .then(res => {
                    loader.hide();
                    this.lists = res.data.data
                })
                .catch(err => {
                    console.error(err);
                })
        },
        updateList(id, name) {
            let param = this.modalTitle
            axios.put('/api/' + param + '/update/' + id, { name })
                .then(res => {
                    if (res.status == 200) {
                        this.toast.success(res.data.message);
                        this.isModalOpen = false;
                        this.getStatus()
                        this.getJabatan()
                        this.getKeahlian()
                    }
                })
                .catch(err => {
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
                    let param = this.modalTitle
                    axios.delete('/api/' + param + '/delete/' + id)
                        .then(res => {
                            if (res.status == 200) {
                                this.toast.success(res.data.message);
                                this.isModalOpen = false;
                                this.getStatus()
                                this.getJabatan()
                                this.getKeahlian()
                            }
                        })
                        .catch(err => {
                            this.toast.error(err.response.data.message);
                        })
                }
            });
        },
        addModal() {
            this.title = this.modalTitle;
            axios.post('/api/' + this.title + '/save', this.formModal)
                .then(res => {
                    if (res.status == 200) {
                        this.formModal.name = '';
                        this.toast.success(res.data.message);
                        this.isModalOpen = false;
                        this.getStatus()
                        this.getJabatan()
                        this.getKeahlian()
                    } else {
                        this.toast.error(res.data.message);

                    }
                })
                .catch(err => {
                    this.toast.error(err);
                })
        },
        changeKontrak(tgl_join) {
            const joinedDate = new Date(tgl_join);
            const selesaiKontrak = new Date(joinedDate);
            selesaiKontrak.setFullYear(selesaiKontrak.getFullYear() + 1);
            this.formData.selesai_kontrak = selesaiKontrak.toISOString().slice(0, 10);
        },
        submitForm() {

            let loader = this.$loading.show();

            axios.post('/api/karyawan/save', this.formData)
                .then(response => {
                    if (response.status === 200) {
                        loader.hide();

                        this.toast.success(response.data.message);
                        this.$router.push('/karyawan');
                    }
                })
                .catch(error => {
                    loader.hide();

                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                        this.toast.error(error.response.data.message);
                    }
                });
        }

    },
}
</script>