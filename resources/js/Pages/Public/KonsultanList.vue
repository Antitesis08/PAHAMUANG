<script setup>
import { ref, reactive, computed, watch } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PublicNavbar from '@/Components/PublicNavbar.vue';

const props = defineProps({
    initialKonsultans: {
        type: Array,
        default: () => []
    }
});

// Extend database records with display data using DB fields
const getExtendedData = (user) => {
    // Use the status_aktif from backend if available
    const isAvailable = user.status_aktif !== undefined ? !!user.status_aktif : (user.is_available !== undefined ? !!user.is_available : false);
    const harga = user.tarif || 500000;
    const rating = user.rating ? parseFloat(user.rating) : 0;
    const reviews = user.jumlah_ulasan || 0;
    const university = "MBA - Universitas Indonesia";
    const specialties = user.spesialisasi 
        ? user.spesialisasi.split(',').map(s => s.trim())
        : ['Konsultasi Keuangan'];
    const roleTitle = "Certified Financial Planner";
    
    const displayName = user.nama.includes(',') ? user.nama : `${user.nama}, CFP`;

    const avatarColors = ['E0E7FF,4F46E5', 'FCE7F3,DB2777', 'D1FAE5,059669'];
    const colorPair = avatarColors[user.id % avatarColors.length].split(',');
    const avatar = user.foto_profil_url 
        ? user.foto_profil_url 
        : `https://ui-avatars.com/api/?name=${encodeURIComponent(user.nama)}&background=${colorPair[0]}&color=${colorPair[1]}`;

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

const konsultans = ref(props.initialKonsultans.map(getExtendedData));

// Reactive Filters
const filters = reactive({
    harga: 'semua',
    rating: 'semua',
    status: 'semua'
});

// Applied filters used after a short debounce to simulate smooth transitions
const appliedFilters = reactive({ ...filters });
const isFiltering = ref(false);
let filterTimer = null;

watch(filters, () => {
    isFiltering.value = true;
    if (filterTimer) clearTimeout(filterTimer);
    filterTimer = setTimeout(() => {
        appliedFilters.harga = filters.harga;
        appliedFilters.rating = filters.rating;
        appliedFilters.status = filters.status;
        isFiltering.value = false;
    }, 300);
}, { deep: true });

// Computed properties for filtered list (uses appliedFilters for smooth UX)
const filteredKonsultans = computed(() => {
    return konsultans.value.filter(k => {
        // Status Filter
        if (appliedFilters.status === 'tersedia' && !k.isAvailable) return false;
        if (appliedFilters.status === 'sibuk' && k.isAvailable) return false;

        // Rating Filter
        if (appliedFilters.rating === '4.5' && k.rating < 4.5) return false;
        if (appliedFilters.rating === '4.7' && k.rating < 4.7) return false;
        if (appliedFilters.rating === '4.9' && k.rating < 4.9) return false;

        // Harga Filter
        if (appliedFilters.harga === '<700k' && k.harga >= 700000) return false;
        if (appliedFilters.harga === '700k-800k' && (k.harga < 700000 || k.harga > 800000)) return false;
        if (appliedFilters.harga === '>=800k' && k.harga < 800000) return false;

        return true;
    });
});

const formatPrice = (price) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(price);
};
</script>

