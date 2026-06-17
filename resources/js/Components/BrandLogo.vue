<script setup>
defineProps({
  size: { type: String, default: 'md' }
});

const sizeMap = {
  sm: 'h-8',
  md: 'h-10',
  lg: 'h-14',
};
</script>

<template>
  <div class="flex items-center gap-3">
    <img
      src="/images/logo.png"
      alt="PAHAMUANG Logo"
      :class="[sizeMap[size] || 'h-10', 'w-auto object-contain']"
    />
    <div class="flex flex-col leading-tight">
      <span class="text-lg font-extrabold" :style="{ color: 'var(--brand-text)' }">PAHAMUANG</span>
      <span class="text-xs text-slate-500">Financial Consultation</span>
    </div>
  </div>
</template>
