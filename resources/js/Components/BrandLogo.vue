<script setup>
defineProps({
  size: { type: String, default: 'md' }
});
</script>

<template>
  <div class="flex items-center gap-3">
    <div :class="['brand-square', size === 'lg' ? 'large' : '']" aria-hidden style="background:var(--brand-focus)">
      <span class="text-white font-bold" style="font-size:18px;letter-spacing:0.5px">P</span>
    </div>

    <div class="flex flex-col leading-tight">
      <span class="text-lg font-extrabold" :style="{ color: 'var(--brand-text)' }">PAHAMUANG</span>
      <span class="text-xs text-slate-500">Financial Consultation</span>
    </div>
  </div>
</template>
