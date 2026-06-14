<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

const props = defineProps({
    users: Array,
});

/*
|--------------------------------------------------------------------------
| SEARCH
|--------------------------------------------------------------------------
*/
const search = ref('');

const filteredUsers = computed(() => {
    return props.users.filter((user) => {
        const query = search.value.toLowerCase();
    return (
            user.nama
                .toLowerCase()
                .includes(query) ||

            user.email
                .toLowerCase()
                .includes(query) ||

            (user.no_telepon ?? '')
                .toLowerCase()
                .includes(query) ||

            roleLabel(user.role)
                .toLowerCase()
                .includes(query)
        );
    });
});

/*
|--------------------------------------------------------------------------
| FORM
|--------------------------------------------------------------------------
*/
const form = useForm({
    nama: '',
    email: '',
    password: '',
    role: '3',
    no_telepon: '',
});

const submit = () => {
    form.post(route('admin.users.store'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
    });
};

const deleteUser = (id) => {
    if (confirm('Yakin ingin menghapus user ini?')) {
        form.delete(route('admin.users.destroy', id));
    }
};

/*
|--------------------------------------------------------------------------
| ROLE LABEL
|--------------------------------------------------------------------------
*/
const roleLabel = (role) => {
    if (role == 1) return 'Admin';
    if (role == 2) return 'Konsultan';
    return 'User';
};
</script>

<template>
    <Head title="Kelola Semua User" />

    <AuthenticatedLayout>

        <div class="min-h-screen bg-gray-50 py-8">

            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

                <!-- Header -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900">
                        Manajemen Semua User
                    </h1>

                    <p class="mt-2 text-gray-500">
                        Tambah dan kelola semua akun pengguna PAHAMUANG
                    </p>
                </div>

                <!-- Search + Button -->
                <div class="mb-6 rounded-2xl bg-white p-5 shadow-sm">

                    <div
                        class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between"
                    >

                        <!-- Search -->
                        <div class="relative w-full md:w-96">

                            <input
                                v-model="search"
                                type="text"
                                placeholder="Cari user berdasarkan nama atau email..."
                                class="w-full rounded-xl border border-gray-200 py-3 pl-11 pr-4 text-sm transition focus:border-blue-500 focus:ring-blue-500"
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

                        <!-- Button -->
                        <Link
                            :href="route('admin.users.create')"
                            class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700"
                        >

                            <svg
                                class="mr-2 h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 4v16m8-8H4"
                                />
                            </svg>

                            Tambah User
                        </Link>

                    </div>
                </div>

                <!-- Table -->
                <div class="overflow-hidden rounded-3xl bg-white shadow-sm">

                    <div class="overflow-x-auto">

                        <table class="min-w-full text-sm text-gray-700">

                            <!-- Table Head -->
                            <thead class="bg-blue-600 text-white">
                                <tr>
                                    <th class="px-6 py-4 text-left">ID</th>
                                    <th class="px-6 py-4 text-left">Nama</th>
                                    <th class="px-6 py-4 text-left">Email</th>
                                    <th class="px-6 py-4 text-left">Role</th>
                                    <th class="px-6 py-4 text-left">Status / Info</th>
                                    <th class="px-6 py-4 text-left">Telepon</th>
                                    <th class="px-6 py-4 text-left">Created</th>
                                    <th class="px-6 py-4 text-left">Updated</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>

                            <!-- Table Body -->
                            <tbody>

                                <tr
                                    v-for="(user, index) in filteredUsers"
                                    :key="user.id"
                                    class="border-b transition hover:bg-gray-50"
                                >
                                    <!-- ID -->
                                    <td class="px-6 py-4">
                                        {{ index + 1 }}
                                    </td>

                                    <!-- Nama -->
                                    <td class="px-6 py-4 font-semibold text-gray-900">
                                        {{ user.nama }}
                                    </td>

                                    <!-- Email -->
                                    <td class="px-6 py-4">
                                        {{ user.email }}
                                    </td>

                                    <!-- Role -->
                                    <td class="px-6 py-4">
                                        <span
                                            class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700"
                                        >
                                            {{ roleLabel(user.role) }}
                                        </span>
                                    </td>

                                    <!-- Status / Info -->
                                    <td class="px-6 py-4">
                                        <template v-if="user.role == 2">
                                            <span
                                                v-if="user.is_available"
                                                class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700"
                                            >
                                                Aktif
                                            </span>
                                            <span
                                                v-else
                                                class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700"
                                            >
                                                Nonaktif
                                            </span>
                                        </template>
                                        <template v-else-if="user.role == 3">
                                            <span class="text-xs text-gray-500 font-semibold">
                                                Daftar: {{ user.created_at ? new Date(user.created_at).toLocaleDateString('id-ID') : '-' }}
                                            </span>
                                        </template>
                                        <template v-else>
                                            <span class="text-xs text-gray-400 font-semibold">
                                                Akses Utama
                                            </span>
                                        </template>
                                    </td>

                                    <!-- Telepon -->
                                    <td class="px-6 py-4">
                                        {{ user.no_telepon ?? '-' }}
                                    </td>

                                    <!-- Created -->
                                    <td class="px-6 py-4">
                                        {{ user.created_at }}
                                    </td>

                                    <!-- Updated -->
                                    <td class="px-6 py-4">
                                        {{ user.updated_at }}
                                    </td>

                                    <!-- Action -->
                                    <td class="px-6 py-4 text-center">

                                        <div class="flex items-center justify-center gap-2">

                                            <!-- Edit -->
                                            <Link
                                                :href="route('admin.users.edit', user.id)"
                                                class="rounded-xl bg-yellow-500 px-4 py-2 text-xs font-semibold text-white transition hover:bg-yellow-600"
                                            >
                                                Edit
                                            </Link>

                                            <!-- Delete -->
                                            <button
                                                @click="deleteUser(user.id)"
                                                class="rounded-xl bg-red-500 px-4 py-2 text-xs font-semibold text-white transition hover:bg-red-600"
                                            >
                                                Hapus
                                            </button>

                                        </div>

                                    </td>
                                </tr>

                                <!-- Empty -->
                                <tr v-if="filteredUsers.length === 0">

                                    <td
                                        colspan="10"
                                        class="px-6 py-10 text-center text-gray-400"
                                    >
                                        User tidak ditemukan
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