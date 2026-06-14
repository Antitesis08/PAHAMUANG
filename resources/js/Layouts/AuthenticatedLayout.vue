<script setup>
import { ref } from 'vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import BrandLogo from '@/Components/BrandLogo.vue';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">

            <!-- Navbar -->
            <nav class="border-b border-gray-100 bg-bg-50 shadow-sm">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">

                        <!-- LEFT -->
                        <div class="flex items-center">

                            <!-- Logo -->
                            <Link
                                :href="route('dashboard')"
                                class="flex items-center gap-3"
                            >

                                <BrandLogo />

                            </Link>
                        </div>

                        <!-- RIGHT -->
                        <div class="hidden sm:ms-6 sm:flex sm:items-center">

                            <!-- User Dropdown -->
                            <div class="relative ms-3">
                                <Dropdown align="right" width="56">

                                    <!-- Trigger -->
                                    <template #trigger>
                                        <span class="inline-flex rounded-xl">
                                            <button
                                                type="button"
                                                class="flex items-center gap-3 rounded-xl border border-gray-200 bg-bg-50 px-4 py-2 text-sm font-medium text-gray-700 shadow-sm transition hover:bg-bg-100 hover:text-brand-focus focus:outline-none"
                                            >

                                                <!-- Avatar -->
                                                <div
                                                    class="flex h-9 w-9 items-center justify-center rounded-full bg-brand-focus/10 text-sm font-bold text-brand-focus"
                                                >
                                                    {{
                                                        $page.props.auth.user.name
                                                            ?.charAt(0)
                                                            ?.toUpperCase()
                                                    }}
                                                </div>

                                                <!-- Name -->
                                                <span>
                                                    {{ $page.props.auth.user.name }}
                                                </span>

                                                <!-- Arrow -->
                                                <svg
                                                    class="h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <!-- Dropdown Content -->
                                    <template #content>

                                        <div class="border-b border-gray-100 px-4 py-3">
                                            <p class="text-sm font-semibold text-gray-800">
                                                {{ $page.props.auth.user.name }}
                                            </p>

                                            <p class="truncate text-xs text-gray-500">
                                                {{ $page.props.auth.user.email }}
                                            </p>
                                        </div>

                                        <DropdownLink
                                            :href="$page.props.auth.user.role == 2 ? route('konsultan.profil.edit') : route('profile.edit')"
                                            class="hover:bg-blue-50 hover:text-blue-700"
                                        >
                                            Profil Saya
                                        </DropdownLink>

                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                            class="hover:bg-red-50 hover:text-red-600"
                                        >
                                            Keluar
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Mobile Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center rounded-lg p-2 text-gray-500 transition hover:bg-gray-100 hover:text-blue-600 focus:outline-none"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />

                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Mobile Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="border-t border-gray-200 bg-white sm:hidden"
                >

                    <!-- Mobile User -->
                    <div class="px-4 py-4">

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-700"
                            >
                                {{
                                    $page.props.auth.user.name
                                        ?.charAt(0)
                                        ?.toUpperCase()
                                }}
                            </div>

                            <div>
                                <div class="text-base font-semibold text-gray-800">
                                    {{ $page.props.auth.user.name }}
                                </div>

                                <div class="text-sm text-gray-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Links -->
                    <div class="space-y-1 border-t border-gray-100 pb-3 pt-2">

                        <ResponsiveNavLink
                            :href="$page.props.auth.user.role == 2 ? route('konsultan.profil.edit') : route('profile.edit')"
                        >
                            Profil Saya
                        </ResponsiveNavLink>

                        <ResponsiveNavLink
                            :href="route('logout')"
                            method="post"
                            as="button"
                        >
                            Keluar
                        </ResponsiveNavLink>

                    </div>
                </div>
            </nav>

            <!-- Page Header -->
            <header
                class="bg-white shadow-sm"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Content -->
            <main>
                <slot />
            </main>

        </div>
    </div>
</template>