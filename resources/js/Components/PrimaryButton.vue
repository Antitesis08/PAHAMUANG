<script setup>
const props = defineProps({
  type: { type: String, default: 'button' },
  loading: { type: Boolean, default: false }
});
</script>

<template>
    <button
        :type="props.type"
        :disabled="props.loading"
        class="btn-primary disabled:opacity-60"
    >
        <span v-if="props.loading" class="inline-flex items-center gap-3">
            <span class="spinner"></span>
            <span class="text-sm">Loading...</span>
        </span>

        <span v-else>
            <slot />
        </span>
    </button>
</template>
