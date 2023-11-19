
<template>
    <div>
        <form @submit.prevent="submitForm">
            <div class="w-full ">
                <label for="" class="font-bold text-gray-600">Logo</label>
                <div class="flex">
                    <input type="file" @change="logoChange"
                        class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" />
                    <img v-if="imageLogo" :src="imageLogo" class="pl-2" width="50" alt="Logo" />


                </div>
            </div>

            <div class="w-full mt-3">
                <label for="" class="font-bold text-gray-600">Jam Masuk</label>
                <div class="flex">
                    <input type="time" v-model="formData.jam_masuk_kerja"
                        class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" />
                </div>
            </div>

            <div class="w-full mt-3">
                <label for="" class="font-bold text-gray-600">Jam Pulang</label>
                <div class="flex">
                    <input type="time" v-model="formData.jam_pulang_kerja"
                        class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" />
                </div>
            </div>

            <div class="w-full mt-3">
                <label for="" class="font-bold text-gray-600">Hari Kerja</label>
                <div class="flex">
                    <Multiselect v-model="formData.weekdays" :options="options" mode="tags" :close-on-select="false"
                        :searchable="true" :create-option="true" />
                </div>
            </div>

            <div class="w-full mt-3">
                <label for="" class="font-bold text-gray-600">Latitude</label>
                <div class="flex">
                    <div class="flex items-center w-full">
                        <input type="text" v-model="formData.latitude"
                            class="w-full px-3 py-2 border rounded-l focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                            placeholder="Latitude">
                        <span @click="openModal('latitude')"
                            class="px-3 py-2 text-gray-100 bg-green-700 border-2 border-green-700 rounded-r hover:cursor-pointer">
                            <i class="fa-solid fa-map-location-dot"></i>
                        </span>
                    </div>
                </div>

            </div>

            <div class="w-full mt-3">
                <label for="" class="font-bold text-gray-600">Longitude</label>
                <div class="flex">
                    <div class="flex items-center w-full">
                        <input type="text" v-model="formData.longitude"
                            class="w-full px-3 py-2 border rounded-l focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent"
                            placeholder="Longitude">
                        <span @click="openModal('longitude')"
                            class="px-3 py-2 text-gray-100 bg-green-700 border-2 border-green-700 rounded-r hover:cursor-pointer">
                            <i class="fa-solid fa-map-location-dot"></i>
                        </span>
                    </div>
                </div>
            </div>

            <div class="w-full mt-3">
                <label for="" class="font-bold text-gray-600">Email</label>
                <div class="flex">
                    <input type="email" v-model="formData.email"
                        class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" />
                </div>
            </div>

            <div class="w-full mt-3">
                <label for="" class="font-bold text-gray-600">No. Handphone</label>
                <div class="flex">
                    <input type="number" v-model="formData.phone"
                        class="w-full px-2 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent" />
                </div>
            </div>

            <div class="w-full mt-3">
                <label for="" class="font-bold text-gray-600">Alamat</label>
                <div class="flex">
                    <textarea v-model="formData.alamat" rows="3"
                        class="w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent">
                </textarea>
                </div>
            </div>

            <div class="grid grid-cols-1 mt-5">
                <button type="submit" class="block w-full text-gray-200 bg-purple-500 rounded-md h-11">
                    <i class="fas fa-save sm:mr-1"></i>
                    Update
                </button>
            </div>
        </form>

        <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75">
            <div
                class="flex flex-col items-center w-full max-w-screen-lg p-4 mx-4 bg-white rounded-3xl modal-content sm:mx-8 md:mx-auto ">
                <div style="height: 400px" class="w-full" ref="map">
                    <l-map ref="map" :use-global-leaflet="false" v-model:zoom="zoom" :center="center" @click="onMapClick">
                        <l-tile-layer url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png" layer-type="base" map
                            name="OpenStreetMap"></l-tile-layer>
                        <l-marker :lat-lng="marker"></l-marker>
                    </l-map>
                </div>


                <div>
                    <button @click="closeModal"
                        class="px-4 py-2 mx-4 mt-4 text-sm text-gray-100 bg-green-700 rounded-full sm:mx-8 hover:text-green-600 hover:bg-green-100"
                        title="Close">
                        X
                    </button>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
import "leaflet/dist/leaflet.css";
import { LMap, LTileLayer, LMarker } from "@vue-leaflet/vue-leaflet";
import Multiselect from '@vueform/multiselect'
import { useToast } from "vue-toastification";

export default {
    components: {
        LMap,
        LTileLayer,
        LMarker,
        Multiselect
    },
    data() {
        return {
            options: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
            showModal: false,
            map: null,
            zoom: 16,
            center: [-6.2860661, 106.7392675],
            marker: [-6.2860661, 106.7392675],
            formData: {
                logo: '',
                weekdays: [],
                jam_masuk_kerja: '',
                jam_pulang_kerja: '',
                latitude: null,
                longitude: null,
                email: '',
                phone: '',
                alamat: '',
            },
            imageLogo: null,
            toast: useToast(),
        }
    },
    methods: {
        async submitForm() {
            let loader = this.$loading.show();

            const formData = new FormData();
            Object.keys(this.formData).forEach(key => {
                if (key === 'logo') {
                    formData.append('logo', this.formData.logo);
                } else {
                    formData.append(key, this.formData[key]);
                }
            });


            try {
                const response = await axios.post('/api/setting/save', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                    },
                });


                loader.hide();
                this.toast.success(response.data.message);

                this.fetchData()
            } catch (error) {
                loader.hide();
            }
        },
        async fetchData() {
            let loader = this.$loading.show();
            try {
                const response = await axios.get('api/setting');
                const weekdaysFromAPI = response.data.data.weekdays;
                this.formData = response.data.data;

                if (response.data.data.logo) {
                    this.imageLogo = '/image/setting/' + response.data.data.logo;
                }

                if (typeof weekdaysFromAPI === 'string') {
                    this.formData.weekdays = weekdaysFromAPI.split(',');
                    loader.hide();
                } else {
                    loader.hide();
                }


            } catch (error) {
                loader.hide();
            }
        },
        logoChange(event) {
            this.formData.logo = event.target.files[0];
        },
        openModal() {
            this.fetchData();
            this.showModal = true
        },
        closeModal() {
            this.showModal = false
        },
        onMapClick(event) {
            this.formData.latitude = event.latlng.lat;
            this.formData.longitude = event.latlng.lng;

            this.center = [this.formData.latitude, this.formData.longitude];
            this.marker = [this.formData.latitude, this.formData.longitude];
        }
    },
    created() {
        this.fetchData();

    },
}

</script>

<style>
.multiselect.is-open.is-active {
    border: 1px solid #e5e7eb;
    border-radius: 0.375rem;
    outline: none;
    box-shadow: 0 0 0 2px rgb(75, 160, 230);

}
</style>

<style src="@vueform/multiselect/themes/default.css"></style>
