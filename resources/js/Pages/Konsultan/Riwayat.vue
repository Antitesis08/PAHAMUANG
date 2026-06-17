<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    riwayat: Array,
});

const activeItem = ref(null);

const openModal = (item) => {
    activeItem.value = item;
};

const closeModal = () => {
    activeItem.value = null;
};
</script>

<template>
    <Head title="Riwayat Konsultasi" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <Link :href="route('konsultan.dashboard')" class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-800 font-medium mb-4">
                    ← Kembali ke Dashboard
                </Link>
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-800">
                        Riwayat Konsultasi
                    </h2>

                    <div class="text-sm text-gray-500">
                        Total Riwayat: {{ riwayat.length }}
                    </div>
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

                <!-- Riwayat Table -->
                <div v-else class="overflow-hidden rounded-3xl border border-gray-200 bg-white shadow-sm">
                    <table class="min-w-full divide-y divide-gray-200 text-left text-sm text-gray-700">
                        <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                            <tr>
                                <th class="px-6 py-4">No</th>
                                <th class="px-6 py-4">Klien</th>
                                <th class="px-6 py-4">Layanan</th>
                                <th class="px-6 py-4">Tanggal</th>
                                <th class="px-6 py-4">Jam</th>
                                <th class="px-6 py-4">Pembayaran</th>
                                <th class="px-6 py-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <tr v-for="(item, index) in riwayat" :key="item.id" class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ index + 1 }}</td>
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-gray-900">{{ item.nama_user }}</div>
                                    <div class="text-gray-500 text-xs">{{ item.topik }}</div>
                                </td>
                                <td class="px-6 py-4">{{ item.layanan }}</td>
                                <td class="px-6 py-4">{{ item.tanggal }}</td>
                                <td class="px-6 py-4">{{ item.jam }}</td>
                                <td class="px-6 py-4">{{ item.pembayaran }}</td>
                                <td class="px-6 py-4">
                                    <button
                                        @click="openModal(item)"
                                        class="rounded-xl bg-blue-600 px-4 py-2 text-xs font-semibold text-white transition hover:bg-blue-700"
                                    >
                                        Detail
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Detail Modal -->
                <div v-if="activeItem" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm">
                    <div class="bg-white rounded-3xl max-w-lg w-full p-8 shadow-2xl border border-gray-100 transform transition-all duration-300">
                        <div class="flex justify-between items-start mb-6">
                            <h3 class="text-2xl font-bold text-gray-900">Detail Riwayat Sesi</h3>
                            <button @click="closeModal" class="text-gray-400 hover:text-gray-600 text-2xl font-semibold leading-none">&times;</button>
                        </div>
                        
                        <div class="space-y-6">
                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Nama Klien</p>
                                <p class="text-lg font-bold text-gray-800 mt-1">{{ activeItem.nama_user }}</p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Jadwal Sesi</p>
                                <p class="text-sm font-medium text-gray-700 mt-1">{{ activeItem.tanggal }} pukul {{ activeItem.jam }} WIB</p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Keluhan / Catatan</p>
                                <p class="text-sm text-gray-600 mt-1 bg-gray-50 p-4 rounded-2xl border border-gray-100 whitespace-pre-line leading-relaxed">
                                    {{ activeItem.catatan || '-' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider">Status & Pembayaran</p>
                                <div class="flex items-center gap-3 mt-2">
                                    <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">Selesai</span>
                                    <span class="text-sm font-semibold text-[#0B56D5] bg-blue-50 px-3 py-1 rounded-full">{{ activeItem.pembayaran }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                            <button @click="closeModal" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold px-6 py-3 rounded-xl text-sm transition">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>