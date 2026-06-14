<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import PublicNavbar from '@/Components/PublicNavbar.vue';

const props = defineProps({
    id: String,
    date: String,
    time: String,
    topic: String,
    konsultan: Object,
    layanan: Object,
    auth: Object,
});

const paymentMethod = ref('');
const paymentDetail = ref(null);
const showPaymentModal = ref(false);
const paymentLoading = ref(false);

const form = useForm({
    name: props.auth?.user?.role === 3 ? (props.auth?.user?.nama || '') : '',
    email: props.auth?.user?.role === 3 ? (props.auth?.user?.email || '') : '',
    phone: props.auth?.user?.role === 3 ? (props.auth?.user?.no_telepon || '') : '',
    topic: props.topic || '',
    date: props.date || '',
    time: props.time || '',
    payment_method: '',
});

// Watch payment method and detail to keep form in sync
watch(paymentMethod, (newVal) => {
    form.payment_method = newVal;
});
watch(paymentDetail, (newVal) => {
    if (newVal) {
        form.payment_method = paymentMethod.value + ' - ' + newVal;
    } else {
        form.payment_method = paymentMethod.value;
    }
});

const submitCheckout = () => {
    if (!form.payment_method) {
        alert('Silakan pilih metode pembayaran terlebih dahulu');
        return;
    }

    showPaymentModal.value = true;
};

const confirmPayment = () => {
    paymentLoading.value = true;
    setTimeout(() => {
        paymentLoading.value = false;
        showPaymentModal.value = false;
        form.post(route('public.checkout.store', props.id));
    }, 700);
};

const formatPrice = (price) => {
    if (!price) return '-';
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(price);
};
</script>

