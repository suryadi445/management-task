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
                    <button @click="capture" class="px-3 text-white bg-yellow-400 rounded-md ">
                        <i class="fa-solid fa-camera"></i>
                        Capture
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
            <table-component :data="items" :columns="columns">
            </table-component>
        </div>
    </div>
</template>

<script>
import moment from 'moment-timezone';
import TableComponent from "../../components/TableComponent.vue";
import { useToast } from "vue-toastification";

export default {
    components: {
        TableComponent
    },
    data() {
        return {
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
            },
            items: [],
            columns: [
                {
                    label: 'Image',
                    field: 'images',
                },
                {
                    label: "Nama Karyawan",
                    field: "nama_karyawan",
                },
                {
                    label: "Jabatan",
                    field: "jabatan",
                },
                {
                    label: "Tanggal Absensi",
                    field: "tanggal",
                },
                {
                    label: "Jam Absensi",
                    field: "jam",
                },
                {
                    label: "Position",
                    field: "position",
                },
            ],
        };
    },
    methods: {
        async capture() {
            const video = this.$refs.video;
            const canvas = this.$refs.canvas;
            const context = canvas.getContext('2d');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0, canvas.width, canvas.height);
            const image = canvas.toDataURL('image/jpeg');

            this.postImage(image);

        },
        async postImage(image) {

            this.formData.image = image;
            this.formData.latitude = this.latitude;
            this.formData.longitude = this.longitude;

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
                navigator.geolocation.getCurrentPosition(this.showPosition);
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
