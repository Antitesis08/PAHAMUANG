<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicNavbar from '@/Components/PublicNavbar.vue';

const konsultan = [
    {
        id: 1,
        nama: 'Dr. Budi Santoso',
        bidang: 'Investasi',
        harga: 'Rp750.000',
        pengalaman: '10 Tahun'
    },
    {
        id: 2,
        nama: 'Siti Nurhaliza',
        bidang: 'Pajak',
        harga: 'Rp850.000',
        pengalaman: '8 Tahun'
    },
    {
        id: 3,
        nama: 'Linda Kusuma',
        bidang: 'Asuransi',
        harga: 'Rp700.000',
        pengalaman: '6 Tahun'
    }
];
</script>

<template>
    <Head title="Konsultan" />

    <div class="min-h-screen bg-gray-100">

        <PublicNavbar />

        <div class="max-w-7xl mx-auto px-6 py-12">

            <div class="mb-10">

                <h1 class="text-4xl font-bold text-gray-900">
                    Konsultan Keuangan
                </h1>

                <p class="text-gray-500 mt-3">
                    Temukan konsultan profesional terbaik sesuai kebutuhan finansial Anda
                </p>

            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm mb-10">

                <div class="grid md:grid-cols-3 gap-4">

                    <input
                        type="text"
                        placeholder="Cari konsultan..."
                        class="border border-gray-300 rounded-xl p-4"
                    />

                    <select class="border border-gray-300 rounded-xl p-4">
                        <option>Semua Spesialisasi</option>
                        <option>Investasi</option>
                        <option>Pajak</option>
                        <option>Asuransi</option>
                    </select>

                    <button class="bg-indigo-700 text-white rounded-xl px-6">
                        Cari
                    </button>

                </div>

            </div>

            <div class="space-y-6">

                <div
                    v-for="item in konsultan"
                    :key="item.id"
                    class="bg-white rounded-2xl shadow-sm p-6 flex flex-col md:flex-row gap-6 items-center"
                >

                    <div class="w-28 h-28 rounded-full bg-gray-300"></div>

                    <div class="flex-1">

                        <div class="flex justify-between items-start">

                            <div>

                                <h2 class="text-2xl font-bold text-gray-900">
                                    {{ item.nama }}
                                </h2>

                                <p class="text-gray-500 mt-1">
                                    Spesialis {{ item.bidang }}
                                </p>

                            </div>

                            <span class="bg-green-500 text-white px-4 py-2 rounded-full text-sm">
                                Tersedia
                            </span>

                        </div>

                        <div class="grid md:grid-cols-3 gap-4 mt-6">

                            <div class="bg-gray-100 rounded-xl p-4">
                                <p class="text-sm text-gray-500">
                                    Pengalaman
                                </p>

                                <h3 class="font-bold text-xl mt-2">
                                    {{ item.pengalaman }}
                                </h3>
                            </div>

                            <div class="bg-gray-100 rounded-xl p-4">
                                <p class="text-sm text-gray-500">
                                    Rating
                                </p>

                                <h3 class="font-bold text-xl mt-2 text-yellow-500">
                                    4.9 ★
                                </h3>
                            </div>

                            <div class="bg-gray-100 rounded-xl p-4">
                                <p class="text-sm text-gray-500">
                                    Tarif
                                </p>

                                <h3 class="font-bold text-xl mt-2 text-indigo-700">
                                    {{ item.harga }}
                                </h3>
                            </div>

                        </div>

                    </div>

                    <div class="flex flex-col gap-3">

                        <Link
                            :href="route('public.konsultan.detail', item.id)"
                            class="bg-indigo-700 hover:bg-indigo-800 transition text-white px-6 py-3 rounded-xl text-center font-semibold"
                        >
                            Lihat Profil
                        </Link>

                        <Link
                            :href="route('public.booking', item.id)"
                            class="border border-indigo-700 text-indigo-700 px-6 py-3 rounded-xl text-center font-semibold hover:bg-indigo-50 transition"
                        >
                            Booking
                        </Link>

                    </div>

                </div>

            </div>

        </div>

    </div>
</template>