<template>
    <Head title="Checkout" />

    <div class="min-h-screen bg-gray-100">

        <PublicNavbar />

        <div class="max-w-7xl mx-auto px-6 py-12">

            <!-- STEP -->
            <div class="flex items-center justify-center gap-6 mb-12">

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center font-bold">
                        ✓
                    </div>

                    <span class="font-semibold text-green-600">
                        Jadwal Dipilih
                    </span>
                </div>

                <div class="w-16 h-1 bg-green-500 rounded"></div>

                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-indigo-700 text-white flex items-center justify-center font-bold">
                        2
                    </div>

                    <span class="font-semibold text-indigo-700">
                        Checkout
                    </span>
                </div>

            </div>

            <div class="grid lg:grid-cols-3 gap-8">

                <!-- LEFT -->
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm p-8">

                    <h1 class="text-3xl font-bold">
                        Checkout Konsultasi
                    </h1>

                    <p class="text-gray-500 mt-2">
                        Lengkapi data dan pilih metode pembayaran
                    </p>

                    <!-- FORM -->
                    <div class="space-y-6 mt-10">

                        <div>
                            <label class="block font-semibold mb-3">
                                Nama Lengkap
                            </label>

                            <input
                                type="text"
                                v-model="form.name"
                                class="w-full border border-gray-300 rounded-xl p-4"
                            />
                        </div>

                        <div>
                            <label class="block font-semibold mb-3">
                                Email
                            </label>

                            <input
                                type="email"
                                v-model="form.email"
                                class="w-full border border-gray-300 rounded-xl p-4"
                            />
                        </div>

                        <div>
                            <label class="block font-semibold mb-3">
                                Nomor Telepon
                            </label>

                            <input
                                type="text"
                                v-model="form.phone"
                                class="w-full border border-gray-300 rounded-xl p-4"
                            />
                        </div>

                        <!-- TOPIK -->
                        <div>
                            <label class="block font-semibold mb-3">
                                Topik Konsultan
                            </label>

                            <textarea
                                rows="5"
                                v-model="form.topic"
                                placeholder="Tulis topik atau kebutuhan konsultasi..."
                                class="w-full border border-gray-300 rounded-xl p-4"
                            ></textarea>
                        </div>

                    </div>

                    <!-- PAYMENT -->
                    <div class="mt-12">

                        <h2 class="text-2xl font-bold mb-6">
                            Metode Pembayaran
                        </h2>

                        <div class="space-y-4">

                            <!-- TRANSFER BANK -->
                            <div
                                class="border rounded-xl p-5 transition"
                                :class="paymentMethod === 'bank'
                                    ? 'border-indigo-700'
                                    : 'border-gray-300'"
                            >

                                <div
                                    class="flex justify-between items-center cursor-pointer"
                                    @click="paymentMethod = 'bank'"
                                >

                                    <div>
                                        <h3 class="font-bold">
                                            Transfer Bank
                                        </h3>

                                        <p class="text-gray-500 text-sm">
                                            BCA, Mandiri, BNI, BRI
                                        </p>
                                    </div>

                                    <input
                                        type="radio"
                                        :checked="paymentMethod === 'bank'"
                                    />

                                </div>

                                <!-- PILIH BANK -->
                                <div
                                    v-if="paymentMethod === 'bank'"
                                    class="mt-5"
                                >

                                    <select
                                        v-model="paymentDetail"
                                        class="w-full border border-gray-300 rounded-xl p-4"
                                    >
                                        <option disabled value="">
                                            -- Pilih Bank --
                                        </option>

                                        <option value="BCA">
                                            BCA
                                        </option>

                                        <option value="Mandiri">
                                            Mandiri
                                        </option>

                                        <option value="BNI">
                                            BNI
                                        </option>

                                        <option value="BRI">
                                            BRI
                                        </option>

                                    </select>

                                </div>

                            </div>

                            <!-- EWALLET -->
                            <div
                                class="border rounded-xl p-5 transition"
                                :class="paymentMethod === 'ewallet'
                                    ? 'border-indigo-700'
                                    : 'border-gray-300'"
                            >

                                <div
                                    class="flex justify-between items-center cursor-pointer"
                                    @click="paymentMethod = 'ewallet'"
                                >

                                    <div>
                                        <h3 class="font-bold">
                                            E-Wallet
                                        </h3>

                                        <p class="text-gray-500 text-sm">
                                            OVO, DANA, GoPay
                                        </p>
                                    </div>

                                    <input
                                        type="radio"
                                        :checked="paymentMethod === 'ewallet'"
                                    />

                                </div>

                                <!-- PILIH EWALLET -->
                                <div
                                    v-if="paymentMethod === 'ewallet'"
                                    class="mt-5"
                                >

                                    <select
                                        v-model="paymentDetail"
                                        class="w-full border border-gray-300 rounded-xl p-4"
                                    >
                                        <option disabled value="">
                                            -- Pilih E-Wallet --
                                        </option>

                                        <option value="OVO">
                                            OVO
                                        </option>

                                        <option value="DANA">
                                            DANA
                                        </option>

                                        <option value="GoPay">
                                            GoPay
                                        </option>

                                    </select>

                                </div>

                            </div>

                            <!-- QRIS -->
                            <div
                                class="border rounded-xl p-5 cursor-pointer transition"
                                :class="paymentMethod === 'qris'
                                    ? 'border-indigo-700'
                                    : 'border-gray-300'"
                                @click="
                                    paymentMethod = 'qris';
                                    paymentDetail = 'QRIS';
                                "
                            >

                                <div class="flex justify-between items-center">

                                    <div>
                                        <h3 class="font-bold">
                                            QRIS
                                        </h3>

                                        <p class="text-gray-500 text-sm">
                                            Semua aplikasi pembayaran
                                        </p>
                                    </div>

                                    <input
                                        type="radio"
                                        :checked="paymentMethod === 'qris'"
                                    />

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- RIGHT -->
                <div class="bg-white rounded-2xl shadow-sm p-8 h-fit sticky top-24">

                    <h2 class="text-2xl font-bold">
                        Ringkasan Pesanan
                    </h2>

                    <div class="mt-8">

                        <div class="flex items-center gap-4">

                            <div class="w-16 h-16 rounded-full bg-gray-300 flex items-center justify-center text-3xl font-bold text-gray-500">
                                👨‍💼
                            </div>

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
                                    Konsultasi
                                </span>

                                <span>
                                    {{ formatPrice(konsultan ? (konsultan.tarif || (layanan ? layanan.harga : 0)) : 0) }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">
                                    Biaya Admin
                                </span>

                                <span>
                                    Rp5.000
                                </span>
                            </div>

                            <!-- METODE -->
                            <div class="flex justify-between">
                                <span class="text-gray-500">
                                    Metode Pembayaran
                                </span>

                                <span class="font-semibold">
                                    {{ paymentDetail || paymentMethod || '-' }}
                                </span>
                            </div>

                            <hr>

                            <div class="flex justify-between text-xl font-bold">

                                <span>Total</span>

                                <span class="text-indigo-700">
                                    {{ formatPrice((konsultan ? (parseFloat(konsultan.tarif) || (layanan ? parseFloat(layanan.harga) : 0)) : 0) + 5000) }}
                                </span>

                            </div>

                        </div>

                        <button
                            type="button"
                            @click="submitCheckout"
                            :disabled="form.processing"
                            class="w-full mt-10 bg-green-500 hover:bg-green-600 transition text-white py-4 rounded-xl font-semibold"
                        >
                            {{ form.processing ? 'Memproses...' : 'Bayar Sekarang' }}
                        </button>

                    </div>

                </div>

            </div>

        </div>

        <div v-if="showPaymentModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4 py-6">
            <div class="w-full max-w-xl rounded-3xl bg-white p-8 shadow-2xl">
                <h2 class="text-2xl font-bold text-gray-900">Konfirmasi Pembayaran</h2>
                <p class="mt-3 text-gray-600">Pembayaran akan diproses sebagai simulasi. Pastikan data sudah benar sebelum melanjutkan.</p>

                <div class="mt-6 rounded-3xl border border-gray-200 bg-gray-50 p-6">
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Metode</span>
                        <span>{{ paymentDetail || paymentMethod || '-' }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500 mt-2">
                        <span>Total</span>
                        <span>{{ formatPrice((konsultan ? (parseFloat(konsultan.tarif) || (layanan ? parseFloat(layanan.harga) : 0)) : 0) + 5000) }}</span>
                    </div>
                </div>

                <div class="mt-8 flex flex-col gap-4 sm:flex-row sm:justify-end">
                    <button
                        type="button"
                        @click="showPaymentModal = false"
                        class="rounded-xl border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-100 transition"
                    >
                        Batal
                    </button>
                    <button
                        type="button"
                        @click="confirmPayment"
                        :disabled="paymentLoading"
                        class="rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white hover:bg-green-700 transition disabled:opacity-60"
                    >
                        <span v-if="paymentLoading">Memproses...</span>
                        <span v-else>Konfirmasi dan Bayar</span>
                    </button>
                </div>
            </div>
        </div>

    </div>
</template>