<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';

const props = defineProps({
    user: Object,
});

const form = useForm({
    nama: props.user.nama,
    email: props.user.email,
    role: props.user.role.toString(),
    no_telepon: props.user.no_telepon,
});

const submit = () => {
    form.put(route('admin.users.update', props.user.id));
};
</script>

<template>
    <Head title="Edit User" />

    <AuthenticatedLayout>

        <div class="min-h-screen bg-gray-50 py-8">

            <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">

                <!-- Header -->
                <div class="mb-8 flex items-center justify-between">

                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">
                            Edit User
                        </h1>

                        <p class="mt-2 text-gray-500">
                            Perbarui informasi user pada sistem PAHAMUANG
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
                                    Nama
                                </label>

                                <input
                                    v-model="form.nama"
                                    type="text"
                                    class="w-full rounded-xl border-gray-300"
                                />
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700">
                                    Email
                                </label>

                                <input
                                    v-model="form.email"
                                    type="email"
                                    class="w-full rounded-xl border-gray-300"
                                />
                            </div>

                            <!-- Role -->
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-gray-700">
                                    Role
                                </label>

                                <select
                                    v-model="form.role"
                                    class="w-full rounded-xl border-gray-300"
                                >
                                    <option value="1">Admin</option>
                                    <option value="2">Konsultan</option>
                                    <option value="3">User</option>
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
                                    class="w-full rounded-xl border-gray-300"
                                />
                            </div>

                        </div>

                        <!-- Button -->
                        <div class="mt-8 flex justify-end">

                            <button
                                type="submit"
                                class="rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700"
                            >
                                Simpan Perubahan
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </AuthenticatedLayout>
</template>