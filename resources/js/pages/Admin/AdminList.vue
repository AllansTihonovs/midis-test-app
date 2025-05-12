<script setup>
import { Link, router } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    administrators: Object,
})

const confirmDelete = (id) => {
    if (confirm('Are you sure you want to delete this administrator?')) {
        router.delete(route('admin.destroy', id))
    }
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="container mx-auto p-4 mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:rounded-lg">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Administrators</h1>
                <div>
                    <Link :href="route('admin.create')"
                          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mr-4 mt-4"
                    >
                        Create Admin
                    </Link>
                    <Link
                        :href="route('messages.index')"
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                    >
                        Guestbook
                    </Link>
                </div>
            </div>

            <table class="w-full border table-auto text-left">
                <thead class="bg-gray-100">
                <tr>
                    <th class="p-2">Name</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Created At</th>
                    <th class="p-2">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="admin in administrators.data" :key="admin.id" class="border-t">
                    <td class="p-2">{{ admin.name }}</td>
                    <td class="p-2">{{ admin.email }}</td>
                    <td class="p-2">{{ new Date(admin.created_at).toLocaleString('lv-LV') }}</td>
                    <td class="p-2 flex gap-2">
                        <Link :href="route('admin.edit', admin.id)" class="text-blue-600 hover:underline">Edit</Link>
                        <button @click="confirmDelete(admin.id)" class="text-red-600 hover:underline">Delete</button>
                    </td>
                </tr>
                </tbody>
            </table>

            <Pagination :links="administrators.links" class="mt-4" />
        </div>
    </AuthenticatedLayout>
</template>
