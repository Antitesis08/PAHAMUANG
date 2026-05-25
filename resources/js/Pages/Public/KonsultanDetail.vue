<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicNavbar from '@/Components/PublicNavbar.vue';

defineProps({
    id: String
});
</script>

<template>
    <Head title="Detail Konsultan" />

    <div class="min-h-screen bg-gray-100">

        <PublicNavbar />

        <!-- HERO -->
        <section class="bg-gradient-to-r from-indigo-700 to-indigo-900 h-72"></section>

        <div class="max-w-7xl mx-auto px-6 -mt-28 pb-20">

            <div class="grid lg:grid-cols-3 gap-8">

                <!-- LEFT -->
                <div class="lg:col-span-2">

                    <div class="bg-white rounded-3xl shadow-sm p-10">

                        <div class="flex flex-col lg:flex-row gap-8">

                            <div class="w-44 h-44 rounded-3xl bg-gray-300 border-4 border-white"></div>

                            <div class="flex-1">

                                <div class="flex justify-between items-start">

                                    <div>

                                        <h1 class="text-5xl font-extrabold text-gray-900">
                                            Dr. Budi Santoso
                                        </h1>

                                        <p class="text-gray-500 mt-3 text-lg">
                                            Konsultan Investasi & Financial Planner
                                        </p>

                                    </div>

                                    <span class="bg-green-500 text-white px-5 py-2 rounded-full">
                                        Tersedia
                                    </span>

                                </div>

                                <div class="grid md:grid-cols-3 gap-5 mt-10">

                                    <div class="bg-gray-100 rounded-2xl p-6">
                                        <p class="text-gray-500 text-sm">
                                            Pengalaman
                                        </p>

                                        <h3 class="font-bold text-3xl mt-3">
                                            10 Tahun
                                        </h3>
                                    </div>

                                    <div class="bg-gray-100 rounded-2xl p-6">
                                        <p class="text-gray-500 text-sm">
                                            Rating
                                        </p>

                                        <h3 class="font-bold text-3xl mt-3 text-yellow-500">
                                            4.9 ★
                                        </h3>
                                    </div>

                                    <div class="bg-gray-100 rounded-2xl p-6">
                                        <p class="text-gray-500 text-sm">
                                            Konsultasi
                                        </p>

                                        <h3 class="font-bold text-3xl mt-3 text-indigo-700">
                                            1.2K+
                                        </h3>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- tentang -->
                    <div class="bg-white rounded-3xl shadow-sm p-10 mt-8">

                        <h2 class="text-3xl font-bold">
                            Tentang Konsultan
                        </h2>

                        <p class="text-gray-600 leading-relaxed mt-6 text-lg">
                            Berpengalaman lebih dari 10 tahun dalam bidang investasi,
                            pengelolaan aset, dan financial planning untuk individu maupun perusahaan.
                        </p>

                    </div>

                    <!-- review -->
                    <div class="bg-white rounded-3xl shadow-sm p-10 mt-8">

                        <h2 class="text-3xl font-bold">
                            Review Klien
                        </h2>

                        <div class="mt-8 space-y-6">

                            <div class="border border-gray-200 rounded-2xl p-6">

                                <div class="flex justify-between">

                                    <div>
                                        <h3 class="font-bold">
                                            Andi Saputra
                                        </h3>

                                        <p class="text-gray-500 text-sm">
                                            Pengusaha
                                        </p>
                                    </div>

                                    <span class="text-yellow-500">
                                        ★★★★★
                                    </span>

                                </div>

                                <p class="text-gray-600 mt-5 leading-relaxed">
                                    Konsultasi sangat membantu untuk perencanaan investasi jangka panjang saya.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- RIGHT -->
                <div>

                    <div class="bg-white rounded-3xl shadow-sm p-8 sticky top-24">

                        <h2 class="text-3xl font-bold">
                            Booking Konsultasi
                        </h2>

                        <div class="space-y-6 mt-8">

                            <div class="flex justify-between">
                                <span class="text-gray-500">
                                    Tarif
                                </span>

                                <span class="font-bold">
                                    Rp750.000
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">
                                    Durasi
                                </span>

                                <span class="font-bold">
                                    60 Menit
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">
                                    Platform
                                </span>

                                <span class="font-bold">
                                    Zoom Meeting
                                </span>
                            </div>

                        </div>

                        <Link
                            :href="route('public.booking', id)"
                            class="block mt-10 bg-green-500 hover:bg-green-600 transition text-white text-center py-5 rounded-2xl font-semibold text-lg"
                        >
                            Pilih Jadwal
                        </Link>

                    </div>

                </div>

            </div>

        </div>

    </div>
</template>