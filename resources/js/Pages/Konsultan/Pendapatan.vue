<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    konsultan: Object,
    rincian: Array,
    total_pendapatan: Number,
    total_sesi: Number,
});

const formatRupiah = (value) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
    }).format(value);
};
</script>

<template>
    <Head title="Rincian Pendapatan" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <Link
                    :href="route('konsultan.dashboard')"
                    class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-800 font-medium mb-4"
                >
                    ← Kembali ke Dashboard
                </Link>

                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-800">
                        Rincian Pendapatan
                    </h2>

                    <div class="text-sm text-gray-500">
                        Total Transaksi: {{ rincian.length }}
                    </div>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <!-- Summary Cards -->
                <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <!-- Card Hijau: Total Pendapatan -->
                    <div class="rounded-2xl border border-green-200 bg-green-50 p-6 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-green-100">
                                <svg class="h-7 w-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-green-700">Total Pendapatan</p>
                                <p class="text-3xl font-bold text-green-800">{{ formatRupiah(total_pendapatan) }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card Biru: Total Sesi Selesai -->
                    <div class="rounded-2xl border border-blue-200 bg-blue-50 p-6 shadow-sm">
                        <div class="flex items-center gap-4">
                            <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-blue-100">
                                <svg class="h-7 w-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-blue-700">Total Sesi Selesai</p>
                                <p class="text-3xl font-bold text-blue-800">{{ total_sesi }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div
                    v-if="rincian.length === 0"
                    class="rounded-2xl bg-white p-10 text-center shadow"
                >
                    <div class="mb-4 text-6xl">💰</div>

                    <h3 class="text-xl font-semibold text-gray-700">
                        Belum Ada Pendapatan
                    </h3>

                    <p class="mt-2 text-gray-500">
                        Belum ada pendapatan tercatat.
                    </p>
                </div>

                <!-- Tabel Rincian -->
                <div v-else class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm text-gray-700">
                            <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                                <tr>
                                    <th class="px-6 py-4">No</th>
                                    <th class="px-6 py-4">Tanggal Bayar</th>
                                    <th class="px-6 py-4">Kode Transaksi</th>
                                    <th class="px-6 py-4">Nama Klien</th>
                                    <th class="px-6 py-4">No. Telepon</th>
                                    <th class="px-6 py-4">Jadwal Konsultasi</th>
                                    <th class="px-6 py-4">Jumlah</th>
                                    <th class="px-6 py-4">Metode</th>
                                    <th class="px-6 py-4">Rating</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr v-for="(item, index) in rincian" :key="item.id" class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ index + 1 }}</td>
                                    <td class="px-6 py-4">{{ item.tanggal_bayar }}</td>
                                    <td class="px-6 py-4">
                                        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-700">
                                            {{ item.kode_transaksi }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-gray-900">{{ item.nama_user }}</div>
                                    </td>
                                    <td class="px-6 py-4">{{ item.no_telepon_user }}</td>
                                    <td class="px-6 py-4">{{ item.jadwal }}</td>
                                    <td class="px-6 py-4 font-semibold text-green-700">{{ item.jumlah_formatted }}</td>
                                    <td class="px-6 py-4">
                                        <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700 capitalize">
                                            {{ item.metode ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div v-if="item.rating" class="flex items-center gap-1">
                                            <svg class="h-4 w-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <span class="text-sm font-medium text-gray-700">{{ item.rating }}</span>
                                        </div>
                                        <span v-else class="text-xs text-gray-400">-</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
