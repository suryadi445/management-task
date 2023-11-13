<template>
    <div class="px-2 py-3 border rounded-md shadow-lg">
        <div class="grid grid-cols-2 gap-4 mb-5">
            <button type="button" @click="openCamera" class="px-3 py-1 mx-3 text-white bg-blue-600 rounded-md basis-1/3">
                <i class="fa-solid fa-unlock"></i>
                Open Camera
            </button>
            <button @click="stopMedia" class="px-3 py-1 mx-3 text-white bg-red-400 rounded-md basis-1/3">
                <i class="fa-solid fa-circle-stop"></i>
                Stop Camera
            </button>
        </div>
        <div class="grid grid-cols-3 gap-2 max-h-96">
            <div class="col-span-2">
                <video ref="video" width="640" height="480" autoplay></video>
                <canvas ref="canvas" style="display: none;"></canvas>
            </div>
            <div class="text-center">
                <h3 class="font-semibold text-red-500">Absensi</h3>
                <div>
                    <p>{{ currentDate }}</p>
                    <p>{{ currentDay }}</p>
                </div>
                <div>
                    <p>{{ currentTime }}</p>
                </div>
                <div class="mt-3">
                    <button @click="capture('masuk')" class="px-3 text-white bg-green-700 rounded-md ">
                        <i class="fa-solid fa-camera"></i>
                        Absensi Masuk
                    </button>
                    <br>
                    <br>
                    <button @click="capture('pulang')" class="px-3 text-white bg-blue-900 rounded-md ">
                        <i class="fa-solid fa-camera"></i>
                        Absensi Pulang
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="px-2 py-3 mt-4 border rounded-md shadow-lg">
        <div class="grid grid-cols-1 mb-4">
            <div class="text-2xl text-center">
                <p>List Absensi</p>
            </div>
        </div>

        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
            <table-component :data="items" :columns="columns" @click="positionClick"></table-component>

        </div>

        <div v-if="showModal" class="fixed inset-0 flex items-center justify-center bg-gray-500 bg-opacity-75">
            <div
                class="flex flex-col items-center w-full max-w-screen-lg p-4 mx-4 bg-white rounded-3xl modal-content sm:mx-8 md:mx-auto ">
                <div style="height: 400px" class="w-full" ref="map">
                    <l-map ref="map" :use-global-leaflet="false" v-model:zoom="zoom" :center="center">
                        <l-tile-layer url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png" layer-type="base"
                            name="OpenStreetMap"></l-tile-layer>
                        <l-marker :lat-lng="marker"></l-marker>
                    </l-map>
                </div>
                <button @click="closeModal" v-if="this.closeModalText == 'X'"
                    class="px-4 py-2 mx-4 mt-4 text-sm text-gray-500 bg-gray-100 rounded-full sm:mx-8 hover:text-green-600 hover:bg-red-100"
                    title="Close">
                    X
                </button>

                <div v-if="this.closeModalText == 'Lanjutkan Absensi'">
                    <button @click="closeModal"
                        class="px-4 py-2 mx-4 mt-4 text-sm text-gray-100 bg-green-700 rounded-full sm:mx-8 hover:text-green-600 hover:bg-green-100"
                        title="Close">
                        {{ closeModalText }}
                    </button>
                    <button @click="closeModalReload"
                        class="px-4 py-2 mx-4 mt-4 text-sm text-gray-100 bg-red-600 rounded-full sm:mx-8 hover:text-red-600 hover:bg-red-100"
                        title="Close">
                        Perbaiki Maps
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment-timezone';
import TableComponent from "../../components/TableComponent.vue";
import { useToast } from "vue-toastification";
import "leaflet/dist/leaflet.css";
import { LMap, LTileLayer, LMarker } from "@vue-leaflet/vue-leaflet";
import 'leaflet/dist/leaflet.css';


