<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = useForm({
    email: '',
    password: '',
    nama: '',
    no_telepon: '',
    tarif: 0,
});

const submit = () => {
    form.post(route('admin.konsultan.store'));
};
</script>

<template>
    <Head title="Tambah Konsultan" />

    <AuthenticatedLayout>
        <template #header>
            <div>
                <Link :href="route('admin.dashboard')" class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-800 font-medium mb-4">
                    ← Kembali ke Dashboard
                </Link>

                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-gray-800">Tambah Konsultan</h2>
                </div>
            </div>
        </template>

        <div class="py-8">
            <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
                <div class="bg-white rounded-2xl p-8 shadow-sm">
                    <p class="text-gray-600 mb-6">Masukkan akun (email) dan password untuk konsultan. Data profil (nama, telepon) opsional dan dapat diisi oleh konsultan sendiri nanti.</p>

                    <div class="space-y-4">
                        <div>
                            <label class="block font-semibold mb-2">Email</label>
                            <input v-model="form.email" type="email" class="w-full border border-gray-300 rounded-xl p-3" />
                        </div>

                        <div>
                            <label class="block font-semibold mb-2">Password</label>
                            <input v-model="form.password" type="password" class="w-full border border-gray-300 rounded-xl p-3" />
                        </div>

                        <div>
                            <label class="block font-semibold mb-2">Nama (opsional)</label>
                            <input v-model="form.nama" type="text" class="w-full border border-gray-300 rounded-xl p-3" />
                        </div>

                        <div>
                            <label class="block font-semibold mb-2">No. Telepon (opsional)</label>
                            <input v-model="form.no_telepon" type="text" class="w-full border border-gray-300 rounded-xl p-3" />
                        </div>

                        <div>
                            <label class="block font-semibold mb-2">Tarif per Jam / Rp (opsional)</label>
                            <input v-model="form.tarif" type="number" min="0" class="w-full border border-gray-300 rounded-xl p-3" placeholder="Contoh: 500000" />
                            <p class="text-xs text-gray-400 mt-1">Biarkan 0 jika belum ditentukan. Konsultan dapat mengisi sendiri nanti.</p>
                        </div>

                        <div class="mt-6 flex gap-3">
                            <button @click.prevent="submit" :disabled="form.processing" class="btn-primary">{{ form.processing ? 'Menyimpan...' : 'Tambah Konsultan' }}</button>
                            <a :href="route('admin.konsultan.index')" class="inline-flex items-center rounded-md border border-gray-300 bg-bg-50 px-4 py-2 text-sm font-semibold text-gray-700">Batal</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
