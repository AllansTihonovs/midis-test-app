<script setup>
defineProps({ links: Array })
</script>

<template>
    <div class="flex flex-wrap gap-2">
        <template v-for="link in links" :key="link.label">
            <component
                :is="link.url ? 'a' : 'span'"
                :href="link.url"
                v-html="link.label"
                class="px-3 py-1 rounded text-sm"
                :class="{
                  'bg-blue-500 text-white': link.active,
                  'text-gray-500 cursor-default': !link.url,
                  'hover:bg-blue-100': link.url && !link.active,
                }"
            />
        </template>
    </div>
</template>
