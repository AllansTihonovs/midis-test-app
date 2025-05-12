<script setup>
import { Head } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue';
import MessageForm from '@/Components/Guestbook/MessageForm.vue'

</script>

<template>
    <GuestLayout>
        <Head title="Create New Message" />

        <MessageForm />
    </GuestLayout>
</template>
