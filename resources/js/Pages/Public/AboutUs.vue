<script setup>
import { Head, Link } from '@inertiajs/vue3';
import PublicNavbar from '@/Components/PublicNavbar.vue';

// Developers data
const developers = [
    { name: 'Razzan Haydar', role: '2350081111' },
    { name: 'Sulthan Dhiyaul', role: '2360082001' },
    { name: 'Kiyana Shakyla', role: '2350081150' },
    { name: 'Zahra Khalis', role: '2350081128' },
    { name: 'Antonia Rachelia', role: '2350081128' }
];

// Helper to get initials
const getInitials = (name) => {
    return name.split(' ').map(n => n.charAt(0)).join('');
};

// Avatar colors corresponding to each person
const colors = [
    'from-blue-500 to-indigo-600',
    'from-emerald-400 to-teal-600',
    'from-pink-500 to-rose-600',
    'from-violet-500 to-purple-600',
    'from-amber-400 to-orange-600'
];
</script>

<template>
    <Head title="Tentang Kami" />

    <div class="min-h-screen bg-gray-50 font-sans text-gray-800">
        <!-- Navbar -->
        <PublicNavbar />

        <!-- Hero Section -->
        <section class="bg-gradient-to-br from-[#0B56D5] to-blue-800 text-white pt-24 pb-20 relative overflow-hidden">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 w-96 h-96 bg-blue-400 opacity-20 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-green-300 opacity-10 rounded-full blur-3xl transform -translate-x-1/2 translate-y-1/3"></div>

            <div class="max-w-6xl mx-auto px-6 text-center relative z-10">
                <span class="inline-block px-4 py-1 bg-white bg-opacity-10 border border-white border-opacity-20 rounded-full text-blue-100 text-xs font-semibold tracking-wide uppercase mb-6">
                    Mengenal Lebih Dekat
                </span>
                
                <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6 tracking-tight">
                    Tentang PAHAMUANG
                </h1>

                <p class="text-blue-100 text-base md:text-lg max-w-3xl mx-auto mb-10 leading-relaxed">
                    PAHAMUANG adalah platform digital inovatif yang dirancang khusus untuk memfasilitasi penjadwalan dan booking konsultasi keuangan profesional secara online. Kami percaya perencanaan finansial yang tepat adalah kunci kesejahteraan masa depan Anda.
                </p>
            </div>
        </section>

        <!-- Visi Misi Section -->
        <section class="py-20 bg-white">
            <div class="max-w-5xl mx-auto px-6">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div>
                        <span class="text-xs font-bold text-[#0B56D5] tracking-wider uppercase">Tujuan Kami</span>
                        <h2 class="text-3xl font-extrabold text-gray-900 mt-2 mb-6">Misi Utama Projek</h2>
                        <p class="text-gray-600 leading-relaxed mb-4 text-sm md:text-base">
                            PAHAMUANG lahir sebagai respon terhadap minimnya akses konsultasi keuangan yang terintegrasi, transparan, dan mudah digunakan di kalangan masyarakat. Projek ini dikembangkan untuk memfasilitasi kebutuhan tugas kuliah dengan pendekatan profesional berskala nyata.
                        </p>
                        <p class="text-gray-600 leading-relaxed text-sm md:text-base">
                            Melalui platform ini, kami menghubungkan pelanggan dengan konsultan keuangan yang berdedikasi tinggi, bersertifikat, dan siap mendampingi perjalanan perencanaan keuangan Anda secara objektif.
                        </p>
                    </div>

                    <div class="space-y-6">
                        <!-- Card Visi -->
                        <div class="p-6 bg-blue-50/50 border border-blue-100 rounded-3xl relative overflow-hidden group hover:shadow-md transition">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center text-xl font-bold">👁️</div>
                                <div>
                                    <h3 class="font-bold text-gray-900 text-lg">Visi Kami</h3>
                                    <p class="text-sm text-gray-600 mt-2 leading-relaxed">
                                        Menjadi platform booking rujukan utama untuk layanan konsultasi keuangan yang andal, inklusif, dan mengutamakan kenyamanan pengguna.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Card Misi -->
                        <div class="p-6 bg-green-50/50 border border-green-100 rounded-3xl relative overflow-hidden group hover:shadow-md transition">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-[#00B16A] text-white flex items-center justify-center text-xl font-bold">🚀</div>
                                <div>
                                    <h3 class="font-bold text-gray-900 text-lg">Misi Kami</h3>
                                    <p class="text-sm text-gray-600 mt-2 leading-relaxed">
                                        Menyediakan antarmuka intuitif, sistem transaksi aman terverifikasi, dan pilihan penjadwalan konsultan keuangan yang dinamis dan fleksibel.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tim Pengembang Section -->
        <section class="py-24 bg-gray-50 border-t border-b border-gray-100">
            <div class="max-w-6xl mx-auto px-6">
                <div class="text-center mb-16">
                    <span class="text-xs font-bold text-[#0B56D5] tracking-wider uppercase">Behind The Platform</span>
                    <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mt-2 mb-4">
                        Tim Pengembang Projek
                    </h2>
                    <p class="text-gray-500 text-base max-w-xl mx-auto">
                        Bertemu dengan tim mahasiswa berdedikasi di balik pembangunan platform PAHAMUANG.
                    </p>
                </div>

                <!-- Developer Grid -->
                <div class="flex flex-wrap justify-center gap-8">
                    <div 
                        v-for="(dev, index) in developers" 
                        :key="index"
                        class="bg-white border border-gray-100 rounded-3xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 w-full sm:w-[280px] text-center flex flex-col items-center group transform hover:-translate-y-1"
                    >
                        <!-- Initial Avatar Placeholder -->
                        <div 
                            :class="[colors[index % colors.length]]" 
                            class="w-24 h-24 rounded-3xl bg-gradient-to-br flex items-center justify-center text-white text-3xl font-extrabold shadow-md mb-6 transform group-hover:scale-105 transition-transform"
                        >
                            {{ getInitials(dev.name) }}
                        </div>

                        <h3 class="font-bold text-xl text-gray-900 mb-1 group-hover:text-[#0B56D5] transition-colors">
                            {{ dev.name }}
                        </h3>

                        <p class="text-sm font-semibold text-gray-400 uppercase tracking-wider">
                            {{ dev.role }}
                        </p>
                        
                        <p class="text-xs text-gray-400 mt-3 font-medium bg-gray-50 px-3 py-1 rounded-full">
                            Developer Member
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-20 bg-white">
            <div class="max-w-4xl mx-auto px-6 text-center">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Mulai Konsultasi Finansial Sekarang</h2>
                <p class="text-gray-600 mb-8 max-w-lg mx-auto">Tentukan masa depan finansial yang aman dan bebas dari kecemasan bersama pakar keuangan kami.</p>
                <Link 
                    :href="route('public.konsultan')" 
                    class="bg-[#00B16A] hover:bg-[#009E5F] text-white font-bold px-8 py-4 rounded-xl text-lg transition inline-block shadow-md hover:shadow-lg"
                >
                    Lihat Daftar Konsultan
                </Link>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-100 py-8">
            <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4 text-gray-500 text-sm">
                <div class="flex items-center gap-2">
                    <div class="w-6 h-6 bg-[#0B56D5] rounded text-white flex items-center justify-center font-bold text-xs">P</div>
                    <span class="font-bold text-gray-900">PAHAMUANG</span>
                </div>
                <p>© 2026 PAHAMUANG Team. All rights reserved.</p>
            </div>
        </footer>
    </div>
</template>
