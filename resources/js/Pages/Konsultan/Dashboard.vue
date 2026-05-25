<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    konsultan: {
        type: Object,
        required: true,
    },

    totalKlien: Number,
});

// Toggle Status
const isAvailable = ref(props.konsultan.is_available);

const statusForm = useForm({
    is_available: props.konsultan.is_available,
});

const toggleStatus = () => {
    statusForm.is_available = !isAvailable.value;

    statusForm.patch(route('konsultan.status'), {
        onSuccess: () => {
            isAvailable.value = statusForm.is_available;
        },
    });
};

</script>

<template>
    <Head title="Dashboard Konsultan" />

    <AuthenticatedLayout>

        <div class="min-h-screen bg-gray-50">
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

                <!-- Welcome -->
                <div class="mb-6 rounded-lg bg-indigo-600 p-6 text-white shadow">
                    <h3 class="text-2xl font-bold">Selamat datang, {{ konsultan.nama }}! 👋</h3>
                    <p class="mt-1 text-indigo-100">Panel kontrol administrator PAHAMUANG.</p>
                </div>

                <!-- Status Card -->
                <div
                    class="mb-8 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm"
                >
                    <div
                        class="flex flex-col gap-5 lg:flex-row lg:items-center lg:justify-between"
                    >
                        <div>
                            <h2 class="text-xl font-semibold text-gray-800">
                                Status Ketersediaan
                            </h2>

                            <p class="mt-1 text-gray-500">
                                Ubah status untuk mengatur penerimaan klien baru
                            </p>
                        </div>

                        <!-- Toggle -->
                        <button
                            @click="toggleStatus"
                            :disabled="statusForm.processing"
                            class="flex items-center gap-4"
                        >
                            <div
                                :class="
                                    isAvailable
                                        ? 'bg-green-500'
                                        : 'bg-gray-300'
                                "
                                class="relative h-10 w-20 rounded-full transition"
                            >
                                <div
                                    :class="
                                        isAvailable
                                            ? 'translate-x-10'
                                            : 'translate-x-1'
                                    "
                                    class="absolute top-1 h-8 w-8 rounded-full bg-white shadow-md transition"
                                ></div>
                            </div>

                            <div class="text-left">
                                <div
                                    class="flex items-center gap-2 text-lg font-semibold"
                                    :class="
                                        isAvailable
                                            ? 'text-green-600'
                                            : 'text-gray-500'
                                    "
                                >
                                    <span
                                        class="h-3 w-3 rounded-full"
                                        :class="
                                            isAvailable
                                                ? 'bg-green-500'
                                                : 'bg-gray-400'
                                        "
                                    ></span>

                                    {{
                                        isAvailable
                                            ? 'Tersedia'
                                            : 'Tidak Tersedia'
                                    }}
                                </div>

                                <p class="text-sm text-gray-500">
                                    {{
                                        isAvailable
                                            ? 'Menerima Klien'
                                            : 'Sedang Offline'
                                    }}
                                </p>
                            </div>
                        </button>
                    </div>
                </div>

                <!-- Stats -->
                <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-3">

                    <!-- Sesi -->
                    <div
                        class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm"
                    >
                        <div
                            class="mb-5 flex h-14 w-14 items-center justify-center rounded-xl bg-blue-100"
                        >
                            <img
                                src="/images/calendar.png"
                                alt="Calendar"
                                class="h-7 w-7 object-contain"
                            />
                        </div>

                        <h2 class="text-4xl font-bold text-gray-900">
                            2
                        </h2>

                        <p class="mt-2 text-gray-500">
                            Sesi Minggu Ini
                        </p>
                    </div>

                    <!-- Pendapatan -->
                    <div
                        class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm"
                    >
                        <div
                            class="mb-5 flex h-14 w-14 items-center justify-center rounded-xl bg-blue-100"
                        >
                            <img
                                src="/images/money.png"
                                alt="Calendar"
                                class="h-7 w-7 object-contain"
                            />
                        </div>

                        <h2 class="text-4xl font-bold text-gray-900">
                            Rp 750.000
                        </h2>

                        <p class="mt-2 text-gray-500">
                            Pendapatan Berjalan
                        </p>
                    </div>

                    <!-- Klien -->
                    <div
                        class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm"
                    >
                        <div
                            class="mb-5 flex h-14 w-14 items-center justify-center rounded-xl bg-blue-100"
                        >
                            <img
                                src="/images/client.png"
                                alt="Calendar"
                                class="h-7 w-7 object-contain"
                            />
                        </div>

                        <h2 class="text-4xl font-bold text-gray-900">
                            1
                        </h2>

                        <p class="mt-2 text-gray-500">
                            Klien Terkonfirmasi
                        </p>
                    </div>
                </div>

                <!-- Bottom Cards -->
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

                    <!-- Jadwal -->
                    <Link
                        :href="route('konsultan.jadwal')"
                        class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg"
                    >
                        <div class="flex items-start justify-between">
                            <div>
                                <div
                                    class="mb-5 flex h-14 w-14 items-center justify-center rounded-xl bg-blue-100"
                                >
                                    <img
                                        src="/images/jadwal.png"
                                        alt="Calendar"
                                        class="h-7 w-7 object-contain"
                                    />
                                </div>

                                <h2
                                    class="text-2xl font-bold text-gray-900"
                                >
                                    Jadwal Konsultasi
                                </h2>

                                <p class="mt-2 text-gray-500">
                                    Lihat dan kelola semua jadwal konsultasi Anda
                                </p>
                            </div>

                            <span
                                class="font-semibold text-blue-600"
                            >
                                Lihat Semua →
                            </span>
                        </div>
                    </Link>

                    <!-- Total Klien -->
                    <Link
                        :href="route('konsultan.riwayat')"
                        class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-lg"
                    >
                        <div>
                            <div
                                class="mb-5 flex h-14 w-14 items-center justify-center rounded-xl bg-blue-100"
                            >
                                <img
                                    src="/images/client.png"
                                    alt="Calendar"
                                    class="h-7 w-7 object-contain"
                                />
                            </div>

                            <h2 class="text-2xl font-bold text-gray-900">
                                Total Klien
                            </h2>

                            <p class="mt-2 text-gray-500">
                                Anda telah membantu
                                <span class="font-semibold text-blue-600">
                                    {{ totalKlien }}
                                </span>
                                mencapai tujuan finansial mereka
                            </p>
                        </div>
                    </Link>

                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>