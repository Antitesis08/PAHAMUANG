<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    pelanggan: {
        type: Array,
        default: () => [],
    },
});

const search = ref('');

const filteredPelanggan = computed(() => {
    return props.pelanggan.filter((user) => {
        const query = search.value.toLowerCase();
        return (
            user.nama?.toLowerCase().includes(query) ||
            user.email?.toLowerCase().includes(query) ||
            (user.no_telepon ?? '').toLowerCase().includes(query)
        );
    });
});

const form = useForm();

const deletePelanggan = (id) => {
    if (!confirm('Yakin ingin menghapus pelanggan ini?')) {
        return;
    }

    form.delete(route('admin.users.destroy', id));
};
</script>

<template>
    <Head title="Kelola Pelanggan" />

    <AuthenticatedLayout>

        <template #header>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Manajemen Data Pelanggan
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Kelola seluruh pengguna pelanggan aplikasi PAHAMUANG
                </p>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <!-- Search -->
                <div class="mb-6 rounded-2xl bg-white p-5 shadow-sm">

                    <div class="md:flex md:items-center md:justify-between">
                        <div class="relative w-full md:w-96">

                            <input
                                v-model="search"
                                type="text"
                                placeholder="Cari pelanggan berdasarkan nama, email, atau telepon..."
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

                        <Link
                            :href="route('admin.users.create') + '?role=3'"
                            class="mt-4 inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700 md:mt-0"
                        >
                            Tambah Pelanggan
                        </Link>
                    </div>

                </div>

                <!-- Table -->
                <div class="overflow-hidden rounded-2xl bg-white shadow-sm">

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-100">

                            <!-- Table Head -->
                            <thead class="bg-gray-50">

                                <tr class="text-left text-xs uppercase tracking-wider text-gray-500">

                                    <th class="px-6 py-4">ID User</th>
                                    <th class="px-6 py-4">Nama</th>
                                    <th class="px-6 py-4">Email</th>
                                    <th class="px-6 py-4">Telepon</th>
                                    <th class="px-6 py-4">Tanggal Daftar</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>

                                </tr>

                            </thead>

                            <!-- Table Body -->
                            <tbody class="divide-y divide-gray-100 bg-white">

                                <tr
                                    v-for="(user, index) in filteredPelanggan"
                                    :key="user.id"
                                    class="transition hover:bg-gray-50"
                                >

                                    <!-- ID -->
                                    <td class="px-6 py-5 text-sm font-medium text-gray-700">
                                        #{{ index + 1 }}
                                    </td>

                                    <!-- Nama -->
                                    <td class="px-6 py-5">

                                        <div class="flex items-center">

                                            <!-- Avatar -->
                                            <img
                                                :src="'https://ui-avatars.com/api/?name=' + user.nama"
                                                class="h-12 w-12 rounded-full border-2 border-gray-100 object-cover"
                                            />

                                            <div class="ml-4">

                                                <p class="font-semibold text-gray-900">
                                                    {{ user.nama }}
                                                </p>

                                                <p class="text-sm text-gray-500">
                                                    Pelanggan PAHAMUANG
                                                </p>

                                            </div>

                                        </div>

                                    </td>

                                    <!-- Email -->
                                    <td class="px-6 py-5 text-sm text-gray-600">
                                        {{ user.email }}
                                    </td>

                                    <!-- Telepon -->
                                    <td class="px-6 py-5 text-sm text-gray-700">
                                        {{ user.no_telepon ?? '-' }}
                                    </td>

                                    <!-- Tanggal Daftar -->
                                    <td class="px-6 py-5 text-sm text-gray-700">

                                        {{
                                            new Date(user.created_at)
                                                .toLocaleDateString('id-ID', {
                                                    day: 'numeric',
                                                    month: 'long',
                                                    year: 'numeric'
                                                })
                                        }}

                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-5">

                                        <span
                                            :class="
                                                user.email_verified_at
                                                    ? 'bg-green-100 text-green-700'
                                                    : 'bg-yellow-100 text-yellow-700'
                                            "
                                            class="rounded-full px-3 py-1 text-xs font-semibold"
                                        >
                                            {{
                                                user.email_verified_at
                                                    ? 'Aktif'
                                                    : 'Belum Verifikasi'
                                            }}
                                        </span>

                                    </td>

                                    <!-- Aksi -->
                                    <td class="px-6 py-5">

                                        <div class="flex items-center justify-center gap-3">

                                            <Link
                                                :href="route('admin.users.edit', user.id)"
                                                class="text-blue-500 transition hover:scale-110"
                                            >
                                                <svg
                                                    class="h-5 w-5"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5h2m-1
                                                        0v14m7-7H5"
                                                    />
                                                </svg>
                                            </Link>

                                            <button
                                                @click="deletePelanggan(user.id)"
                                                class="text-red-500 transition hover:scale-110"
                                            >
                                                <svg
                                                    class="h-5 w-5"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867
                                                        12.142A2 2 0
                                                        0116.138 21H7.862a2
                                                        2 0 01-1.995-1.858L5
                                                        7m5 4v6m4-6v6M9
                                                        7V4a1 1 0 011-1h4a1
                                                        1 0 011 1v3M4 7h16"
                                                    />
                                                </svg>
                                            </button>

                                        </div>

                                    </td>

                                </tr>

                                <tr v-if="filteredPelanggan.length === 0">
                                    <td colspan="7" class="px-6 py-10 text-center text-gray-400">
                                        Tidak ada pelanggan yang sesuai.
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