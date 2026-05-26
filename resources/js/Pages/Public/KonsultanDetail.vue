<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import PublicNavbar from '@/Components/PublicNavbar.vue';

const props = defineProps({
    konsultan: {
        type: Object,
        required: true
    }
});

const getExtendedData = (user) => {
    const isAvailable = user.is_available !== undefined ? user.is_available : (user.id % 2 !== 0);
    const harga = user.id % 3 === 0 ? 850000 : (user.id % 2 === 0 ? 600000 : 750000);
    const rating = user.id % 3 === 0 ? 4.9 : (user.id % 2 === 0 ? 4.6 : 4.8);
    const reviews = 50 + (user.id * 15);
    const university = "MBA - Universitas Indonesia";
    const specialties = user.id % 2 === 0 
        ? ["Manajemen Utang", "Asuransi"] 
        : ["Perencanaan Pensiun", "Investasi"];
    const roleTitle = "Certified Financial Planner";
    const displayName = user.nama.includes(',') ? user.nama : `${user.nama}, CFP`;

    const avatarColors = ['E0E7FF,4F46E5', 'FCE7F3,DB2777', 'D1FAE5,059669'];
    const colorPair = avatarColors[user.id % avatarColors.length].split(',');
    const avatar = `https://ui-avatars.com/api/?name=${encodeURIComponent(user.nama)}&background=${colorPair[0]}&color=${colorPair[1]}`;

    return {
        ...user,
        displayName,
        roleTitle,
        isAvailable,
        harga,
        rating,
        reviews,
        university,
        specialties,
        avatar
    };
};

const profile = ref(getExtendedData(props.konsultan));
const activeLayananId = ref(null);

onMounted(() => {
    // Check if there is a layanan_id in the URL
    if (typeof window !== 'undefined') {
        const params = new URLSearchParams(window.location.search);
        activeLayananId.value = params.get('layanan_id');
    }
});

const formatPrice = (price) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(price);
};

const proceedToBooking = () => {
    const query = activeLayananId.value ? { layanan_id: activeLayananId.value } : {};
    router.get(route('public.booking', profile.value.id), query);
};
</script>

