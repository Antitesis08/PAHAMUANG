<script setup>
import { Head } from '@inertiajs/vue3';
import PublicNavbar from '@/Components/PublicNavbar.vue';
import { ref } from 'vue';

const kodeBooking = ref('');
const isLoading = ref(false);
const result = ref(null);
const errorMessage = ref('');

const ratingInput = ref(0)
const ulasanInput = ref('')
const ratingLoading = ref(false)
const ratingSuccess = ref(false)
const ratingError = ref('')
const hoveredStar = ref(0)

const cekStatus = async () => {
    const kode = kodeBooking.value.trim();
    if (!kode) {
        errorMessage.value = 'Silakan masukkan kode booking terlebih dahulu.';
        result.value = null;
        return;
    }

    isLoading.value = true;
    errorMessage.value = '';
    result.value = null;
    ratingSuccess.value = false;
    ratingInput.value = 0;
    ulasanInput.value = '';

    try {
        const response = await fetch(`/api/booking/${encodeURIComponent(kode)}`);
        const data = await response.json();

        if (response.ok) {
            result.value = data;
        } else {
            errorMessage.value = data.message || 'Kode booking tidak ditemukan.';
        }
    } catch (err) {
        errorMessage.value = 'Terjadi kesalahan saat menghubungi server. Silakan coba lagi.';
    } finally {
        isLoading.value = false;
    }
};

const submitRating = async () => {
    if (ratingInput.value === 0) return
    ratingLoading.value = true
    ratingError.value = ''
    try {
        const res = await fetch(`/api/booking/${result.value.kode_transaksi}/rating`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-XSRF-TOKEN': decodeURIComponent(document.cookie.match(/XSRF-TOKEN=([^;]+)/)?.[1] || ''),
            },
            body: JSON.stringify({
                rating: ratingInput.value,
                ulasan: ulasanInput.value,
            }),
        })
        const data = await res.json()
        if (!res.ok) {
            ratingError.value = data.message || 'Gagal mengirim rating.'
        } else {
            ratingSuccess.value = true
        }
    } catch {
        ratingError.value = 'Terjadi kesalahan. Coba lagi.'
    } finally {
        ratingLoading.value = false
    }
}

const formatPrice = (price) => {
    if (!price) return '-';
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
    }).format(price);
};

const statusColor = (status) => {
    const map = {
        pending: 'bg-yellow-100 text-yellow-800 border-yellow-200',
        aktif: 'bg-green-100 text-green-800 border-green-200',
        selesai: 'bg-blue-100 text-blue-800 border-blue-200',
        ditolak: 'bg-red-100 text-red-800 border-red-200',
        dibatalkan: 'bg-gray-100 text-gray-800 border-gray-200',
    };
    return map[status] || 'bg-gray-100 text-gray-700 border-gray-200';
};
</script>

