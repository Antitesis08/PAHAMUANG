<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    konsultans: {
        type: Array,
        default: () => [],
    },
});

const search = ref('');

const filteredKonsultans = computed(() => {
    return props.konsultans.filter((k) => {
        const query = search.value.toLowerCase();
        return (
            k.nama?.toLowerCase().includes(query) ||
            k.email?.toLowerCase().includes(query) ||
            (k.no_telepon ?? '').toLowerCase().includes(query)
        );
    });
});

const form = useForm();

const deleteKonsultan = (id) => {
    if (!confirm('Yakin ingin menghapus konsultan ini?')) {
        return;
    }

    form.delete(route('admin.users.destroy', id));
};
</script>

<template>
    <Head title="Manajemen Konsultan" />

    <AuthenticatedLayout>

        <template #header>
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    Manajemen Data Konsultan
                </h2>

                <p class="mt-1 text-sm text-gray-500">
                    Kelola pakar keuangan bersertifikat di platform PAHAMUANG
                </p>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <!-- Search + Button -->
                <div class="mb-6 rounded-2xl bg-white p-5 shadow-sm">

                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                        <!-- Search -->
                        <div class="relative w-full md:w-80">
                            <input
                                v-model="search"
                                type="text"
                                placeholder="Cari konsultan berdasarkan nama, email, atau telepon..."
                                class="w-full rounded-xl border border-gray-200 py-3 pl-11 pr-4 text-sm focus:border-emerald-500 focus:ring-emerald-500"
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
                            :href="route('admin.users.create') + '?role=2'"
                            class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                        >
                            Tambah Konsultan
                        </Link>

                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-hidden rounded-2xl bg-white shadow-sm">

                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-100">

                            <!-- Head -->
                            <thead class="bg-gray-50">
                                <tr class="text-left text-xs uppercase tracking-wider text-gray-500">

                                    <th class="px-6 py-4">ID</th>
                                    <th class="px-6 py-4">Nama</th>
                                    <th class="px-6 py-4">Email</th>
                                    <th class="px-6 py-4">Spesialisasi</th>
                                    <th class="px-6 py-4">Telepon</th>
                                    <th class="px-6 py-4">Rating</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>

                                </tr>
                            </thead>

                            <!-- Body -->
                            <tbody class="divide-y divide-gray-100 bg-white">

                                <tr
                                    v-for="konsultan in filteredKonsultans"
                                    :key="konsultan.id"
                                    class="transition hover:bg-gray-50"
                                >

                                    <!-- ID -->
                                    <td class="px-6 py-5 text-sm font-medium text-gray-700">
                                        {{ konsultan.id }}
                                    </td>

                                    <!-- Nama -->
                                    <td class="px-6 py-5">
                                        <div class="flex items-center">

                                            <!-- Foto -->
                                            <img
                                                :src="
                                                    konsultan.foto
                                                        ? '/storage/' + konsultan.foto
                                                        : 'https://ui-avatars.com/api/?name=' + konsultan.nama
                                                "
                                                class="h-12 w-12 rounded-full border-2 border-gray-100 object-cover"
                                            />

                                            <div class="ml-4">
                                                <p class="font-semibold text-gray-900">
                                                    {{ konsultan.nama }}
                                                </p>

                                                <p class="text-sm text-gray-500">
                                                    Bergabung
                                                    {{
                                                        new Date(konsultan.created_at)
                                                            .toLocaleDateString('id-ID')
                                                    }}
                                                </p>
                                            </div>

                                        </div>
                                    </td>

                                    <!-- Email -->
                                    <td class="px-6 py-5 text-sm text-gray-600">
                                        {{ konsultan.email }}
                                    </td>

                                    <!-- Spesialisasi -->
                                    <td class="px-6 py-5 text-sm text-gray-700">
                                        {{ konsultan.spesialisasi ?? '-' }}
                                    </td>

                                    <!-- Telepon -->
                                    <td class="px-6 py-5 text-sm text-gray-700">
                                        {{ konsultan.no_telepon ?? '-' }}
                                    </td>

                                    <!-- Rating -->
                                    <td class="px-6 py-5">
                                        <div class="flex items-center gap-1">

                                            <svg
                                                class="h-4 w-4 text-yellow-400"
                                                fill="currentColor"
                                                viewBox="0 0 20 20"
                                            >
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921
                                                    1.902 0l1.07 3.292a1
                                                    1 0 00.95.69h3.462c.969
                                                    0 1.371 1.24.588
                                                    1.81l-2.8 2.034a1 1 0
                                                    00-.364 1.118l1.07
                                                    3.292c.3.921-.755
                                                    1.688-1.54
                                                    1.118l-2.8-2.034a1 1 0
                                                    00-1.176 0l-2.8
                                                    2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1
                                                    1 0 00-.364-1.118L2.98
                                                    8.72c-.783-.57-.38-1.81.588-1.81h3.461a1
                                                    1 0 00.951-.69l1.07-3.292z"
                                                />
                                            </svg>

                                            <span class="text-sm font-medium text-gray-700">
                                                {{ konsultan.rating ?? '0.0' }}
                                            </span>

                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-5">

                                        <span
                                            :class="
                                                konsultan.is_available
                                                    ? 'bg-green-100 text-green-700'
                                                    : 'bg-red-100 text-red-700'
                                            "
                                            class="rounded-full px-3 py-1 text-xs font-semibold"
                                        >
                                            {{
                                                konsultan.is_available
                                                    ? 'Aktif'
                                                    : 'Nonaktif'
                                            }}
                                        </span>

                                    </td>

                                    <!-- Action -->
                                    <td class="px-6 py-5">

                                        <div class="flex items-center justify-center gap-3">

                                            <Link
                                                :href="route('admin.users.edit', konsultan.id)"
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
                                                @click="deleteKonsultan(konsultan.id)"
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

                                <tr v-if="filteredKonsultans.length === 0">
                                    <td colspan="8" class="px-6 py-10 text-center text-gray-400">
                                        Tidak ada konsultan yang sesuai.
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