<template>
    <Head :title="`Bio Konsultan - ${profile.displayName}`" />

    <div class="min-h-screen bg-[#f8fafc] font-sans text-gray-800">
        <PublicNavbar />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            
            <!-- Back Button -->
            <Link 
                :href="route('public.konsultan')" 
                class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-[#0B56D5] transition-colors mb-6 group"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Daftar Konsultan
            </Link>

            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- LEFT COLUMN: MAIN PROFILE CONTENT -->
                <div class="w-full lg:w-2/3 space-y-6">
                    
                    <!-- Header Card -->
                    <div class="bg-white rounded-3xl shadow-sm p-8 border border-gray-100 relative">
                        <!-- Top right badge -->
                        <div class="absolute top-8 right-8">
                            <span v-if="profile.isAvailable" class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 border border-green-200 text-sm font-bold px-4 py-1.5 rounded-full shadow-sm">
                                <span class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></span>
                                Tersedia
                            </span>
                            <span v-else class="inline-flex items-center gap-1.5 bg-red-50 text-red-700 border border-red-200 text-sm font-bold px-4 py-1.5 rounded-full shadow-sm">
                                <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                                Sibuk
                            </span>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-6">
                            <img :src="profile.avatar" :alt="profile.displayName" class="w-32 h-32 rounded-3xl object-cover ring-4 ring-blue-50 shadow-sm" />
                            
                            <div class="flex-1 pt-2">
                                <h1 class="text-3xl font-extrabold text-gray-900 mb-1">
                                    {{ profile.displayName }}
                                </h1>
                                <p class="text-lg text-gray-500 font-medium mb-6">
                                    {{ profile.roleTitle }}
                                </p>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-6 border-t border-gray-100">
                                    <div class="flex items-start gap-3">
                                        <div class="p-2 bg-yellow-50 rounded-lg text-yellow-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-0.5">Rating</p>
                                            <p class="font-bold text-gray-900">{{ profile.rating }} <span class="text-xs font-normal text-gray-500">({{ profile.reviews }})</span></p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path d="M12 14l9-5-9-5-9 5 9 5z" />
                                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-0.5">Pendidikan</p>
                                            <p class="font-bold text-gray-900 text-sm leading-tight">{{ profile.university }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-start gap-3">
                                        <div class="p-2 bg-green-50 rounded-lg text-green-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-400 uppercase tracking-wider font-semibold mb-0.5">Pengalaman</p>
                                            <p class="font-bold text-gray-900 text-sm">15 tahun pengalaman</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Keahlian Khusus Card -->
                    <div class="bg-white rounded-3xl shadow-sm p-8 border border-gray-100">
                        <div class="flex items-center gap-2 mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#0B56D5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                            <h2 class="text-xl font-bold text-gray-900">Keahlian Khusus</h2>
                        </div>
                        <div class="flex flex-wrap gap-3">
                            <span 
                                v-for="(spec, index) in profile.specialties" 
                                :key="index"
                                class="border-2 border-gray-200 text-gray-700 font-medium px-4 py-2 rounded-full hover:border-[#0B56D5] hover:text-[#0B56D5] transition-colors cursor-default"
                            >
                                {{ spec }}
                            </span>
                        </div>
                    </div>

                    <!-- Tentang Konsultan Card -->
                    <div class="bg-white rounded-3xl shadow-sm p-8 border border-gray-100">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Tentang Konsultan</h2>
                        
                        <div class="text-gray-600 leading-relaxed space-y-4 mb-8">
                            <p>
                                {{ profile.displayName }} adalah seorang {{ profile.roleTitle }} berpengalaman yang berdedikasi membantu individu dan keluarga mencapai kebebasan finansial. Dengan pendekatan personal yang disesuaikan dengan kondisi unik masing-masing klien, beliau memfokuskan strategi pada manajemen risiko dan pertumbuhan aset jangka panjang.
                            </p>
                            <p>
                                Filosofi utama beliau adalah bahwa perencanaan keuangan yang baik bukan hanya tentang angka, melainkan tentang memberikan ketenangan pikiran dan mewujudkan impian hidup Anda dengan cara yang terukur dan realistis.
                            </p>
                        </div>

                        <!-- Mengapa Memilih Konsultan Ini -->
                        <div class="bg-blue-50/50 border border-blue-100 rounded-2xl p-6">
                            <h3 class="font-bold text-[#0B56D5] mb-4">Mengapa Memilih Konsultan Ini?</h3>
                            <ul class="space-y-3">
                                <li class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span class="text-gray-700">Strategi yang 100% dipersonalisasi sesuai profil risiko Anda.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span class="text-gray-700">Penjelasan yang transparan dan mudah dipahami tanpa jargon yang rumit.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <svg class="h-5 w-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    <span class="text-gray-700">Dukungan berkelanjutan (follow-up) pasca sesi konsultasi utama.</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

                <!-- RIGHT COLUMN: STICKY BOOKING CARD -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-3xl shadow-lg border border-gray-100 p-8 sticky top-24">
                        
                        <div class="text-center pb-6 border-b border-gray-100 mb-6">
                            <h3 class="text-3xl font-extrabold text-[#0B56D5] mb-1">{{ formatPrice(profile.harga) }}</h3>
                            <p class="text-gray-500 text-sm font-medium">per jam sesi</p>
                        </div>

                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center gap-3 text-gray-700">
                                <div class="bg-gray-100 p-2 rounded-lg text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <span class="font-medium">Durasi Sesi: 60 menit konsultasi</span>
                            </li>
                            <li class="flex items-center gap-3 text-gray-700">
                                <div class="bg-gray-100 p-2 rounded-lg text-gray-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <span class="font-medium">Konsultasi Online: Via video call</span>
                            </li>
                        </ul>

                        <button 
                            @click="proceedToBooking"
                            class="w-full bg-[#00B16A] hover:bg-[#009E5F] text-white py-4 rounded-xl font-bold text-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 mb-8"
                        >
                            Pilih Jadwal
                        </button>

                        <div>
                            <p class="font-bold text-gray-900 mb-4 text-sm">Apa yang Anda Dapatkan:</p>
                            <ul class="space-y-2">
                                <li class="flex items-start gap-2 text-sm text-gray-600">
                                    <svg class="h-5 w-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Analisis keuangan personal
                                </li>
                                <li class="flex items-start gap-2 text-sm text-gray-600">
                                    <svg class="h-5 w-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Rekomendasi strategi
                                </li>
                                <li class="flex items-start gap-2 text-sm text-gray-600">
                                    <svg class="h-5 w-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Dokumen perencanaan
                                </li>
                                <li class="flex items-start gap-2 text-sm text-gray-600">
                                    <svg class="h-5 w-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Follow-up gratis
                                </li>
                            </ul>
                        </div>
                        
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>