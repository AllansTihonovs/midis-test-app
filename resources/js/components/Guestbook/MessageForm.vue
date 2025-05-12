<script setup>
import { useForm, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import { useReCaptcha } from "vue-recaptcha-v3";

const page = usePage();
const props = defineProps({
    message: {
        type: Object,
        default: null,
    }
})

const isEdit = computed(() => !!props.message)
const { executeRecaptcha, recaptchaLoaded } = useReCaptcha({
    siteKey: page.props.recaptcha_site_key,
});
const form = useForm({
    name: props.message?.name || '',
    email: props.message?.email || '',
    message: props.message?.message || '',
    image: null,
    captcha_token: ''
})

const submit = async () => {
    try {
        form.captcha_token = await executeRecaptcha('submit_message');

        isEdit.value ?
            form.put(route('messages.update', props.message.id)) :
            form.post(route('messages.store'), {
                forceFormData: true
            })
    } catch (error) {
        console.warn('Failed to verify CAPTCHA. Please try again.');
    }
}
</script>

<template>
    <div class="max-w-xl mx-auto bg-white rounded p-6 space-y-4">
        <h2 class="text-xl font-semibold mb-4">{{ isEdit ? 'Edit Message' : 'Create Message' }}</h2>

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
                <label>Message</label>
                <textarea v-model="form.message" class="form-textarea w-full"></textarea>
                <div v-if="form.errors.message" class="text-red-500 text-sm">{{ form.errors.message }}</div>
            </div>

            <div>
                <label>Image</label>
                <input type="file" @change="e => { form.image = e.target.files[0]; }" />

                <div v-if="isEdit && message.image_path && !form.image" class="mt-2">
                    <p class="text-sm text-gray-500">Current Image:</p>
                    <a :href="`/storage/${message.image_path}`" target="_blank">
                        <img :src="`/storage/${message.image_path}`" alt="current image" class="w-24 mt-1 rounded" />
                    </a>
                </div>
                <div v-if="form.errors.image" class="text-red-500 text-sm">{{ form.errors.image }}</div>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 mt-4">
                {{ isEdit ? 'Update Message' : 'Submit Message' }}
            </button>
        </form>
    </div>
</template>