<template>
    <Head title="Pilih Konsultan" />

    <div class="min-h-screen bg-bg-50 font-sans text-gray-800">
        <PublicNavbar />

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            
            <div class="flex flex-col lg:flex-row gap-8">
                
                <!-- LEFT SIDEBAR: FILTERS -->
                <div class="w-full lg:w-1/4 flex-shrink-0">
                    <div class="bg-bg-50 rounded-2xl shadow-sm p-6 border border-gray-100 sticky top-24">
                        <div class="flex items-center gap-2 mb-6 pb-4 border-b border-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-brand-focus" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                            <h2 class="text-lg font-bold text-gray-900">Filter</h2>
                        </div>

                        <!-- Rentang Harga -->
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-3 text-sm">Rentang Harga</h3>
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" v-model="filters.harga" value="semua" class="w-4 h-4 text-brand-focus focus:ring-brand-focus border-gray-300">
                                    <span class="text-gray-600 text-sm group-hover:text-gray-900">Semua Harga</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" v-model="filters.harga" value="<700k" class="w-4 h-4 text-brand-focus focus:ring-brand-focus border-gray-300">
                                    <span class="text-gray-600 text-sm group-hover:text-gray-900">&lt; Rp 700.000</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" v-model="filters.harga" value="700k-800k" class="w-4 h-4 text-brand-focus focus:ring-brand-focus border-gray-300">
                                    <span class="text-gray-600 text-sm group-hover:text-gray-900">Rp 700.000 - Rp 800.000</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" v-model="filters.harga" value=">=800k" class="w-4 h-4 text-brand-focus focus:ring-brand-focus border-gray-300">
                                    <span class="text-gray-600 text-sm group-hover:text-gray-900">&ge; Rp 800.000</span>
                                </label>
                            </div>
                        </div>

                        <!-- Rating Minimum -->
                        <div class="mb-6">
                            <h3 class="font-semibold text-gray-900 mb-3 text-sm">Rating Minimum</h3>
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" v-model="filters.rating" value="semua" class="w-4 h-4 text-brand-focus focus:ring-brand-focus border-gray-300">
                                    <span class="text-gray-600 text-sm group-hover:text-gray-900">Semua Rating</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" v-model="filters.rating" value="4.5" class="w-4 h-4 text-brand-focus focus:ring-brand-focus border-gray-300">
                                    <span class="text-gray-600 text-sm group-hover:text-gray-900">4.5+ ★</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" v-model="filters.rating" value="4.7" class="w-4 h-4 text-brand-focus focus:ring-brand-focus border-gray-300">
                                    <span class="text-gray-600 text-sm group-hover:text-gray-900">4.7+ ★</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" v-model="filters.rating" value="4.9" class="w-4 h-4 text-brand-focus focus:ring-brand-focus border-gray-300">
                                    <span class="text-gray-600 text-sm group-hover:text-gray-900">4.9+ ★</span>
                                </label>
                            </div>
                        </div>

                        <!-- Ketersediaan -->
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-3 text-sm">Ketersediaan</h3>
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" v-model="filters.status" value="semua" class="w-4 h-4 text-brand-focus focus:ring-brand-focus border-gray-300">
                                    <span class="text-gray-600 text-sm group-hover:text-gray-900">Semua Status</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" v-model="filters.status" value="tersedia" class="w-4 h-4 text-brand-focus focus:ring-brand-focus border-gray-300">
                                    <span class="flex items-center gap-2 text-gray-600 text-sm group-hover:text-gray-900">
                                        <span class="w-2 h-2 rounded-full bg-success"></span> Tersedia
                                    </span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" v-model="filters.status" value="sibuk" class="w-4 h-4 text-brand-focus focus:ring-brand-focus border-gray-300">
                                    <span class="flex items-center gap-2 text-gray-600 text-sm group-hover:text-gray-900">
                                        <span class="w-2 h-2 rounded-full bg-red-500"></span> Sibuk
                                    </span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT GRID: CONSULTANTS -->
                <div class="flex-1">
                    <!-- Header -->
                    <div class="mb-8">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">Pilih Konsultan Keuangan</h1>
                        <p class="text-gray-500 text-lg">Temukan pakar keuangan bersertifikat yang tepat untuk kebutuhan Anda.</p>
                        <p class="text-brand-focus font-medium text-sm mt-4">
                            Menampilkan {{ filteredKonsultans.length }} konsultan
                        </p>
                    </div>

                    <!-- Grid -->
                    <div>
                        <TransitionGroup
                            tag="div"
                            class="grid gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3"
                            enter-active-class="transition transform duration-300"
                            enter-from-class="opacity-0 translate-y-2"
                            enter-to-class="opacity-100 translate-y-0"
                            leave-active-class="transition transform duration-300"
                            leave-from-class="opacity-100 translate-y-0"
                            leave-to-class="opacity-0 -translate-y-2"
                        >
                            <template v-if="!isFiltering">
                                <div
                                    v-for="item in filteredKonsultans"
                                    :key="item.id"
                                    class="card p-6 hover:-translate-y-1 hover:shadow-lg flex flex-col relative group"
                                >
                            <!-- Badge -->
                            <div class="absolute top-4 right-4 z-10">
                                <span v-if="item.isAvailable" class="inline-flex items-center gap-1.5 bg-green-50 text-green-700 border border-green-200 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                    Tersedia
                                </span>
                                <span v-else class="inline-flex items-center gap-1.5 bg-red-50 text-red-700 border border-red-200 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                                    <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                    Sedang Tidak Tersedia
                                </span>
                            </div>

                            <div class="flex-1">
                                <!-- Avatar & Identity -->
                                <div class="flex gap-4 mb-4 items-center">
                                    <img :src="item.avatar" :alt="item.displayName" class="w-16 h-16 rounded-full ring-2 ring-gray-100 object-cover flex-shrink-0" />
                                    <div>
                                        <h2 class="text-lg font-bold text-gray-900 leading-tight group-hover:text-brand-focus transition-colors">
                                            {{ item.displayName }}
                                        </h2>
                                        <p class="text-sm text-gray-500 mt-1 font-medium">{{ item.roleTitle }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">{{ item.university }}</p>
                                    </div>
                                </div>

                                <!-- Rating -->
                                <div class="flex items-center gap-2 mb-5">
                                    <div class="flex text-yellow-400 text-sm">
                                        ★ ★ ★ ★ ★
                                    </div>
                                    <span class="text-sm font-bold text-gray-700">{{ item.rating }}</span>
                                    <span class="text-xs text-gray-400">({{ item.reviews }} ulasan)</span>
                                </div>

                                <!-- Specialties -->
                                <div class="flex flex-wrap gap-2 mb-2">
                                    <span 
                                        v-for="(spec, index) in item.specialties" 
                                        :key="index"
                                        class="chip text-brand-focus border-brand-focus/20 hover:bg-brand-focus/5"
                                    >
                                        {{ spec }}
                                    </span>
                                </div>
                            </div>

                            <!-- Footer -->
                            <div class="border-t border-gray-100 p-6 bg-gray-50/50 rounded-b-2xl flex items-center justify-between mt-4">
                                <div>
                                    <p class="text-xs text-gray-400 mb-1">Tarif Konsultasi</p>
                                    <p class="font-bold text-gray-900">
                                        {{ formatPrice(item.harga) }}<span class="text-sm font-normal text-gray-500">/jam</span>
                                    </p>
                                </div>
                                <Link
                                    v-if="item.isAvailable"
                                    :href="route('public.konsultan.detail', item.id)"
                                    class="btn-primary px-4 py-2 text-sm rounded-lg"
                                >
                                    Lihat Profil
                                </Link>
                                <button
                                    v-else
                                    disabled
                                    class="bg-gray-200 text-gray-400 cursor-not-allowed px-4 py-2 text-sm rounded-lg font-semibold"
                                >
                                    Tidak Tersedia
                                </button>
                            </div>
                                </div>
                            </template>

                            <!-- Skeleton placeholders during filtering -->
                            <template v-if="isFiltering">
                                <div v-for="n in 6" :key="`skeleton-${n}`" class="card p-6 flex flex-col gap-4">
                                    <div class="flex gap-4 mb-4 items-center">
                                        <div class="w-16 h-16 rounded-full bg-slate-100 skeleton"></div>
                                        <div class="flex-1">
                                            <div class="h-4 w-3/4 bg-slate-100 skeleton mb-2"></div>
                                            <div class="h-3 w-1/2 bg-slate-100 skeleton"></div>
                                        </div>
                                    </div>

                                    <div class="h-3 w-2/3 bg-slate-100 skeleton mb-2"></div>
                                    <div class="flex gap-2">
                                        <div class="h-8 w-20 bg-slate-100 skeleton rounded-full"></div>
                                        <div class="h-8 w-20 bg-slate-100 skeleton rounded-full"></div>
                                    </div>

                                    <div class="mt-auto border-t border-gray-100 p-4 bg-bg-50/60 rounded-b-2xl flex items-center justify-between">
                                        <div>
                                            <div class="h-3 w-24 bg-slate-100 skeleton mb-2"></div>
                                            <div class="h-4 w-20 bg-slate-100 skeleton"></div>
                                        </div>
                                        <div class="h-9 w-28 bg-slate-100 skeleton rounded-lg"></div>
                                    </div>
                                </div>
                            </template>

                        </TransitionGroup>
                    </div>
                    
                    <!-- Empty State -->
                    <div v-if="filteredKonsultans.length === 0 && !isFiltering" class="text-center py-20 bg-white rounded-2xl border border-dashed border-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-1">Tidak ada konsultan</h3>
                        <p class="text-gray-500">Ubah filter Anda untuk menemukan konsultan yang tersedia.</p>
                        <button @click="filters.harga = 'semua'; filters.rating = 'semua'; filters.status = 'semua'" class="mt-4 text-[#0B56D5] hover:underline font-medium text-sm">
                            Reset Filter
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>