<template>
    <div class="grid grid-cols-3 gap-4 mb-5">
        <button type="button" @click="openCamera" class="px-3 py-1 mx-3 text-white bg-blue-600 rounded-md basis-1/3">
            <i class="fa-solid fa-unlock"></i>
            Open Camera
        </button>
        <button @click="capture" class="px-3 py-1 mx-3 text-white bg-yellow-400 rounded-md basis-1/3">
            <i class="fa-solid fa-camera"></i>
            Capture
        </button>
        <button @click="stopMedia" class="px-3 py-1 mx-3 text-white bg-red-400 rounded-md basis-1/3">
            <i class="fa-solid fa-circle-stop"></i>
            Stop Camera
        </button>
    </div>
    <div class="grid grid-cols-3 gap-4 max-h-96">
        <div class="col-span-2">
            <video ref="video" class="w-full max-h-96 " autoplay></video>
            <canvas ref="canvas" class="w-full max-h-96 "></canvas>
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
        </div>
    </div>

    <div class="grid grid-cols-1 my-4">
        <div class="text-2xl text-center">
            <p>List Absensi</p>
        </div>
    </div>

    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
        <table-component :data="items" :columns="columns" :edit="edit" :remove="remove">
        </table-component>
    </div>
</template>

<script>
import moment from 'moment-timezone';
import TableComponent from "../../components/TableComponent.vue";


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
            items: [],
            columns: [
                {
                    label: "Nama Karyawan",
                    field: "nama",
                },
                {
                    label: "Tanggal Absensi",
                    field: "tgl_absensi",
                },
                {
                    label: "Jam Absensi",
                    field: "jam_absensi",
                },
                {
                    label: "Keterangan",
                    field: "keterangan",
                },
                {
                    label: "Actions",
                    field: "actions",
                },
            ],
        };
    },
    methods: {
        async capture() {
            const video = this.$refs.video;
            const canvas = this.$refs.canvas;
            const context = canvas.getContext('2d');
            context.drawImage(video, 0, 0, 640, 480);
            const image = canvas.toDataURL('image/jpeg');

            console.log(image);
        },
        postImage() {
            //
        },
        stopMedia() {
            if (this.mediaStream) {
                const tracks = this.mediaStream.getTracks();
                tracks.forEach(track => track.stop());
            }
        },
        openCamera() {
            navigator.mediaDevices.getUserMedia({ video: true })
                .then((stream) => {
                    this.mediaStream = stream;
                    this.$refs.video.srcObject = stream;
                })
                .catch((err) => {
                    console.error("Error accessing the camera: ", err);
                });
        },
        edit() {

        },
        remove() {

        },
        updateClock() {
            moment.locale('id'); // Atur bahasa lokal menjadi bahasa Indonesia
            const now = moment().utcOffset('+0700'); // Sesuaikan dengan Waktu Indonesia Barat (WIB)
            this.currentDate = now.format('D MMMM YYYY');
            this.currentDay = now.format('dddd');
            this.currentTime = now.format('HH:mm:ss') + ' WIB';
        },
        formatTime(time) {
            return time < 10 ? `0${time}` : time;
        },
    },
    mounted() {
        this.updateClock();
        setInterval(() => {
            this.updateClock();
        }, 1000);
    }
}
</script>
