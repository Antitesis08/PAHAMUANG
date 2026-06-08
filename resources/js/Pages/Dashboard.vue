<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import PublicNavbar from '@/Components/PublicNavbar.vue';

// Accept layanans passed from web.php
const props = defineProps({
    layanans: {
        type: Array,
        default: () => []
    }
});

// Mockup data for top consultants as requested
const topKonsultan = [
    {
        id: 2,
        nama: 'Dr. Budi Santoso, CFP',
        bidang: 'Investasi & Pensiun',
        harga: 'Rp 750.000/jam',
        rating: '4.9',
        reviews: 120,
        avatar: 'https://ui-avatars.com/api/?name=Budi+Santoso&background=E0E7FF&color=4F46E5'
    }
];

// Helper to determine icon based on category or name
const getIcon = (nama_layanan) => {
    if (nama_layanan.includes('Pensiun')) return '💼';
    if (nama_layanan.includes('Utang')) return '💳';
    if (nama_layanan.includes('Investasi')) return '📈';
    return '✨';
};

// Function to format currency (assuming the db has plain numbers)
const formatPrice = (price) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(price);
};

// Handle service selection (state capture / navigation)
const selectService = (id) => {
    // In a real application, you might use Pinia here to set state. 
    // For now, we'll navigate to the konsultan list and pass the layanan_id as a query param.
    router.get(route('public.konsultan'), { layanan_id: id });
};
</script>

