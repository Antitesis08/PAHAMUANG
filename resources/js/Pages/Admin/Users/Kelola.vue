<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Kelola User" />

    <AuthenticatedLayout>

        <template #header>
            <h2 class="text-2xl font-bold text-gray-800">
                Kelola User
            </h2>
        </template>

        <div class="min-h-screen bg-gray-50 py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">
                        Manajemen Pengguna
                    </h1>

                    <p class="mt-2 text-gray-500">
                        Kelola data konsultan dan pelanggan aplikasi PAHAMUANG
                    </p>
                </div>

                <!-- Menu Cards -->
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    <!-- Konsultan -->
                    <Link
                        :href="route('admin.konsultan.index')"
                        class="group rounded-3xl bg-white p-8 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div
                            class="mb-6 flex h-20 w-20 items-center justify-center rounded-2xl bg-blue-100 transition group-hover:bg-blue-200"
                        >
                            <img
                                src="/images/konsultan.png"
                                alt="Konsultan"
                                class="h-10 w-10 object-contain"
                            />
                        </div>

                        <h2 class="text-2xl font-bold text-gray-900">
                            Manajemen Konsultan
                        </h2>

                        <p class="mt-3 text-gray-500">
                            Kelola data konsultan, status aktif,
                            dan informasi akun konsultan.
                        </p>

                        <div
                            class="mt-6 inline-flex items-center font-semibold text-blue-600"
                        >
                            Kelola Konsultan →
                        </div>
                    </Link>

                    <!-- Pelanggan -->
                    <Link
                        :href="route('admin.pelanggan.index')"
                        class="group rounded-3xl bg-white p-8 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div
                            class="mb-6 flex h-20 w-20 items-center justify-center rounded-2xl bg-green-100 transition group-hover:bg-green-200"
                        >
                            <img
                                src="/images/customer.png"
                                alt="Pelanggan"
                                class="h-10 w-10 object-contain"
                            />
                        </div>

                        <h2 class="text-2xl font-bold text-gray-900">
                            User Pelanggan
                        </h2>

                        <p class="mt-3 text-gray-500">
                            Kelola data pelanggan yang menggunakan
                            layanan konsultasi finansial.
                        </p>

                        <div
                            class="mt-6 inline-flex items-center font-semibold text-green-600"
                        >
                            Kelola Pelanggan →
                        </div>
                    </Link>

                    <!-- Kelola Konsultasi -->
                    <Link
                        :href="route('admin.konsultasi.index')"
                        class="group rounded-3xl bg-white p-8 shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div
                            class="mb-6 flex h-20 w-20 items-center justify-center rounded-2xl bg-yellow-100 transition group-hover:bg-yellow-200"
                        >
                            <svg class="h-10 w-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>

                        <h2 class="text-2xl font-bold text-gray-900">
                            Manajemen Konsultasi
                        </h2>

                        <p class="mt-3 text-gray-500">
                            Kelola seluruh jadwal booking,
                            dan hapus riwayat pemesanan konsultasi.
                        </p>

                        <div
                            class="mt-6 inline-flex items-center font-semibold text-yellow-600"
                        >
                            Kelola Konsultasi →
                        </div>
                    </Link>

                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>