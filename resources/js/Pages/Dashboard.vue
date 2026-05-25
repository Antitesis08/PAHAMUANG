<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicNavbar from '@/Components/PublicNavbar.vue';

const layanan = [
    {
        title: 'Perencanaan Pensiun',
        slug: 'pensiun',
        desc: 'Rencanakan masa pensiun Anda dengan strategi terbaik.',
        price: 'Rp500.000 - Rp1.500.000',
        icon: '💼'
    },
    {
        title: 'Manajemen Utang',
        slug: 'utang',
        desc: 'Kelola utang secara efektif dan aman.',
        price: 'Rp400.000 - Rp1.000.000',
        icon: '💳'
    },
    {
        title: 'Perencanaan Investasi',
        slug: 'investasi',
        desc: 'Optimalkan investasi untuk masa depan.',
        price: 'Rp750.000 - Rp2.000.000',
        icon: '📈'
    },
    {
        title: 'Asuransi & Proteksi',
        slug: 'asuransi',
        desc: 'Proteksi diri dan keluarga dengan tepat.',
        price: 'Rp350.000 - Rp800.000',
        icon: '🛡️'
    },
    {
        title: 'Perencanaan Pajak',
        slug: 'pajak',
        desc: 'Kelola kewajiban pajak lebih optimal.',
        price: 'Rp600.000 - Rp1.500.000',
        icon: '📄'
    },
    {
        title: 'Dana Pendidikan',
        slug: 'pendidikan',
        desc: 'Persiapkan pendidikan anak sejak dini.',
        price: 'Rp500.000 - Rp1.200.000',
        icon: '🎓'
    }
];

const konsultan = [
    {
        id: 1,
        nama: 'Dr. Budi Santoso',
        bidang: 'Investasi',
        harga: 'Rp750.000/jam'
    },
    {
        id: 2,
        nama: 'Siti Nurhaliza',
        bidang: 'Pajak',
        harga: 'Rp850.000/jam'
    },
    {
        id: 3,
        nama: 'Linda Kusuma',
        bidang: 'Asuransi',
        harga: 'Rp700.000/jam'
    }
];
</script>

<template>
    <Head title="Dashboard" />

    <div class="min-h-screen bg-gray-100">

        <PublicNavbar />

        <!-- Hero -->
        <section class="bg-indigo-700 text-white py-24">

            <div class="max-w-5xl mx-auto px-6 text-center">

                <p class="uppercase tracking-widest text-indigo-200 text-sm mb-3">
                    Selamat Datang di PAHAMUANG
                </p>

                <h1 class="text-5xl font-extrabold leading-tight">
                    Wujudkan Masa Depan Finansial
                    yang Lebih Baik
                </h1>

                <p class="mt-6 text-indigo-100 text-lg max-w-3xl mx-auto">
                    Konsultasi bersama pakar keuangan profesional untuk masa depan finansial Anda.
                </p>

                <div class="mt-10 flex justify-center gap-4">

                    <Link
                        :href="route('public.konsultan')"
                        class="bg-green-500 hover:bg-green-600 transition px-6 py-3 rounded-lg font-semibold"
                    >
                        Mulai Konsultasi
                    </Link>

                    <Link
                        :href="route('public.konsultan')"
                        class="bg-white text-gray-700 px-6 py-3 rounded-lg font-semibold"
                    >
                        Cari Konsultan
                    </Link>

                </div>

            </div>

        </section>

        <!-- layanan -->
        <section class="py-20 bg-white">

            <div class="max-w-7xl mx-auto px-6">

                <div class="text-center mb-14">

                    <h2 class="text-3xl font-bold">
                        Layanan Konsultasi Keuangan
                    </h2>

                    <p class="text-gray-500 mt-3">
                        Pilih layanan sesuai kebutuhan Anda
                    </p>

                </div>

                <div class="grid md:grid-cols-3 gap-6">

                    <Link
                        v-for="(item, index) in layanan"
                        :key="index"
                        :href="route('public.layanan', item.slug)"
                        class="bg-white border border-gray-200 rounded-2xl p-6 hover:shadow-xl transition block"
                    >

                        <div class="w-12 h-12 rounded-xl bg-indigo-100 flex items-center justify-center text-2xl">
                            {{ item.icon }}
                        </div>

                        <h3 class="font-bold text-xl mt-5">
                            {{ item.title }}
                        </h3>

                        <p class="text-gray-500 mt-3">
                            {{ item.desc }}
                        </p>

                        <p class="mt-5 font-bold text-indigo-700">
                            {{ item.price }}
                        </p>

                    </Link>

                </div>

            </div>

        </section>

        <!-- konsultan -->
        <section class="py-20 bg-gray-50">

            <div class="max-w-7xl mx-auto px-6">

                <div class="text-center mb-14">

                    <h2 class="text-3xl font-bold">
                        Konsultan Terpercaya
                    </h2>

                    <p class="text-gray-500 mt-3">
                        Dipercaya oleh ratusan klien
                    </p>

                </div>

                <div class="grid md:grid-cols-3 gap-8">

                    <Link
                        v-for="item in konsultan"
                        :key="item.id"
                        :href="route('public.konsultan.detail', item.id)"
                        class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl transition"
                    >

                        <div class="bg-indigo-100 h-40"></div>

                        <div class="p-6">

                            <div class="flex justify-between">

                                <span class="bg-green-500 text-white text-xs px-3 py-1 rounded-full">
                                    Tersedia
                                </span>

                                <span class="text-yellow-500">
                                    ★ 4.9
                                </span>

                            </div>

                            <h3 class="text-xl font-bold mt-5">
                                {{ item.nama }}
                            </h3>

                            <p class="text-gray-500 mt-2">
                                {{ item.bidang }}
                            </p>

                            <div class="mt-6 flex justify-between items-center">

                                <p class="font-bold text-indigo-700">
                                    {{ item.harga }}
                                </p>

                                <div class="bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm">
                                    Lihat Profil
                                </div>

                            </div>

                        </div>

                    </Link>

                </div>

            </div>

        </section>

 <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-6 text-center text-gray-500 text-sm">
            © 2026 PAHAMUANG Team. All rights reserved.
        </footer>
        
    </div>
</template>