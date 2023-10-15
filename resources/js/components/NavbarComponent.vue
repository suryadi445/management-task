<template>
    <div>
        <nav class="px-10 py-4 bg-blue-500 shadow-md shadow-blue-500/50 ">
            <div class="container mx-auto">
                <div class="flex items-center justify-between">
                    <router-link to="/" class="text-2xl font-semibold text-white">Nama Situs</router-link>
                    <ul class="hidden space-x-4 lg:flex">
                        <li><router-link to="/" class="text-white">Beranda</router-link></li>
                        <li><router-link to="task" class="text-white">Task</router-link></li>
                    </ul>
                    <div class="lg:hidden">
                        <button id="mobile-menu-button" class="p-2 text-white focus:outline-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <ul id="mobile-menu" class="flex flex-col mt-5 space-y-4 lg:hidden">
                    <li><router-link to="/" class="text-white">Beranda</router-link></li>
                    <li><router-link to="task" class="text-white">Task</router-link></li>
                </ul>
            </div>
        </nav>
    </div>
</template>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const mobileMenuButton = document.getElementById("mobile-menu-button");
    const mobileMenu = document.getElementById("mobile-menu");

    mobileMenuButton.addEventListener("click", function () {
        mobileMenu.classList.toggle("hidden");
    });
});
</script>
