<script setup>
import { Link } from '@inertiajs/vue3';
import BrandLogo from '@/Components/BrandLogo.vue';
</script>

<template>
    <nav class="bg-bg-50 border-b border-gray-100 sticky top-0 z-50 shadow-sm">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

            <div class="flex items-center gap-2">

                <Link :href="route('dashboard')" class="inline-block">
                    <BrandLogo />
                </Link>

            </div>

            <div class="flex items-center gap-6 text-sm text-gray-700">

                <Link
                    :href="route('dashboard')"
                    class="hover:text-brand-focus transition-colors duration-300"
                >
                    Beranda
                </Link>

                <Link
                    :href="route('public.konsultan')"
                    class="hover:text-brand-focus transition-colors duration-300"
                >
                    Konsultan
                </Link>

                <Link
                    :href="route('public.about')"
                    class="hover:text-brand-focus transition-colors duration-300"
                >
                    Tentang Kami
                </Link>

                <Link
                    :href="route('public.cekbooking')"
                    class="hover:text-brand-focus transition-colors duration-300"
                >
                    Cek Booking
                </Link>

                <Link
                    :href="route('login')"
                    class="hover:text-brand-focus transition-colors duration-300"
                >
                    Admin/konsultan
                </Link>

            </div>

        </div>
    </nav>
</template>