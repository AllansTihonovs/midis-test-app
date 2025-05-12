<script setup>
import { Head } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue';
import MessageForm from '@/Components/Guestbook/MessageForm.vue'

const props = defineProps({
    message: Object
})
</script>

<template>
    <GuestLayout>
        <Head title="Edit Message" />

        <MessageForm :message="props.message" />
    </GuestLayout>
</template>
