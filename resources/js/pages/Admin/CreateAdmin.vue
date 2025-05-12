<script setup>
import { Head } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AdminForm from '../../Components/Admin/AdminForm.vue'
</script>

<template>
    <GuestLayout>
        <Head title="Create New Admin" />

        <AdminForm />
    </GuestLayout>
</template>
