<script setup>
import { Head, Link } from '@inertiajs/vue3';

const props = defineProps({
    konsultasi: Object,
});

const formatPrice = (price) => {
    if (!price) return '-';
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
    }).format(price);
};

const parseLocalDate = (dateString) => {
    if (!dateString) return null;
    const cleaned = dateString.replace('T', ' ').replace(/\.\d+/, '').replace(/Z$/, '').replace(/[\+\-]\d{2}:\d{2}$/, '');
    const parts = cleaned.match(/^(\d{4})-(\d{2})-(\d{2})\s+(\d{2}):(\d{2}):(\d{2})$/);
    if (parts) {
        return new Date(
            parseInt(parts[1], 10),
            parseInt(parts[2], 10) - 1,
            parseInt(parts[3], 10),
            parseInt(parts[4], 10),
            parseInt(parts[5], 10),
            parseInt(parts[6], 10)
        );
    }
    return new Date(dateString);
};

const formatDate = (dateString) => {
    if (!dateString) return '-';
    const date = parseLocalDate(dateString);
    if (!date) return '-';
    return date.toLocaleDateString('id-ID', {
        weekday: 'long',
        day: 'numeric',
        month: 'long',
        year: 'numeric',
    });
};

const formatTime = (dateString) => {
    if (!dateString) return '-';
    const date = parseLocalDate(dateString);
    if (!date) return '-';
    return date.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
    });
};

const bookingCode = props.konsultasi.pembayaran?.kode_transaksi || `BOOK-${String(props.konsultasi.id).padStart(6, '0')}`;
</script>

<template>
    <Head title="Booking Berhasil" />

    <div class="min-h-screen bg-gray-50 text-gray-800">
        <div class="max-w-5xl mx-auto px-4 py-16 sm:px-6 lg:px-8">
            <div class="rounded-[2rem] bg-white border border-gray-100 p-10 shadow-xl">
                <div class="flex flex-col gap-5 text-center">
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-green-100 text-green-700">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 6L9 17l-5-5" />
                        </svg>
                    </div>
                    <h1 class="text-4xl font-extrabold text-gray-900">Booking Konsultasi Berhasil!</h1>
                    <p class="text-gray-500 text-lg max-w-2xl mx-auto">
                        Terima kasih, permintaan booking Anda telah diterima. Konsultan akan segera menghubungi Anda melalui WhatsApp atau email untuk konfirmasi lebih lanjut.
                    </p>
                </div>

                <div class="mt-10 grid gap-6 lg:grid-cols-2">
                    <div class="rounded-3xl border border-gray-200 bg-gray-50 p-6">
                        <p class="text-sm text-gray-500 uppercase tracking-wider">Kode Booking Anda</p>
                        <h2 class="mt-4 text-3xl font-bold text-gray-900">{{ bookingCode }}</h2>
                        <p class="mt-3 text-gray-600 leading-relaxed">
                            Simpan kode booking ini sebagai referensi. Anda dapat menunjukkannya pada saat konsultasi atau ketika menghubungi tim dukungan.
                        </p>
                    </div>

                    <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-sm">
                        <p class="text-sm text-gray-500 uppercase tracking-wider">Ringkasan Konsultasi</p>
                        <div class="mt-4 space-y-4 text-gray-700">
                            <div>
                                <p class="text-xs uppercase text-gray-400">Konsultan</p>
                                <p class="font-semibold text-gray-900">{{ props.konsultasi.konsultan?.nama || '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase text-gray-400">Layanan</p>
                                <p class="font-semibold text-gray-900">{{ props.konsultasi.layanan?.nama_layanan || 'Konsultasi Keuangan' }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase text-gray-400">Tanggal & Waktu</p>
                                <p class="font-semibold text-gray-900">{{ formatDate(props.konsultasi.jadwal) }} · {{ formatTime(props.konsultasi.jadwal) }}</p>
                            </div>
                            <div>
                                <p class="text-xs uppercase text-gray-400">Total Pembayaran</p>
                                <p class="font-semibold text-gray-900">{{ formatPrice(props.konsultasi.pembayaran?.jumlah || props.konsultasi.layanan?.harga || 0) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10 rounded-3xl border border-dashed border-green-200 bg-green-50 p-6 text-gray-700">
                    <p class="font-semibold text-gray-900 mb-2">Informasi Penting</p>
                    <ul class="space-y-3 text-sm">
                        <li>• Konsultan akan menghubungi Anda segera melalui WhatsApp atau email yang Anda berikan.</li>
                        <li>• Pastikan nomor telepon dan email Anda aktif agar proses konfirmasi berjalan lancar.</li>
                        <li>• Jika ada perubahan jadwal, silakan hubungi tim dukungan PAHAMUANG.</li>
                    </ul>
                </div>

                <div class="mt-10 flex flex-col gap-4 sm:flex-row sm:justify-center">
                    <Link
                        :href="route('dashboard')"
                        class="inline-flex items-center justify-center rounded-2xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700"
                    >
                        Kembali ke Beranda
                    </Link>
                    <Link
                        :href="route('public.konsultan')"
                        class="inline-flex items-center justify-center rounded-2xl border border-gray-200 bg-white px-6 py-3 text-sm font-semibold text-gray-700 transition hover:bg-gray-100"
                    >
                        Lihat Konsultan Lain
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>
