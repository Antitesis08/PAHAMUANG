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
        <section class="bg-brand-focus text-white py-20">
            <div class="max-w-7xl mx-auto px-6">

                <h1 class="text-5xl font-extrabold capitalize">
                    {{ slug }}
                </h1>

                <p class="mt-5 text-slate-100 text-lg max-w-2xl">
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
                    class="card p-8 hover:shadow-lg transition flex flex-col lg:flex-row gap-8 items-center"
                >

                    <div class="w-36 h-36 rounded-2xl bg-brand-focus/10 flex items-center justify-center">
                        <svg class="w-14 h-14 text-brand-focus" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM6 18c0-2.67 5.33-4 6-4s6 1.33 6 4v2H6v-2z"/></svg>
                    </div>

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

                            <span class="inline-flex items-center gap-2 bg-success/10 text-success border border-success/20 text-sm font-bold px-3 py-2 rounded-full">
                                <span class="w-2 h-2 rounded-full bg-success"></span>
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

                                <h3 class="font-bold text-2xl mt-2 text-brand-focus">
                                    {{ item.harga }}
                                </h3>
                            </div>

                        </div>

                    </div>

                    <div class="flex flex-col gap-4 w-full lg:w-auto">

                        <Link
                            :href="route('public.konsultan.detail', item.id)"
                            class="btn-primary px-8 py-4 rounded-2xl text-center font-semibold"
                        >
                            Lihat Profil
                        </Link>

                        <Link
                            :href="route('public.booking', item.id)"
                            class="inline-flex items-center justify-center rounded-2xl border border-brand-focus text-brand-focus hover:bg-brand-focus/5 px-8 py-4 text-center font-semibold transition-colors duration-300"
                        >
                            Booking Sekarang
                        </Link>

                    </div>

                </div>

            </div>

        </div>

    </div>
</template>