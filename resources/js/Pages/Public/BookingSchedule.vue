<script setup>
import { Head, router } from '@inertiajs/vue3';
import PublicNavbar from '@/Components/PublicNavbar.vue';
import { ref, watch } from 'vue';

const props = defineProps({
    id: String,
    konsultan: Object,
    layanan: Object,
    bookedSlots: {
        type: Array,
        default: () => [],
    },
});

const formatPrice = (price) => {
    if (!price) return '-';
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(price);
};

const jadwal = [
    '09:00',
    '10:00',
    '11:00',
    '13:00',
    '14:00',
    '15:00',
    '16:00'
];

const selectedDate = ref('');
const selectedTime = ref('');
const topik = ref('');

// Calculate min date (today in local time YYYY-MM-DD)
const getTodayDateString = () => {
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    return `${yyyy}-${mm}-${dd}`;
};
const minDate = getTodayDateString();

const maxDate = (() => {
    const d = new Date();
    d.setDate(d.getDate() + 30);
    const yyyy = d.getFullYear();
    const mm = String(d.getMonth() + 1).padStart(2, '0');
    const dd = String(d.getDate()).padStart(2, '0');
    return `${yyyy}-${mm}-${dd}`;
})();

// Check if a time slot is booked for the currently selected date
const isTimeSlotBooked = (jam) => {
    if (!selectedDate.value) return false;
    const datetimeString = `${selectedDate.value} ${jam}:00`;
    return props.bookedSlots.some(slot => {
        return slot.replace('T', ' ').startsWith(datetimeString);
    });
};

// Reset selected time if it becomes booked on the newly selected date
watch(selectedDate, () => {
    if (selectedTime.value && isTimeSlotBooked(selectedTime.value)) {
        selectedTime.value = '';
    }
});

const lanjutCheckout = (id) => {
    if (!selectedDate.value || !selectedTime.value) {
        alert('Pilih tanggal dan jam terlebih dahulu');
        return;
    }

    if (isTimeSlotBooked(selectedTime.value)) {
        alert('Jadwal ini sudah terisi, silakan pilih jadwal lain.');
        return;
    }

    router.visit(
        `/checkout/${id}?date=${selectedDate.value}&time=${selectedTime.value}&topic=${topik.value}`
    );
};
</script>

<template>
    <Head title="Booking Jadwal" />

    <div class="min-h-screen bg-gray-100">

        <PublicNavbar />

        <div class="max-w-7xl mx-auto px-6 py-12">

            <!-- STEP -->
            <div class="flex items-center justify-center gap-6 mb-12">

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-indigo-700 text-white flex items-center justify-center font-bold">
                        1
                    </div>

                    <span class="font-semibold text-indigo-700">
                        Pilih Jadwal
                    </span>
                </div>

                <div class="w-16 h-1 bg-gray-300 rounded"></div>

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gray-300 text-white flex items-center justify-center font-bold">
                        2
                    </div>

                    <span class="text-gray-500">
                        Checkout
                    </span>
                </div>

            </div>

            <div class="grid lg:grid-cols-3 gap-8">

                <!-- LEFT -->
                <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm p-8">

                    <h1 class="text-3xl font-bold">
                        Pilih Jadwal Konsultasi
                    </h1>

                    <p class="text-gray-500 mt-2">
                        Tentukan tanggal dan waktu konsultasi Anda
                    </p>

                    <!-- TANGGAL -->
                    <div class="mt-10">

                        <label class="block font-semibold mb-3">
                            Pilih Tanggal
                        </label>

                        <input
                            type="date"
                            v-model="selectedDate"
                            :min="minDate"
                            :max="maxDate"
                            class="w-full border border-gray-300 rounded-xl p-4"
                        />

                    </div>

                    <!-- JAM -->
                    <div class="mt-10">

                        <h2 class="text-xl font-bold mb-5">
                            Pilih Jam
                        </h2>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                            <button
                                type="button"
                                v-for="jam in jadwal"
                                :key="jam"
                                :disabled="isTimeSlotBooked(jam)"
                                @click="selectedTime = jam"
                                :class="[
                                    'rounded-xl py-4 transition font-semibold border text-center flex flex-col items-center justify-center',
                                    isTimeSlotBooked(jam)
                                        ? 'bg-gray-200 text-gray-400 border-gray-300 cursor-not-allowed line-through'
                                        : selectedTime === jam
                                            ? 'bg-indigo-700 text-white border-indigo-700'
                                            : 'border-gray-300 hover:bg-indigo-700 hover:text-white'
                                ]"
                            >
                                <span>{{ jam }}</span>
                                <span v-if="isTimeSlotBooked(jam)" class="text-xs font-normal opacity-75 mt-0.5">(Terisi)</span>
                            </button>

                        </div>

                    </div>

                    <!-- TOPIK -->
                    <div class="mt-10">

                        <label class="block font-semibold mb-3">
                            Keluhan / Topik Konsultasi
                        </label>

                        <textarea
                            v-model="topik"
                            rows="5"
                            placeholder="Tulis kebutuhan konsultasi Anda..."
                            class="w-full border border-gray-300 rounded-xl p-4"
                        ></textarea>

                    </div>

                </div>

                <!-- RIGHT -->
                <div class="bg-white rounded-3xl shadow-sm p-8 h-fit sticky top-24">

                    <h2 class="text-2xl font-bold">
                        Ringkasan Booking
                    </h2>

                    <div class="mt-8">

                        <div class="flex items-center gap-4">

                            <div class="w-16 h-16 rounded-full bg-gray-300"></div>

                            <div>
                                <h3 class="font-bold">
                                    {{ konsultan ? konsultan.nama : 'Dr. Budi Santoso' }}
                                </h3>

                                <p class="text-gray-500 text-sm">
                                    {{ layanan ? layanan.nama_layanan : 'Konsultan Investasi' }}
                                </p>
                            </div>

                        </div>

                        <div class="space-y-5 mt-8">

                            <div class="flex justify-between">
                                <span class="text-gray-500">
                                    Tanggal
                                </span>

                                <span class="font-semibold">
                                    {{ selectedDate || '-' }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">
                                    Jam
                                </span>

                                <span class="font-semibold">
                                    {{ selectedTime || '-' }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">
                                    Durasi
                                </span>

                                <span class="font-semibold">
                                    60 Menit
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">
                                    Tarif
                                </span>

                                <span class="font-semibold">
                                    {{ formatPrice(konsultan ? (konsultan.tarif || (layanan ? layanan.harga : 0)) : 0) }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">
                                    Platform
                                </span>

                                <span class="font-semibold">
                                    Video Call
                                </span>
                            </div>

                        </div>

                        <!-- BUTTON -->
                        <button
                            type="button"
                            @click="lanjutCheckout(id)"
                            class="w-full mt-10 bg-green-500 hover:bg-green-600 transition text-white text-center py-4 rounded-xl font-semibold"
                        >
                            Lanjut ke Checkout
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>
</template>