<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    jadwals: Array,
});
</script>

<template>
    <Head title="Jadwal Konsultan" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-800">
                    Jadwal Konsultasi
                </h2>

                <div class="text-sm text-gray-500">
                    Total Jadwal: {{ jadwals.length }}
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <!-- Empty State -->
                <div
                    v-if="jadwals.length === 0"
                    class="rounded-2xl bg-white p-10 text-center shadow"
                >
                    <div class="mb-4 text-6xl">📅</div>

                    <h3 class="text-xl font-semibold text-gray-700">
                        Belum Ada Jadwal
                    </h3>

                    <p class="mt-2 text-gray-500">
                        Jadwal konsultasi akan muncul di sini.
                    </p>
                </div>

                <!-- List Jadwal -->
                <div
                    v-else
                    class="grid grid-cols-1 gap-6 lg:grid-cols-2"
                >
                    <div
                        v-for="jadwal in jadwals"
                        :key="jadwal.id"
                        class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-lg"
                    >
                        <!-- Header -->
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">
                                    {{ jadwal.nama_user }}
                                </h3>

                                <p class="text-sm text-gray-500">
                                    {{ jadwal.topik }}
                                </p>
                            </div>

                            <!-- Status -->
                            <span
                                :class="
                                    jadwal.status === 'selesai'
                                        ? 'bg-green-100 text-green-700'
                                        : jadwal.status === 'pending'
                                        ? 'bg-yellow-100 text-yellow-700'
                                        : 'bg-blue-100 text-blue-700'
                                "
                                class="rounded-full px-3 py-1 text-xs font-semibold capitalize"
                            >
                                {{ jadwal.status }}
                            </span>
                        </div>

                        <!-- Detail -->
                        <div class="mt-5 space-y-3">

                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100"
                                >
                                    📅
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">
                                        Tanggal
                                    </p>

                                    <p class="font-medium text-gray-800">
                                        {{ jadwal.tanggal }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-100"
                                >
                                    ⏰
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">
                                        Jam
                                    </p>

                                    <p class="font-medium text-gray-800">
                                        {{ jadwal.jam }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100"
                                >
                                    💬
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">
                                        Metode
                                    </p>

                                    <p class="font-medium text-gray-800">
                                        {{ jadwal.metode }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Action buttons removed: only schedule info shown -->
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>