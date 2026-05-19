<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Portal Pakar Login" />

    <div
        class="min-h-screen bg-gradient-to-br from-blue-700 via-blue-800 to-indigo-900 flex items-center justify-center p-6"
    >
        <div
            class="w-full max-w-md bg-white rounded-3xl shadow-2xl p-8 relative overflow-hidden"
        >
            <!-- Blur Effect -->
            <div
                class="absolute -top-10 -right-10 w-40 h-40 bg-blue-200 rounded-full blur-3xl opacity-40"
            ></div>

            <!-- Back -->
            <Link
                href="/"
                class="text-sm text-blue-700 hover:text-blue-900 font-medium flex items-center gap-2 mb-6"
            >
                ← Kembali ke Beranda
            </Link>

<!-- Logo -->
<div class="flex justify-center mb-5">
    <div
        class="w-20 h-20 rounded-full bg-white flex items-center justify-center shadow-lg overflow-hidden border-4 border-blue-700"
    >
        <img
            src="/images/logo.png"
            alt="Logo"
            class="w-14 h-14 object-contain"
        />
    </div>
</div>

            <!-- Title -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800">
                    Portal
                </h1>
                <p class="text-gray-500 mt-2 text-sm">
                    Masuk untuk Login Akun PahamUang Anda
                </p>
            </div>

            <!-- Status -->
            <div
                v-if="status"
                class="mb-4 text-sm font-medium text-green-600 text-center"
            >
                {{ status }}
            </div>

            <!-- Form -->
            <form @submit.prevent="submit" class="space-y-5">
                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Email
                    </label>

                    <input
                        v-model="form.email"
                        type="email"
                        placeholder="pakar@email.com"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-600 transition"
                        required
                        autofocus
                    />

                    <p
                        v-if="form.errors.email"
                        class="text-red-500 text-sm mt-1"
                    >
                        {{ form.errors.email }}
                    </p>
                </div>

                <!-- Password -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Password
                    </label>

                    <input
                        v-model="form.password"
                        type="password"
                        placeholder="••••••••"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-600 transition"
                        required
                    />

                    <p
                        v-if="form.errors.password"
                        class="text-red-500 text-sm mt-1"
                    >
                        {{ form.errors.password }}
                    </p>
                </div>

                <!-- Remember -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2">
                        <input
                            type="checkbox"
                            v-model="form.remember"
                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                        />
                        <span class="text-sm text-gray-600">
                            Remember me
                        </span>
                    </label>

                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="text-sm text-blue-600 hover:underline"
                    >
                        Forgot Password?
                    </Link>
                </div>

                <!-- Button -->
                <button
                    type="submit"
                    :disabled="form.processing"
                    class="w-full bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 rounded-xl shadow-md hover:shadow-lg transition duration-300 disabled:opacity-50"
                >
                    Masuk ke Portal
                </button>
            </form>

            <!-- Footer -->
            <div class="mt-6 text-center text-sm text-gray-500">
                Gunakan Email dan Password Akun PahamUang
            </div>
        </div>
    </div>
</template>