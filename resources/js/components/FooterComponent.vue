<!-- Footer.vue -->
<template>
    <footer class="py-4 mt-10 text-gray-500 bg-gray-100 footer">
        <div class="container mx-auto text-center">
            <div class="flex items-center justify-center space-x-4">
                <a href="#" class="hover:text-blue-600 hover:font-semibold">Beranda</a>
                <a href="#" class="hover:text-blue-600 hover:font-semibold">Tentang Kami</a>
                <a href="#" class="hover:text-blue-600 hover:font-semibold">Layanan</a>
                <a href="#" class="hover:text-blue-600 hover:font-semibold">Kontak</a>
            </div>
            <div class="mt-4">
                &copy; {{ new Date().getFullYear() }} Nama Situs. All rights reserved.
            </div>
        </div>
    </footer>
</template>

<script>
export default {
    // Komponen footer
}
</script>

<style>
.footer {
    position: relative;
    bottom: 0;
    left: 0;
    width: 100%;
}
</style>