<template>
    <Head title="Dashboard" />

    <div class="min-h-screen bg-gray-50 font-sans text-gray-800">
        <!-- Navbar -->
        <PublicNavbar />

        <!-- Success Alert if any -->
        <div v-if="$page.props.flash && $page.props.flash.success" class="max-w-7xl mx-auto px-6 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
                <span class="block sm:inline">{{ $page.props.flash.success }}</span>
            </div>
        </div>

        <!-- Hero Section -->
        <section class="bg-[#0B56D5] text-white pt-32 pb-24 relative overflow-hidden">
            <!-- Decorative Background Element -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-blue-400 opacity-20 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-green-300 opacity-20 rounded-full blur-3xl transform -translate-x-1/2 translate-y-1/3"></div>

            <div class="max-w-6xl mx-auto px-6 text-center relative z-10">
                <span class="inline-block px-4 py-1 bg-blue-600 bg-opacity-50 border border-blue-400 rounded-full text-blue-100 text-sm font-semibold tracking-wide mb-6">
                    Mulai Perjalanan Finansial Anda
                </span>
                
                <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-6 tracking-tight">
                    Wujudkan Masa Depan <br class="hidden md:block" /> Finansial yang Lebih Baik
                </h1>

                <p class="text-blue-100 text-lg md:text-xl max-w-2xl mx-auto mb-10 leading-relaxed">
                    Konsultasi dengan pakar keuangan bersertifikat untuk merencanakan investasi, pensiun, dan mencapai tujuan finansial Anda.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <Link
                        :href="route('public.konsultan')"
                        class="bg-[#00B16A] hover:bg-[#009E5F] text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1"
                    >
                        Mulai Konsultasi
                    </Link>
                    <Link
                        :href="route('public.konsultan')"
                        class="bg-transparent hover:bg-white hover:text-[#0B56D5] text-white border-2 border-white px-8 py-4 rounded-xl font-bold text-lg transition-all"
                    >
                        Cari Konsultan
                    </Link>
                </div>
            </div>
        </section>

        <!-- Layanan Konsultasi Keuangan Section -->
        <section class="py-24 bg-white">
            <div class="max-w-7xl mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                        Layanan Konsultasi Keuangan
                    </h2>
                    <p class="text-gray-500 text-lg max-w-2xl mx-auto">
                        Pilih layanan yang sesuai dengan kebutuhan dan tujuan finansial Anda. Klik salah satu layanan di bawah ini untuk memulai.
                    </p>
                </div>

                <div v-if="layanans && layanans.length" class="grid md:grid-cols-3 gap-8">
                    <div
                        v-for="item in layanans"
                        :key="item.id"
                        @click="selectService(item.id)"
                        class="group bg-white border border-gray-100 rounded-3xl p-8 shadow-sm hover:shadow-2xl hover:border-blue-100 cursor-pointer transition-all duration-300 transform hover:-translate-y-2 flex flex-col h-full relative overflow-hidden"
                    >
                        <!-- Highlight indicator on hover -->
                        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#0B56D5] to-[#00B16A] opacity-0 group-hover:opacity-100 transition-opacity"></div>

                        <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center text-3xl mb-6 group-hover:scale-110 transition-transform">
                            {{ getIcon(item.nama_layanan) }}
                        </div>

                        <h3 class="font-bold text-2xl text-gray-900 mb-3 group-hover:text-[#0B56D5] transition-colors">
                            {{ item.nama_layanan }}
                        </h3>

                        <p class="text-gray-500 mb-8 flex-grow">
                            {{ item.deskripsi }}
                        </p>

                        <div class="pt-6 border-t border-gray-100">
                            <p class="text-sm text-gray-400 mb-1">Mulai dari</p>
                            <div class="flex items-end justify-between">
                                <span class="font-bold text-xl text-[#0B56D5]">
                                    {{ formatPrice(item.harga) }}
                                </span>
                                <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center text-gray-400 group-hover:bg-[#00B16A] group-hover:text-white transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fallback if database is empty/unseeded -->
                <div v-else class="text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                    <p class="text-gray-500">Data layanan belum tersedia. Silakan jalankan seeder database.</p>
                </div>
            </div>
        </section>

        <!-- Konsultan Terpercaya Section -->
        <section class="py-24 bg-blue-50">
            <div class="max-w-7xl mx-auto px-6">
                <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-6">
                    <div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">
                            Konsultan Terpercaya
                        </h2>
                        <p class="text-gray-600 text-lg">
                            Dapatkan panduan dari para ahli yang telah bersertifikat dan berpengalaman.
                        </p>
                    </div>
                    <Link
                        :href="route('public.konsultan')"
                        class="text-[#0B56D5] font-semibold hover:text-blue-700 flex items-center gap-2 group"
                    >
                        Lihat Semua Konsultan
                        <span class="transform group-hover:translate-x-1 transition-transform">→</span>
                    </Link>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <Link
                        v-for="konsultan in topKonsultan"
                        :key="konsultan.id"
                        :href="route('public.konsultan.detail', konsultan.id)"
                        class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 group"
                    >
                        <div class="p-8">
                            <div class="flex items-start justify-between mb-6">
                                <img 
                                    :src="konsultan.avatar" 
                                    :alt="konsultan.nama" 
                                    class="w-20 h-20 rounded-2xl object-cover ring-4 ring-blue-50 group-hover:ring-blue-100 transition-all"
                                />
                                <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 text-xs font-bold px-3 py-1 rounded-full border border-green-200">
                                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                    Tersedia
                                </span>
                            </div>

                            <h3 class="text-xl font-bold text-gray-900 mb-1 group-hover:text-[#0B56D5] transition-colors">
                                {{ konsultan.nama }}
                            </h3>
                            <p class="text-sm font-medium text-blue-600 mb-4">
                                {{ konsultan.bidang }}
                            </p>

                            <div class="flex items-center gap-2 mb-6">
                                <div class="flex text-yellow-400 text-sm">
                                    ★ ★ ★ ★ ★
                                </div>
                                <span class="font-bold text-gray-700">{{ konsultan.rating }}</span>
                                <span class="text-gray-400 text-sm">({{ konsultan.reviews }} ulasan)</span>
                            </div>

                            <div class="pt-6 border-t border-gray-100 flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-400 mb-1">Tarif per jam</p>
                                    <p class="font-bold text-gray-900">
                                        {{ konsultan.harga }}
                                    </p>
                                </div>
                                <div class="bg-gray-50 text-gray-600 px-4 py-2 rounded-xl text-sm font-semibold group-hover:bg-[#0B56D5] group-hover:text-white transition-colors">
                                    Profil
                                </div>
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Bottom CTA Banner -->
        <section class="py-24 bg-white relative overflow-hidden">
            <div class="max-w-5xl mx-auto px-6 relative z-10">
                <div class="bg-gradient-to-br from-[#0B56D5] to-blue-800 rounded-3xl p-10 md:p-16 text-center text-white shadow-2xl">
                    <h2 class="text-3xl md:text-4xl font-bold mb-6">
                        Siap Merencanakan Keuangan Anda?
                    </h2>
                    <p class="text-blue-100 text-lg md:text-xl mb-10 max-w-2xl mx-auto">
                        Jadwalkan konsultasi dengan pakar keuangan profesional kami hari ini dan mulailah membangun masa depan yang lebih cerah.
                    </p>
                    <Link
                        :href="route('public.konsultan')"
                        class="inline-block bg-[#00B16A] hover:bg-[#009E5F] text-white px-8 py-4 rounded-xl font-bold text-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1"
                    >
                        Booking Konsultasi Sekarang
                    </Link>
                </div>
            </div>
            <!-- Background Elements -->
            <div class="absolute top-1/2 left-0 w-64 h-64 bg-blue-50 rounded-full blur-3xl transform -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-80 h-80 bg-green-50 rounded-full blur-3xl transform translate-x-1/3 translate-y-1/3"></div>
        </section>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-100 py-8">
            <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4 text-gray-500 text-sm">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 bg-[#0B56D5] rounded text-white flex items-center justify-center font-bold text-xs">P</div>
                    <span class="font-bold text-gray-900">PAHAMUANG</span>
                </div>
                <p>© 2026 PAHAMUANG Team. All rights reserved.</p>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-blue-600 transition-colors">Syarat & Ketentuan</a>
                    <a href="#" class="hover:text-blue-600 transition-colors">Privasi</a>
                </div>
            </div>
        </footer>
    </div>
</template>