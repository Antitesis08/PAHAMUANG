<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    konsultan: {
        type: Object,
        required: true,
    },

    stats: {
        type: Object,
        default: () => ({
            total_jadwal: 0,
            total_klien: 0,
            total_selesai: 0,
            total_pendapatan: 0,
        }),
    },

    incomingConsultations: {
        type: Array,
        default: () => [],
    },
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

const consultationForm = useForm();
const rejectingId = ref(null);
const rejectReasons = ref({});
const statusLoading = ref(false);

const openRejectPanel = (id) => {
    rejectingId.value = id;
    rejectReasons.value[id] = '';
};

const cancelReject = () => {
    rejectingId.value = null;
};

const changeStatus = (id, status, alasan = null) => {
    if (!confirm('Yakin ingin mengubah status konsultasi?')) return;

    statusLoading.value = true;

    router.patch(route('konsultan.konsultasi.status', id), { status, alasan_tolak: alasan }, {
        onFinish: () => { statusLoading.value = false; },
        onSuccess: () => {
            location.reload();
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
                    <p class="mt-1 text-indigo-100">Panel kontrol konsultan PAHAMUANG.</p>
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

                    <!-- Jadwal -->
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
                            {{ stats.total_jadwal }}
                        </h2>

                        <p class="mt-2 text-gray-500">
                            Jadwal konsultasi mendatang
                        </p>
                    </div>

                    <!-- Selesai -->
                    <div
                        class="rounded-2xl border border-gray-100 bg-white p-6 shadow-sm"
                    >
                        <div
                            class="mb-5 flex h-14 w-14 items-center justify-center rounded-xl bg-blue-100"
                        >
                            <svg class="h-7 w-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>

                        <h2 class="text-4xl font-bold text-gray-900">
                            {{ stats.total_selesai }}
                        </h2>

                        <p class="mt-2 text-gray-500">
                            Konsultasi selesai
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
                                alt="Client"
                                class="h-7 w-7 object-contain"
                            />
                        </div>

                        <h2 class="text-4xl font-bold text-gray-900">
                            {{ stats.total_klien }}
                        </h2>

                        <p class="mt-2 text-gray-500">
                            Total klien unik yang ditangani
                        </p>
                    </div>
                </div>

                <!-- Incoming konsultasi -->
                <div class="mb-8 rounded-2xl border border-gray-100 bg-white p-6 shadow-sm">
                    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Permintaan Konsultasi Masuk</h2>
                            <p class="mt-1 text-gray-500">
                                Tinjau permintaan pelanggan dan kelola statusnya.
                            </p>
                        </div>
                        <span class="rounded-full bg-blue-100 px-4 py-2 text-sm font-semibold text-blue-700">
                            {{ incomingConsultations.length }} permintaan aktif
                        </span>
                    </div>

                    <div v-if="!incomingConsultations.length" class="rounded-2xl border border-dashed border-gray-200 p-8 text-center text-gray-500">
                        Tidak ada permintaan konsultasi baru saat ini.
                    </div>

                    <div v-else class="space-y-4">
                        <div
                            v-for="item in incomingConsultations"
                            :key="item.id"
                            class="rounded-2xl border border-gray-200 bg-gray-50 p-5"
                        >
                            <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                                <div>
                                    <div class="flex flex-wrap items-center gap-3">
                                        <span class="rounded-full bg-white px-3 py-1 text-sm font-semibold text-gray-700 shadow-sm">
                                            {{ item.status === 'pending' ? 'Pending' : 'Aktif' }}
                                        </span>
                                        <span class="text-sm text-gray-500">{{ item.layanan }}</span>
                                    </div>

                                    <h3 class="mt-3 text-xl font-semibold text-gray-900">{{ item.nama_user }}</h3>
                                    <p class="text-sm text-gray-600">Topik: {{ item.topik }}</p>
                                    <p class="mt-3 text-sm text-gray-500">
                                        Jadwal: {{ item.tanggal }} · {{ item.jam }}
                                    </p>
                                </div>

                                <div class="flex flex-wrap items-center gap-3">
                                    <button
                                        v-if="item.status === 'pending'"
                                        @click="changeStatus(item.id, 'aktif')"
                                        :disabled="statusLoading"
                                        class="rounded-full bg-green-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-green-700 disabled:cursor-not-allowed disabled:opacity-50"
                                    >
                                        Terima
                                    </button>
                                    <button
                                        v-if="item.status === 'pending'"
                                        @click="openRejectPanel(item.id)"
                                        :disabled="statusLoading"
                                        class="rounded-full bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-50"
                                    >
                                        Tolak
                                    </button>
                                    <button
                                        v-if="item.status === 'aktif'"
                                        @click="changeStatus(item.id, 'selesai')"
                                        :disabled="statusLoading"
                                        class="rounded-full bg-blue-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-blue-700 disabled:cursor-not-allowed disabled:opacity-50"
                                    >
                                        Selesaikan
                                    </button>
                                </div>
                                <div v-if="rejectingId === item.id" class="mt-4 rounded-2xl bg-white border border-red-100 p-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Alasan Tolak (opsional)</label>
                                    <textarea
                                        v-model="rejectReasons[item.id]"
                                        rows="3"
                                        class="w-full rounded-xl border border-gray-200 p-3 text-sm focus:border-red-500 focus:ring-red-500"
                                        placeholder="Tulis alasan singkat penolakan..."
                                    ></textarea>
                                    <div class="mt-3 flex flex-wrap gap-3">
                                        <button
                                            @click="changeStatus(item.id, 'ditolak', rejectReasons[item.id])"
                                            :disabled="statusLoading"
                                            class="rounded-full bg-red-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-red-700 disabled:cursor-not-allowed disabled:opacity-50"
                                        >
                                            Konfirmasi Tolak
                                        </button>
                                        <button
                                            @click="cancelReject"
                                            type="button"
                                            class="rounded-full bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-700 transition hover:bg-gray-300"
                                        >
                                            Batal
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
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