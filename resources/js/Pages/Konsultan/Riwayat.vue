<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    riwayat: Array,
});
</script>

<template>
    <Head title="Riwayat Konsultasi" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-800">
                    Riwayat Konsultasi
                </h2>

                <div class="text-sm text-gray-500">
                    Total Riwayat: {{ riwayat.length }}
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <!-- Empty State -->
                <div
                    v-if="riwayat.length === 0"
                    class="rounded-2xl bg-white p-10 text-center shadow"
                >
                    <div class="mb-4 text-6xl">📂</div>

                    <h3 class="text-xl font-semibold text-gray-700">
                        Belum Ada Riwayat
                    </h3>

                    <p class="mt-2 text-gray-500">
                        Riwayat konsultasi selesai akan muncul di sini.
                    </p>
                </div>

                <!-- Riwayat List -->
                <div
                    v-else
                    class="grid grid-cols-1 gap-6 lg:grid-cols-2"
                >
                    <div
                        v-for="item in riwayat"
                        :key="item.id"
                        class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-lg"
                    >
                        <!-- Header -->
                        <div class="flex items-start justify-between">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">
                                    {{ item.nama_user }}
                                </h3>

                                <p class="text-sm text-gray-500">
                                    {{ item.topik }}
                                </p>
                            </div>

                            <span
                                class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700"
                            >
                                Selesai
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
                                        {{ item.tanggal }}
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
                                        {{ item.jam }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <div
                                    class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100"
                                >
                                    💳
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500">
                                        Pembayaran
                                    </p>

                                    <p class="font-medium text-green-600">
                                        {{ item.pembayaran }}
                                    </p>
                                </div>
                            </div>

                        </div>

                        <!-- Footer -->
                        <div
                            class="mt-6 flex items-center justify-between border-t pt-4"
                        >
                            <div>
                                <p class="text-xs text-gray-400">
                                    Konsultasi selesai
                                </p>
                            </div>

                            <button
                                class="rounded-xl bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700"
                            >
                                Detail
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>