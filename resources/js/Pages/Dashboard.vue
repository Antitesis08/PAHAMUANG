<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    auth: Object
});
</script>

<template>
    <Head title="Selamat Datang" />

    <div class="min-h-screen bg-gray-50">
        <nav class="bg-white border-b border-gray-200 p-4 sticky top-0 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <div class="font-bold text-2xl text-indigo-600 tracking-tight">PAHAMUANG</div>
                
                <div class="flex items-center space-x-4">
                    <Link 
                        :href="route('login')"
                        class="text-sm text-gray-700 hover:text-indigo-600 font-semibold border border-gray-300 px-5 py-2.5 rounded-lg transition-all duration-200 hover:bg-indigo-50 shadow-sm inline-block"
                    >
                        Login Staff (Admin/Konsultan)
                    </Link>
                </div>
            </div>
        </nav>

        <main class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-md sm:rounded-2xl p-10 border border-gray-100">
                    <div class="text-center mb-12">
                        <h1 class="text-4xl font-extrabold text-gray-900 leading-tight">
                            Selamat Datang di <span class="text-indigo-600">PAHAMUANG</span>
                        </h1>
                        <p class="mt-4 text-xl text-gray-600 max-w-2xl mx-auto">
                            Solusi konsultasi keuangan terpercaya dan profesional untuk masa depan Anda yang lebih baik.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <div v-for="i in 3" :key="i" class="group p-8 bg-white rounded-2xl border border-gray-200 hover:border-indigo-300 hover:shadow-xl transition-all duration-300">
                            <div class="h-14 w-14 bg-indigo-600 text-white rounded-2xl mb-6 flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="font-bold text-xl text-gray-800">Layanan Unggulan {{ i }}</h3>
                            <p class="text-gray-500 mt-3 leading-relaxed">
                                Dapatkan bimbingan finansial terbaik dari para ahli konsultan kami yang sudah berpengalaman luas.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="text-center py-8 text-gray-400 text-sm">
            &copy; 2026 PAHAMUANG Team. All rights reserved.
        </footer>
    </div>
</template>