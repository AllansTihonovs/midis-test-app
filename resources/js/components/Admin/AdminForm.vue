<script setup>
import { useForm } from '@inertiajs/vue3'
import { computed } from 'vue'

const props = defineProps({
    administrator: {
        type: Object,
        default: null,
    },
})

const isEdit = computed(() => !!props.administrator)

const form = useForm({
    name: props.administrator?.name || '',
    email: props.administrator?.email || '',
    password: '',
})

const submit = () => {
    isEdit.value ?
        form.put(route('admin.update', props.administrator.id)) :
        form.post(route('admin.store'))
}
</script>

<template>
    <div class="max-w-xl mx-auto bg-white rounded p-6 space-y-4">
        <h2 class="text-xl font-semibold mb-4">{{ isEdit ? 'Edit Administrator' : 'Create Administrator' }}</h2>

        <form @submit.prevent="submit">
            <div>
                <label>Name</label>
                <input v-model="form.name" type="text" class="form-input w-full" />
                <div v-if="form.errors.name" class="text-red-500 text-sm">{{ form.errors.name }}</div>
            </div>

            <div>
                <label>Email</label>
                <input v-model="form.email" type="email" class="form-input w-full" />
                <div v-if="form.errors.email" class="text-red-500 text-sm">{{ form.errors.email }}</div>
            </div>

            <div>
                <label>Password {{ isEdit ? '(leave empty to keep current)' : '' }}</label>
                <input v-model="form.password" type="password" class="form-input w-full" />
                <div v-if="form.errors.password" class="text-red-500 text-sm">{{ form.errors.password }}</div>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 mt-4">
                {{ isEdit ? 'Update Administrator' : 'Create Administrator' }}
            </button>
        </form>
    </div>
</template>
