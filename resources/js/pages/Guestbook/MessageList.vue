<script setup>
import { router, Link, usePage } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'

const page = usePage();
const props = defineProps({
    messages: Object,
    filters: Object,
})

const sortBy = (column) => {
    const isSameColumn = props.filters.sort === column
    const direction = isSameColumn && props.filters.direction === 'asc' ? 'desc' : 'asc'

    router.get(route('messages.index'), {
        sort: column,
        direction: direction,
    }, {
        preserveState: true,
        preserveScroll: true,
    })
}

const canEdit = (message) => {
    if (page.props.auth.user) {
        return true;
    }

    const created = new Date(message.created_at)
    const now = new Date()
    const diffMins = (now - created) / 1000 / 60

    return message.ip_address === page.props.ip && diffMins <= 5
}

const confirmDelete = (id) => {
    if (confirm('Are you sure you want to delete this message?')) {
        router.delete(route('messages.destroy', id), {
            preserveScroll: true,
        })
    }
}
</script>

<template>
    <div class="container mx-auto p-4">
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-2xl font-bold">Guestbook Messages</h1>
            <div>
                <Link
                    :href="route('messages.create')"
                    method="get"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mr-4"
                >
                    Create Message
                </Link>
                <Link
                    v-if="page.props.auth.user"
                    :href="route('admin.index')"
                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"
                >
                    Administrator Management
                </Link>
                <Link
                    v-if="!page.props.auth.user"
                    :href="route('login')"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                >
                    Login
                </Link>
            </div>
        </div>

        <table class="w-full border table-auto text-left">
            <thead class="bg-gray-100">
            <tr>
                <th class="p-2 cursor-pointer" @click="sortBy('name')">
                    Name
                </th>
                <th class="p-2">Message</th>
                <th class="p-2 cursor-pointer" @click="sortBy('created_at')">
                    Created At
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="message in messages.data" :key="message.id" class="border-t">
                <td class="p-2">
                    {{ message.name }}
                    <a :href="`mailto:${message.email}`" class="text-blue-500 block text-sm">
                        {{ message.email }}
                    </a>
                </td>
                <td class="p-2">
                    <p>{{ message.message }}</p>
                    <template v-if="message.image_path">
                        <a :href="`/storage/${message.image_path}`" target="_blank">
                            <img :src="`/storage/${message.image_path}`" alt="preview" class="w-20 mt-2 rounded" />
                        </a>
                    </template>
                    <div v-if="message.updated_at !== message.created_at" class="text-xs text-gray-500 mt-1">
                        Edited: {{ new Date(message.updated_at).toLocaleString() }}
                    </div>
                </td>
                <td class="p-2">
                    {{ new Date(message.created_at).toLocaleString() }}
                </td>
                <td class="p-2">
                    <div class="flex gap-2">
                        <a
                            v-if="canEdit(message)"
                            :href="route('messages.edit', message.id)"
                            class="text-blue-600 hover:underline"
                        >Edit</a>

                        <button
                            v-if="canEdit(message)"
                            @click="confirmDelete(message.id)"
                            class="text-red-600 hover:underline"
                        >Delete</button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

        <Pagination :links="messages.links" class="mt-4" />
    </div>
</template>
