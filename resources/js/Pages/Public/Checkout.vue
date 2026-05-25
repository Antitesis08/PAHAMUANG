<script setup>
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import PublicNavbar from '@/Components/PublicNavbar.vue';

const paymentMethod = ref('');
const paymentDetail = ref(null);
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
                                class="w-full border border-gray-300 rounded-xl p-4"
                            />
                        </div>

                        <div>
                            <label class="block font-semibold mb-3">
                                Email
                            </label>

                            <input
                                type="email"
                                class="w-full border border-gray-300 rounded-xl p-4"
                            />
                        </div>

                        <div>
                            <label class="block font-semibold mb-3">
                                Nomor Telepon
                            </label>

                            <input
                                type="text"
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

                            <div class="w-16 h-16 rounded-full bg-gray-300"></div>

                            <div>
                                <h3 class="font-bold">
                                    Dr. Budi Santoso
                                </h3>

                                <p class="text-gray-500 text-sm">
                                    Konsultan Investasi
                                </p>
                            </div>

                        </div>

                        <div class="space-y-5 mt-8">

                            <div class="flex justify-between">
                                <span class="text-gray-500">
                                    Konsultasi
                                </span>

                                <span>
                                    Rp750.000
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
                                    {{ paymentDetail || '-' }}
                                </span>
                            </div>

                            <hr>

                            <div class="flex justify-between text-xl font-bold">

                                <span>Total</span>

                                <span class="text-indigo-700">
                                    Rp755.000
                                </span>

                            </div>

                        </div>

                        <button
                            class="w-full mt-10 bg-green-500 hover:bg-green-600 transition text-white py-4 rounded-xl font-semibold"
                        >
                            Bayar Sekarang
                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>
</template>