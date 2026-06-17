<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    konsultasis: {
        type: Array,
        default: () => [],
    },
});

const search = ref('');

const filteredKonsultasi = computed(() => {
    return props.konsultasis.filter((item) => {
        const query = search.value.toLowerCase();
        return (
            item.user_nama?.toLowerCase().includes(query) ||
            item.user_email?.toLowerCase().includes(query) ||
            item.konsultan_nama?.toLowerCase().includes(query) ||
            item.layanan_nama?.toLowerCase().includes(query) ||
            item.status?.toLowerCase().includes(query)
        );
    });
});

const form = useForm();

const deleteKonsultasi = (id) => {
    if (!confirm('Yakin ingin menghapus riwayat jadwal konsultasi ini?')) {
        return;
    }
    form.delete(route('admin.konsultasi.destroy', id), {
        preserveScroll: true
    });
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
    <Head title="Kelola Jadwal Konsultasi" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <Link :href="route('admin.dashboard')" class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-800 font-medium mb-4">
                    ← Kembali ke Dashboard
                </Link>

                <h2 class="text-2xl font-bold text-gray-900">
                    Manajemen Jadwal Konsultasi
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola seluruh riwayat booking dan konsultasi aplikasi PAHAMUANG
                </p>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Search -->
                <div class="mb-6 rounded-2xl bg-white p-5 shadow-sm">
                    <div class="relative w-full md:w-96">
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Cari berdasarkan nama klien, konsultan, layanan..."
                            class="w-full rounded-xl border border-gray-200 py-3 pl-11 pr-4 text-sm focus:border-blue-500 focus:ring-blue-500"
                        />
                        <svg
                            class="absolute left-4 top-3.5 h-5 w-5 text-gray-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M21 21l-4.35-4.35m1.85-5.15a7 7 0 11-14 0 7 7 0 0114 0z"
                            />
                        </svg>
                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-hidden rounded-2xl bg-white shadow-sm">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-gray-50">
                                <tr class="text-left text-xs uppercase tracking-wider text-gray-500">
                                    <th class="px-6 py-4">ID</th>
                                    <th class="px-6 py-4">Klien / User</th>
                                    <th class="px-6 py-4">Konsultan</th>
                                    <th class="px-6 py-4">Layanan</th>
                                    <th class="px-6 py-4">Jadwal</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4">Pembayaran</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-100 bg-white">
                                <tr
                                    v-for="(item, index) in filteredKonsultasi"
                                    :key="item.id"
                                    class="transition hover:bg-gray-50 text-sm"
                                >
                                    <td class="px-6 py-5 text-gray-700">
                                        #{{ index + 1 }}
                                    </td>
                                    <td class="px-6 py-5">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ item.user_nama }}</p>
                                            <p class="text-xs text-gray-500">{{ item.user_email }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-gray-700 font-medium">
                                        {{ item.konsultan_nama }}
                                    </td>
                                    <td class="px-6 py-5 text-gray-600">
                                        {{ item.layanan_nama }}
                                    </td>
                                    <td class="px-6 py-5 text-gray-700">
                                        {{ item.jadwal }}
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            :class="{
                                                'bg-yellow-100 text-yellow-800': item.status === 'pending',
                                                'bg-green-100 text-green-800': item.status === 'aktif',
                                                'bg-blue-100 text-blue-800': item.status === 'selesai',
                                                'bg-red-100 text-red-800': item.status === 'ditolak'
                                            }"
                                            class="rounded-full px-2.5 py-1 text-xs font-semibold uppercase"
                                        >
                                            {{ item.status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ formatPrice(item.jumlah_bayar) }}</p>
                                            <p
                                                :class="item.status_pembayaran === 'lunas' ? 'text-green-600' : 'text-yellow-600'"
                                                class="text-xs capitalize font-medium"
                                            >
                                                {{ item.status_pembayaran }}
                                            </p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-center">
                                        <button
                                            @click="deleteKonsultasi(item.id)"
                                            class="text-red-500 hover:text-red-700 transition transform hover:scale-110"
                                        >
                                            <svg
                                                class="h-5 w-5 mx-auto"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3M4 7h16"
                                                />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>

                                <tr v-if="filteredKonsultasi.length === 0">
                                    <td colspan="8" class="px-6 py-10 text-center text-gray-400">
                                        Tidak ada data jadwal konsultasi.
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
