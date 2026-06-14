<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, Link, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    konsultan: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    nama: props.konsultan.nama || '',
    email: props.konsultan.email || '',
    no_telepon: props.konsultan.no_telepon || '',
    deskripsi: props.konsultan.deskripsi || '',
    spesialisasi: props.konsultan.spesialisasi || '',
    tarif: props.konsultan.tarif || '',
    foto_profil: null,
});

const fileInput = ref(null);
const imagePreview = ref(props.konsultan.foto_profil_url || null);

const triggerFileInput = () => {
    fileInput.value.click();
};

const handleFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file maksimal adalah 2MB');
            return;
        }
        form.foto_profil = file;
        imagePreview.value = URL.createObjectURL(file);
    }
};

const submit = () => {
    // We send a POST request to support file upload, matching the Route::post('/profil') route
    form.post(route('konsultan.profil.post'), {
        preserveScroll: true,
        onSuccess: (page) => {
            // Clear file from form
            form.foto_profil = null;
            // Ambil foto_profil_url terbaru dari props yang di-refresh server
            imagePreview.value = page.props.konsultan?.foto_profil_url || imagePreview.value;
        },
    });
};
</script>

<template>
    <Head title="Edit Profil" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-gray-800">
                    Pengaturan Profil Saya
                </h2>
                <Link
                    :href="route('konsultan.dashboard')"
                    class="inline-flex items-center gap-2 rounded-xl border border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-700 shadow-sm transition hover:bg-gray-50"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Dashboard
                </Link>
            </div>
        </template>

        <div class="py-12 bg-gray-50 min-h-screen">
            <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
                
                <!-- Success Alert -->
                <div v-if="$page.props.flash && $page.props.flash.success" class="mb-6">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-2xl relative shadow-sm" role="alert">
                        <span class="block sm:inline font-medium">{{ $page.props.flash.success }}</span>
                    </div>
                </div>

                <!-- Profile Form Card -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8 md:p-12">
                    <form @submit.prevent="submit" class="space-y-8">
                        
                        <!-- Avatar Upload Section -->
                        <div class="flex flex-col items-center sm:flex-row gap-6 pb-6 border-b border-gray-100">
                            <div class="relative group">
                                <div class="w-32 h-32 rounded-3xl overflow-hidden bg-indigo-50 border-2 border-indigo-100 flex items-center justify-center relative">
                                    <img 
                                        v-if="imagePreview" 
                                        :src="imagePreview" 
                                        alt="Foto Profil Preview" 
                                        class="w-full h-full object-cover"
                                    />
                                    <span v-else class="text-indigo-500 text-4xl font-extrabold">
                                        {{ form.nama ? form.nama.charAt(0).toUpperCase() : 'K' }}
                                    </span>
                                </div>
                                
                                <button 
                                    type="button"
                                    @click="triggerFileInput"
                                    class="absolute -bottom-2 -right-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-full p-2.5 shadow-lg transition-transform hover:scale-110"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>

                            <div class="text-center sm:text-left">
                                <h3 class="text-lg font-bold text-gray-900">Foto Profil</h3>
                                <p class="text-sm text-gray-500 mt-1">Format PNG, JPG, JPEG. Maksimal 2MB.</p>
                                <button 
                                    type="button" 
                                    @click="triggerFileInput"
                                    class="mt-3 inline-flex items-center gap-2 border border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold px-4 py-2 rounded-xl text-sm transition"
                                >
                                    Pilih Foto Baru
                                </button>
                                <input 
                                    type="file" 
                                    ref="fileInput" 
                                    @change="handleFileChange" 
                                    class="hidden" 
                                    accept="image/*"
                                />
                                <div v-if="form.errors.foto_profil" class="text-red-500 text-xs mt-2 font-medium">
                                    {{ form.errors.foto_profil }}
                                </div>
                            </div>
                        </div>

                        <!-- Form Fields Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Nama -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                                <input 
                                    type="text" 
                                    v-model="form.nama" 
                                    class="w-full border border-gray-200 rounded-xl p-3.5 text-sm transition focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Masukkan nama lengkap..."
                                    required
                                />
                                <div v-if="form.errors.nama" class="text-red-500 text-xs mt-1 font-medium">
                                    {{ form.errors.nama }}
                                </div>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                                <input 
                                    type="email" 
                                    v-model="form.email" 
                                    class="w-full border border-gray-200 rounded-xl p-3.5 text-sm transition focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Masukkan email..."
                                    required
                                />
                                <div v-if="form.errors.email" class="text-red-500 text-xs mt-1 font-medium">
                                    {{ form.errors.email }}
                                </div>
                            </div>

                            <!-- No Telepon -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Telepon</label>
                                <input 
                                    type="text" 
                                    v-model="form.no_telepon" 
                                    class="w-full border border-gray-200 rounded-xl p-3.5 text-sm transition focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Contoh: 081234567890"
                                />
                                <div v-if="form.errors.no_telepon" class="text-red-500 text-xs mt-1 font-medium">
                                    {{ form.errors.no_telepon }}
                                </div>
                            </div>

                            <!-- Spesialisasi -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Spesialisasi / Keahlian</label>
                                <input 
                                    type="text" 
                                    v-model="form.spesialisasi" 
                                    class="w-full border border-gray-200 rounded-xl p-3.5 text-sm transition focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Contoh: Investasi, Perencanaan Pensiun, Manajemen Utang"
                                />
                                <div v-if="form.errors.spesialisasi" class="text-red-500 text-xs mt-1 font-medium">
                                    {{ form.errors.spesialisasi }}
                                </div>
                            </div>

                            <!-- Tarif per Jam -->
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">Tarif per Jam (Rp)</label>
                                <input 
                                    type="number" 
                                    v-model="form.tarif" 
                                    min="0"
                                    class="w-full border border-gray-200 rounded-xl p-3.5 text-sm transition focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Contoh: 500000"
                                />
                                <div v-if="form.errors.tarif" class="text-red-500 text-xs mt-1 font-medium">
                                    {{ form.errors.tarif }}
                                </div>
                            </div>

                        </div>

                        <!-- Deskripsi / Bio -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi / Bio Singkat</label>
                            <textarea 
                                v-model="form.deskripsi" 
                                rows="5"
                                class="w-full border border-gray-200 rounded-xl p-3.5 text-sm transition focus:border-indigo-500 focus:ring-indigo-500"
                                placeholder="Jelaskan secara singkat latar belakang, pengalaman, dan keahlian Anda agar klien lebih percaya diri memilih Anda..."
                            ></textarea>
                            <div v-if="form.errors.deskripsi" class="text-red-500 text-xs mt-1 font-medium">
                                {{ form.errors.deskripsi }}
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end gap-4 pt-4 border-t border-gray-100">
                            <button 
                                type="submit" 
                                :disabled="form.processing"
                                class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-6 py-3.5 rounded-xl text-sm transition shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                {{ form.processing ? 'Menyimpan...' : 'Simpan Perubahan' }}
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
