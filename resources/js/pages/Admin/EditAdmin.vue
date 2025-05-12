<script setup>
import { Head } from '@inertiajs/vue3'
import GuestLayout from '@/Layouts/GuestLayout.vue';
import AdminForm from '../../Components/Admin/AdminForm.vue'

const props = defineProps({
    administrator: Object,
})
</script>

<template>
    <GuestLayout>
        <Head title="Edit Admin" />

        <AdminForm :administrator="props.administrator" />
    </GuestLayout>
</template>
