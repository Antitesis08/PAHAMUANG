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

                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">
                        Manajemen Pengguna
                    </h1>

                    <p class="mt-2 text-gray-500">
                        Pilih kategori pengguna yang ingin dikelola
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                    <!-- Konsultan -->
                    <Link
                        :href="route('admin.konsultan.index')"
                        class="rounded-3xl bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div
                            class="mb-6 flex h-20 w-20 items-center justify-center rounded-2xl bg-blue-100"
                        >
                            <img
                                src="/images/icons/konsultan.png"
                                class="h-10 w-10 object-contain"
                            />
                        </div>

                        <h2 class="text-2xl font-bold text-gray-900">
                            Manajemen Konsultan
                        </h2>

                        <p class="mt-3 text-gray-500">
                            Kelola seluruh data konsultan aplikasi.
                        </p>
                    </Link>

                    <!-- Pelanggan -->
                    <Link
                        :href="route('admin.pelanggan.index')"
                        class="rounded-3xl bg-white p-8 shadow-sm transition hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div
                            class="mb-6 flex h-20 w-20 items-center justify-center rounded-2xl bg-green-100"
                        >
                            <img
                                src="/images/icons/customer.png"
                                class="h-10 w-10 object-contain"
                            />
                        </div>

                        <h2 class="text-2xl font-bold text-gray-900">
                            User Pelanggan
                        </h2>

                        <p class="mt-3 text-gray-500">
                            Kelola seluruh user pelanggan aplikasi.
                        </p>
                    </Link>

                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>