export default {
    components: {
        TableComponent,
        LMap,
        LTileLayer,
        LMarker,
    },
    data() {
        return {
            map: null,
            zoom: 16,
            center: null,
            marker: null,

            closeModalText: 'X',
            showModal: false,
            mediaStream: null,
            currentDate: '',
            currentDay: '',
            currentTime: '',
            previousLocation: null,
            latitude: '',
            longitude: '',
            toast: useToast(),
            formData: {
                'image': '',
                'latitude': '',
                'longitude': '',
                'keterangan': '',
            },
            items: [],
            columns: [
                {
                    label: 'Image',
                    field: 'images',
                    sortable: false,
                },
                {
                    label: "Nama Karyawan",
                    field: "nama_karyawan",
                    sortable: false,
                },
                {
                    label: "Jabatan",
                    field: "jabatan",
                    sortable: false,
                },
                {
                    label: "Tanggal Absensi",
                    field: "tanggal",
                    firstSortType: 'desc'
                },
                {
                    label: "Jam Absensi",
                    field: "jam",
                },
                {
                    label: "Jam Pulang",
                    field: "jam_pulang",
                },
                {
                    label: "Position",
                    field: 'position',
                    sortable: false,
                },
            ],
        };
    },
    methods: {
        positionClick(event) {

            if (event.target.tagName === 'SPAN') {
                const coordinates = event.target.innerText.split(',').map(coord => coord.trim());
                const latitude = coordinates[0];
                const longitude = coordinates[1];

                this.marker = [latitude, longitude];
                this.center = [latitude, longitude];

                if (latitude && longitude) {
                    const regex = /^[-0-9.]+$/;
                    if (regex.test(latitude)) {
                        this.showModal = true;
                    }
                }
            }
        },
        openModal() {
            this.showModal = true;
            this.initializeMap();
        },
        closeModal() {
            this.showModal = false;
        },
        closeModalReload() {
            this.showModal = false;
            this.stopMedia();
            this.getLocation();
        },
        initializeMap() {
            this.map = L.map(this.$refs.map).setView(this.center, this.zoom);

            const googleLayer = new L.Google();
            this.map.addLayer(googleLayer);
        },
        async capture(keterangan) {
            const video = this.$refs.video;
            const canvas = this.$refs.canvas;
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const image = canvas.toDataURL('image/jpeg');


            this.postImage(image, keterangan);

        },
        async postImage(image, keterangan) {

            this.formData.image = image;
            this.formData.latitude = this.latitude;
            this.formData.longitude = this.longitude;
            this.formData.keterangan = keterangan;

            try {
                let response = await axios.post("/api/absensi/save", this.formData);

                this.fetchData();
                this.stopMedia();

                this.toast.success(response.data.message);
            } catch (error) {
                this.toast.error(error.response.data.message);
            }
        },
        stopMedia() {
            const stream = this.$refs.video.srcObject;
            const tracks = stream.getTracks();
            tracks.forEach(track => track.stop());
            this.$refs.video.srcObject = null;
        },
        async openCamera() {

            console.log(this.latitude)
            let latitude = this.latitude;
            let longitude = this.longitude;

            this.marker = [latitude, longitude];
            this.center = [latitude, longitude];

            this.showModal = true;
            this.closeModalText = 'Lanjutkan Absensi';

            try {
                const constraints = {
                    video: {
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    }
                };
                const stream = await navigator.mediaDevices.getUserMedia(constraints);
                this.$refs.video.srcObject = stream;
            } catch (err) {
                console.error("Error accessing the camera:", err);
            }
        },
        getLocation() {
            if (navigator.geolocation) {
                const options = {
                    enableHighAccuracy: true,
                    timeout: 1000,
                    maximumAge: 0
                };
                navigator.geolocation.getCurrentPosition(this.showPosition, this.showErrorGps, options);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        },
        showPosition(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            this.latitude = latitude;
            this.longitude = longitude;
        },
        showErrorGps(error) {
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    alert("User denied the request for Geolocation.");
                    break;
                case error.POSITION_UNAVAILABLE:
                    alert("Location information is unavailable.");
                    break;
                case error.TIMEOUT:
                    alert("The request to get user location timed out.");
                    break;
                case error.UNKNOWN_ERROR:
                    alert("An unknown error occurred.");
                    break;
            }
        },
        updateClock() {
            moment.locale('id');
            const now = moment().utcOffset('+0700');
            this.currentDate = now.format('D MMMM YYYY');
            this.currentDay = now.format('dddd');
            this.currentTime = now.format('HH:mm:ss') + ' WIB';
        },
        formatTime(time) {
            return time < 10 ? `0${time}` : time;
        },
        async fetchData() {
            try {
                const response = await axios.get('/api/absensi')

                this.items = response.data.data

                this.items.forEach(item => {
                    item.position = `${item.latitude}, ${item.longitude}`;
                });
            } catch (error) {
                this.toast.error(error.response.data.message);
            }
        }
    },
    mounted() {
        this.fetchData();
        this.updateClock();
        this.getLocation();
        setInterval(() => {
            this.updateClock();
        }, 1000);

    }
}
</script>

<style>
.vgt-table tbody td:nth-of-type(7) {
    color: rgba(0, 0, 255, 0.607) !important;
    text-decoration: underline;
}

.vgt-table tbody td:nth-of-type(7):hover {
    cursor: pointer;
}
</style>
