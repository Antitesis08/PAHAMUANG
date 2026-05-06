<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    konsultan: {
        type: Object,
        required: true,
    },
});

// Toggle status ketersediaan
const isAvailable = ref(props.konsultan.is_available);

const statusForm = useForm({
    is_available: props.konsultan.is_available,
});

const toggleStatus = () => {
    statusForm.is_available = !isAvailable.value;
    statusForm.patch(route('konsultan.status'), {
        onSuccess: () => {
            isAvailable.value = statusForm.is_available;
        },
    });
};
</script>

<template>
    <Head title="Dashboard Konsultan" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard Konsultan
            </h2>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <!-- Sambutan + Status -->
                <div class="mb-6 flex flex-col gap-4 rounded-lg bg-white p-6 shadow sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-800">
                            Selamat datang, {{ konsultan.nama }}! 👋
                        </h3>
                        <p class="mt-1 text-gray-500">{{ konsultan.email }}</p>
                        <p v-if="konsultan.no_telepon" class="text-sm text-gray-400">
                            📱 {{ konsultan.no_telepon }}
                        </p>
                    </div>

                    <!-- Toggle Status -->
                    <div class="flex items-center gap-3">
                        <span class="text-sm font-medium text-gray-600">Status:</span>
                        <button
                            @click="toggleStatus"
                            :disabled="statusForm.processing"
                            :class="isAvailable
                                ? 'bg-green-500 hover:bg-green-600'
                                : 'bg-gray-400 hover:bg-gray-500'"
                            class="relative inline-flex h-10 items-center rounded-full px-4 text-sm font-semibold text-white transition disabled:opacity-50">
                            <span class="mr-2 h-2 w-2 rounded-full"
                                :class="isAvailable ? 'bg-white' : 'bg-gray-200'"></span>
                            {{ isAvailable ? 'Tersedia' : 'Tidak Tersedia' }}
                        </button>
                    </div>
                </div>

                <!-- Quick Access Cards -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <a :href="route('konsultan.jadwal')"
                        class="flex items-center rounded-lg border border-gray-200 bg-white p-5 shadow-sm transition hover:border-blue-400 hover:shadow">
                        <div class="rounded-lg bg-blue-100 p-3">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold text-gray-800">Jadwal Saya</p>
                            <p class="text-sm text-gray-500">Lihat jadwal konsultasi</p>
                        </div>
                    </a>

                    <a :href="route('konsultan.riwayat')"
                        class="flex items-center rounded-lg border border-gray-200 bg-white p-5 shadow-sm transition hover:border-green-400 hover:shadow">
                        <div class="rounded-lg bg-green-100 p-3">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold text-gray-800">Riwayat</p>
                            <p class="text-sm text-gray-500">Konsultasi selesai</p>
                        </div>
                    </a>

                    <a :href="route('profile.edit')"
                        class="flex items-center rounded-lg border border-gray-200 bg-white p-5 shadow-sm transition hover:border-purple-400 hover:shadow">
                        <div class="rounded-lg bg-purple-100 p-3">
                            <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="font-semibold text-gray-800">Profil Saya</p>
                            <p class="text-sm text-gray-500">Edit informasi akun</p>
                        </div>
                    </a>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>