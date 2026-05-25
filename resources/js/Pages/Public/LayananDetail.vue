<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicNavbar from '@/Components/PublicNavbar.vue';

defineProps({
    slug: String
});

const konsultan = [
    {
        id: 1,
        nama: 'Dr. Budi Santoso',
        bidang: 'Investasi',
        harga: 'Rp750.000/jam',
        pengalaman: '10 Tahun'
    },
    {
        id: 2,
        nama: 'Siti Nurhaliza',
        bidang: 'Pajak',
        harga: 'Rp850.000/jam',
        pengalaman: '8 Tahun'
    }
];
</script>

<template>
    <Head title="Layanan" />

    <div class="min-h-screen bg-gray-100">

        <PublicNavbar />

        <!-- HERO -->
        <section class="bg-indigo-700 text-white py-20">
            <div class="max-w-7xl mx-auto px-6">

                <h1 class="text-5xl font-extrabold capitalize">
                    {{ slug }}
                </h1>

                <p class="mt-5 text-indigo-100 text-lg max-w-2xl">
                    Temukan konsultan profesional terbaik sesuai layanan yang Anda butuhkan.
                </p>

            </div>
        </section>

        <!-- CONTENT -->
        <div class="max-w-7xl mx-auto px-6 py-14">

            <div class="grid gap-8">

                <div
                    v-for="item in konsultan"
                    :key="item.id"
                    class="bg-white rounded-3xl p-8 shadow-sm hover:shadow-xl transition flex flex-col lg:flex-row gap-8 items-center"
                >

                    <div class="w-36 h-36 rounded-2xl bg-indigo-100"></div>

                    <div class="flex-1">

                        <div class="flex justify-between items-start">

                            <div>
                                <h2 class="text-3xl font-bold text-gray-900">
                                    {{ item.nama }}
                                </h2>

                                <p class="text-gray-500 mt-2 text-lg">
                                    Spesialis {{ item.bidang }}
                                </p>
                            </div>

                            <span class="bg-green-500 text-white px-4 py-2 rounded-full text-sm">
                                Tersedia
                            </span>

                        </div>

                        <div class="grid md:grid-cols-3 gap-5 mt-8">

                            <div class="bg-gray-100 rounded-2xl p-5">
                                <p class="text-gray-500 text-sm">
                                    Pengalaman
                                </p>

                                <h3 class="font-bold text-2xl mt-2">
                                    {{ item.pengalaman }}
                                </h3>
                            </div>

                            <div class="bg-gray-100 rounded-2xl p-5">
                                <p class="text-gray-500 text-sm">
                                    Rating
                                </p>

                                <h3 class="font-bold text-2xl mt-2 text-yellow-500">
                                    4.9 ★
                                </h3>
                            </div>

                            <div class="bg-gray-100 rounded-2xl p-5">
                                <p class="text-gray-500 text-sm">
                                    Tarif
                                </p>

                                <h3 class="font-bold text-2xl mt-2 text-indigo-700">
                                    {{ item.harga }}
                                </h3>
                            </div>

                        </div>

                    </div>

                    <div class="flex flex-col gap-4 w-full lg:w-auto">

                        <Link
                            :href="route('public.konsultan.detail', item.id)"
                            class="bg-indigo-700 hover:bg-indigo-800 transition text-white px-8 py-4 rounded-2xl text-center font-semibold"
                        >
                            Lihat Profil
                        </Link>

                        <Link
                            :href="route('public.booking', item.id)"
                            class="border border-indigo-700 text-indigo-700 hover:bg-indigo-50 transition px-8 py-4 rounded-2xl text-center font-semibold"
                        >
                            Booking Sekarang
                        </Link>

                    </div>

                </div>

            </div>

        </div>

    </div>
</template>