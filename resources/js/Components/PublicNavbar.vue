<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

            <div class="flex items-center gap-2">

                <div class="w-8 h-8 bg-indigo-600 rounded-md flex items-center justify-center text-white font-bold">
                    P
                </div>

                <h1 class="font-bold text-xl text-indigo-700">
                    PAHAMUANG
                </h1>

            </div>

            <div class="flex items-center gap-6 text-sm text-gray-700">

                <Link
                    :href="route('dashboard')"
                    class="hover:text-indigo-600 transition"
                >
                    Beranda
                </Link>

                <Link
                    :href="route('public.konsultan')"
                    class="hover:text-indigo-600 transition"
                >
                    Konsultan
                </Link>

                <a
                    href="#"
                    class="hover:text-indigo-600 transition"
                >
                    About us
                </a>

                <Link
                    :href="route('login')"
                    class="hover:text-indigo-600 transition"
                >
                    Admin/konsultan
                </Link>

            </div>

        </div>
    </nav>
</template>