<template>
    <Head title="Cek Status Booking" />

    <div class="min-h-screen bg-gray-50 font-sans text-gray-800">
        <PublicNavbar />

        <!-- Hero -->
        <section class="bg-gradient-to-br from-[#0B56D5] to-blue-800 text-white pt-20 pb-16 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-96 h-96 bg-blue-400 opacity-20 rounded-full blur-3xl transform translate-x-1/3 -translate-y-1/3"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-green-300 opacity-10 rounded-full blur-3xl transform -translate-x-1/2 translate-y-1/3"></div>

            <div class="max-w-3xl mx-auto px-6 text-center relative z-10">
                <span class="inline-block px-4 py-1 bg-white bg-opacity-10 border border-white border-opacity-20 rounded-full text-blue-100 text-xs font-semibold tracking-wide uppercase mb-6">
                    Tracking Booking
                </span>

                <h1 class="text-3xl md:text-4xl font-extrabold leading-tight mb-4 tracking-tight">
                    Cek Status Booking
                </h1>

                <p class="text-blue-100 text-base md:text-lg max-w-2xl mx-auto leading-relaxed">
                    Masukkan kode booking Anda (contoh: TX-XXXXXX) untuk melihat status konsultasi secara real-time tanpa perlu login.
                </p>
            </div>
        </section>

        <!-- Search Section -->
        <section class="py-12">
            <div class="max-w-2xl mx-auto px-6">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                    <label for="kode-booking" class="block text-sm font-semibold text-gray-700 mb-3">
                        Kode Booking
                    </label>

                    <div class="flex gap-3">
                        <input
                            id="kode-booking"
                            v-model="kodeBooking"
                            type="text"
                            placeholder="TX-XXXXXX"
                            class="flex-1 rounded-xl border border-gray-300 px-5 py-3.5 text-sm focus:border-[#0B56D5] focus:ring-[#0B56D5] transition placeholder-gray-400"
                            @keydown.enter="cekStatus"
                        />

                        <button
                            @click="cekStatus"
                            :disabled="isLoading"
                            class="bg-[#0B56D5] hover:bg-blue-700 text-white font-semibold px-6 py-3.5 rounded-xl transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed flex items-center gap-2 shadow-sm hover:shadow-md"
                        >
                            <svg v-if="isLoading" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <span>{{ isLoading ? 'Mencari...' : 'Cek Status' }}</span>
                        </button>
                    </div>

                    <p class="text-xs text-gray-400 mt-3">
                        Kode booking dikirimkan setelah pembayaran berhasil.
                    </p>
                </div>

                <!-- Error Message -->
                <Transition
                    enter-active-class="transition duration-300 ease-out"
                    enter-from-class="opacity-0 -translate-y-2"
                    enter-to-class="opacity-100 translate-y-0"
                    leave-active-class="transition duration-200 ease-in"
                    leave-from-class="opacity-100 translate-y-0"
                    leave-to-class="opacity-0 -translate-y-2"
                >
                    <div v-if="errorMessage" class="mt-6 bg-red-50 border border-red-200 rounded-2xl p-5 flex items-start gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-semibold text-red-800 text-sm">Booking Tidak Ditemukan</p>
                            <p class="text-red-600 text-sm mt-1">{{ errorMessage }}</p>
                        </div>
                    </div>
                </Transition>

                <!-- Result Card -->
                <Transition
                    enter-active-class="transition duration-400 ease-out"
                    enter-from-class="opacity-0 translate-y-4"
                    enter-to-class="opacity-100 translate-y-0"
                    leave-active-class="transition duration-200 ease-in"
                    leave-from-class="opacity-100 translate-y-0"
                    leave-to-class="opacity-0 translate-y-4"
                >
                    <div v-if="result" class="mt-6 bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                        <!-- Header -->
                        <div class="bg-gradient-to-r from-[#0B56D5] to-blue-700 px-8 py-5 text-white flex items-center justify-between">
                            <div>
                                <p class="text-blue-200 text-xs font-medium uppercase tracking-wider">Kode Booking</p>
                                <p class="text-xl font-bold mt-1">{{ result.kode_transaksi }}</p>
                            </div>
                            <span
                                :class="statusColor(result.status)"
                                class="px-4 py-1.5 rounded-full text-xs font-bold uppercase border"
                            >
                                {{ result.status }}
                            </span>
                        </div>

                        <!-- Details -->
                        <div class="p-8 space-y-5">
                            <div class="grid sm:grid-cols-2 gap-5">
                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#0B56D5]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 font-medium">Nama Pemesan</p>
                                        <p class="font-semibold text-gray-900 mt-0.5">{{ result.nama_user }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 font-medium">Konsultan</p>
                                        <p class="font-semibold text-gray-900 mt-0.5">{{ result.nama_konsultan }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-purple-50 flex items-center justify-center flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 font-medium">Jadwal Konsultasi</p>
                                        <p class="font-semibold text-gray-900 mt-0.5">{{ result.jadwal }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-amber-50 flex items-center justify-center flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 font-medium">Total Pembayaran</p>
                                        <p class="font-semibold text-gray-900 mt-0.5">{{ result.jumlah_bayar }}</p>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-gray-100">

                            <div class="flex items-center justify-between text-sm">
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-400">Metode Bayar:</span>
                                    <span class="font-medium text-gray-700">{{ result.metode_pembayaran }}</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-gray-400">Status Bayar:</span>
                                    <span
                                        :class="result.status_pembayaran === 'lunas' ? 'text-green-600' : 'text-yellow-600'"
                                        class="font-semibold capitalize"
                                    >
                                        {{ result.status_pembayaran }}
                                    </span>
                                </div>
                            </div>

                            <!-- Rating Section -->
                            <div v-if="result && result.bisa_rating && !ratingSuccess" class="mt-8 border-t pt-6">
                                <h3 class="text-lg font-bold mb-4 text-gray-900">Berikan Rating untuk Konsultan</h3>
                                
                                <!-- Bintang interaktif 1-5 -->
                                <div class="flex gap-2 mb-4">
                                    <button
                                        v-for="star in 5"
                                        :key="star"
                                        type="button"
                                        @click="ratingInput = star"
                                        @mouseenter="hoveredStar = star"
                                        @mouseleave="hoveredStar = 0"
                                        class="text-3xl transition focus:outline-none"
                                        :class="star <= (hoveredStar || ratingInput) ? 'text-yellow-400' : 'text-gray-300'"
                                    >★</button>
                                </div>

                                <!-- Komentar opsional -->
                                <textarea
                                    v-model="ulasanInput"
                                    placeholder="Tulis komentar Anda (opsional)..."
                                    rows="3"
                                    class="w-full border border-gray-300 rounded-xl p-3 mb-4 focus:border-[#0B56D5] focus:ring-[#0B56D5] transition"
                                ></textarea>

                                <!-- Error message -->
                                <p v-if="ratingError" class="text-red-500 text-sm mb-3">{{ ratingError }}</p>

                                <!-- Tombol submit rating -->
                                <button
                                    type="button"
                                    @click="submitRating"
                                    :disabled="ratingInput === 0 || ratingLoading"
                                    class="bg-indigo-700 text-white px-6 py-3 rounded-xl font-semibold disabled:opacity-50 hover:bg-indigo-800 transition"
                                >
                                    <span v-if="ratingLoading">Mengirim...</span>
                                    <span v-else>Kirim Rating</span>
                                </button>
                            </div>

                            <!-- Pesan sukses setelah rating -->
                            <div v-if="ratingSuccess" class="mt-8 border-t pt-6 text-center">
                                <div class="text-4xl mb-3">⭐</div>
                                <p class="font-bold text-green-600 text-lg">Terima kasih atas ulasan Anda!</p>
                                <p class="text-gray-500 text-sm mt-1">Rating Anda membantu pengguna lain memilih konsultan terbaik.</p>
                            </div>

                            <!-- Jika sudah pernah dirating -->
                            <div v-if="result && result.sudah_dirating" class="mt-8 border-t pt-6 text-center text-gray-400">
                                <p>Anda sudah memberikan rating untuk konsultasi ini.</p>
                            </div>
                        </div>
                    </div>
                </Transition>
            </div>
        </section>
    </div>
</template>
