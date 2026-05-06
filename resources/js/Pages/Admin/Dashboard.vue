<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    stats: {
        type: Object,
        default: () => ({
            total_user: 0,
            total_konsultan: 0,
            total_admin: 0,
            konsultan_aktif: 0,
        }),
    },
});

const page = usePage();
const namaAdmin = computed(() => page.props.auth.user?.nama ?? 'Admin');
</script>

<template>
    <Head title="Dashboard Admin" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard Admin
            </h2>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <!-- Sambutan -->
                <div class="mb-6 rounded-lg bg-indigo-600 p-6 text-white shadow">
                    <h3 class="text-2xl font-bold">Selamat datang, {{ namaAdmin }}! 👋</h3>
                    <p class="mt-1 text-indigo-100">Panel kontrol administrator PAHAMUANG.</p>
                </div>

                <!-- Statistik Cards -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="rounded-lg bg-white p-6 shadow">
                        <div class="flex items-center">
                            <div class="rounded-full bg-blue-100 p-3">
                                <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total User</p>
                                <p class="text-2xl font-bold text-gray-900">{{ stats.total_user }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white p-6 shadow">
                        <div class="flex items-center">
                            <div class="rounded-full bg-green-100 p-3">
                                <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Konsultan</p>
                                <p class="text-2xl font-bold text-gray-900">{{ stats.total_konsultan }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white p-6 shadow">
                        <div class="flex items-center">
                            <div class="rounded-full bg-yellow-100 p-3">
                                <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Admin</p>
                                <p class="text-2xl font-bold text-gray-900">{{ stats.total_admin }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-lg bg-white p-6 shadow">
                        <div class="flex items-center">
                            <div class="rounded-full bg-emerald-100 p-3">
                                <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Konsultan Aktif</p>
                                <p class="text-2xl font-bold text-gray-900">{{ stats.konsultan_aktif }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Menu Cepat -->
                <div class="mt-8">
                    <h3 class="mb-4 text-lg font-semibold text-gray-700">Menu Cepat</h3>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <a :href="route('admin.users.index')"
                            class="flex items-center rounded-lg border border-gray-200 bg-white p-4 shadow-sm transition hover:border-indigo-400 hover:shadow">
                            <div class="rounded-lg bg-indigo-100 p-2">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="font-medium text-gray-900">Kelola User</p>
                                <p class="text-sm text-gray-500">Tambah, edit, dan hapus pengguna</p>
                            </div>
                        </a>

                        <a :href="route('profile.edit')"
                            class="flex items-center rounded-lg border border-gray-200 bg-white p-4 shadow-sm transition hover:border-indigo-400 hover:shadow">
                            <div class="rounded-lg bg-purple-100 p-2">
                                <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="font-medium text-gray-900">Profil Saya</p>
                                <p class="text-sm text-gray-500">Edit informasi akun admin</p>
                            </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>