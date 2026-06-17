<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const defaultRole = typeof window !== 'undefined'
    ? new URLSearchParams(window.location.search).get('role') || '2'
    : '2';

const form = useForm({
    nama: '',
    email: '',
    password: '',
    role: defaultRole,
    no_telepon: '',
});

const submit = () => {
    form.post(route('admin.users.store'));
};
</script>

<template>
    <Head title="Tambah User" />

    <AuthenticatedLayout>

        <div class="min-h-screen bg-gray-50 py-8">

            <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

                <!-- Header -->
                <div class="mb-8 flex items-center justify-between">

                    <div>
                        <Link :href="route('admin.dashboard')" class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-800 font-medium mb-4">
                            ← Kembali ke Dashboard
                        </Link>

                        <h1 class="text-3xl font-bold text-gray-900">
                            Tambah User
                        </h1>

                        <p class="mt-2 text-gray-500">
                            Tambahkan akun baru ke sistem PAHAMUANG
                        </p>
                    </div>

                    <Link
                        :href="route('admin.users.index')"
                        class="rounded-xl bg-gray-200 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-300"
                    >
                        Kembali
                    </Link>

                </div>

                <!-- Form -->
                <div class="rounded-3xl bg-white p-8 shadow-sm">

                    <form @submit.prevent="submit">

                        <div class="grid grid-cols-1 gap-6">

                            <!-- Nama -->
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700">
                                    Nama Lengkap
                                </label>

                                <input
                                    v-model="form.nama"
                                    type="text"
                                    placeholder="Masukkan nama lengkap"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                                />

                                <p
                                    v-if="form.errors.nama"
                                    class="mt-2 text-sm text-red-500"
                                >
                                    {{ form.errors.nama }}
                                </p>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700">
                                    Email
                                </label>

                                <input
                                    v-model="form.email"
                                    type="email"
                                    placeholder="Masukkan email"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                                />

                                <p
                                    v-if="form.errors.email"
                                    class="mt-2 text-sm text-red-500"
                                >
                                    {{ form.errors.email }}
                                </p>
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700">
                                    Password
                                </label>

                                <input
                                    v-model="form.password"
                                    type="password"
                                    placeholder="Masukkan password"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                                />

                                <p
                                    v-if="form.errors.password"
                                    class="mt-2 text-sm text-red-500"
                                >
                                    {{ form.errors.password }}
                                </p>
                            </div>

                            <!-- Role -->
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700">
                                    Role
                                </label>

                                <select
                                    v-model="form.role"
                                    class="w-full rounded-xl border border-gray-200 px-4 py-3 focus:border-blue-500 focus:ring-blue-500"
                                >
                                    <option value="1">Admin</option>
                                    <option value="2">Konsultan</option>
                                    <option value="3">User / Pelanggan</option>
                                </select>
                            </div>

                            <!-- Telepon -->
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700">
                                    Nomor Telepon
                                </label>

                                <input
                                    v-model="form.no_telepon"
                                    type="text"
                                    placeholder="Masukkan nomor telepon"
                                    class="w-full rounded-xl border-gray-300"
                                />
                            </div>

                        </div>

                        <!-- Button -->
                        <div class="mt-8 flex justify-end">

                            <button
                                type="submit"
                                :disabled="form.processing"
                                class="rounded-xl bg-blue-600 px-6 py-3 font-semibold text-white transition hover:bg-blue-700 disabled:opacity-50"
                            >
                                Simpan User
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </AuthenticatedLayout>
</template>