<script setup lang="ts">
import { ref } from 'vue';

defineEmits<{
    (e: 'update:modelValue', value: string): void
}>()

defineProps<{
    label: string,
    required?: boolean,
    id: string,
    error?: string,
    modelValue: string | null
    autocomplete?: string
}>()

const passwordHidden = ref<boolean>(true);
const password = ref<HTMLInputElement>();

function togglePassword() {
    passwordHidden.value = !passwordHidden.value;

    if (password.value) {
        password.value.type = password.value.type === 'text' ? 'password' : 'text'
    }
}
</script>

<template>
    <div class="w-full p-1">
        <label class="block mb-2 text-xs font-medium tracking-wide select-none" :for="id">
            {{ label }}
            <span v-if="required" class="text-xs text-red-500">*</span>
        </label>

        <div class="relative">
            <input ref="password" :class="{ '!border-red-500 !bg-red-100': error }"
                class="block w-full p-2.5 transition-all border rounded appearance-none focus:ring-4 focus:ring-dark/30 focus:outline-0 focus:border-dark/50 border-stone-300"
                :id="id" :value="modelValue" @input="$emit('update:modelValue', (<HTMLInputElement>$event.target)!.value)"
                :required="required" :autocomplete="autocomplete" type="password" />

            <div @click="togglePassword" class="absolute top-0 right-0 grid w-10 h-full text-dark/90 place-content-center">
                <svg v-if="passwordHidden" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                    class="w-5 h-5 transition-all cursor-pointer " viewBox="0 0 16 16">
                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                    <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5 cursor-pointer"
                    viewBox="0 0 16 16">
                    <path
                        d="m10.79 12.912-1.614-1.615a3.5 3.5 0 0 1-4.474-4.474l-2.06-2.06C.938 6.278 0 8 0 8s3 5.5 8 5.5a7.029 7.029 0 0 0 2.79-.588zM5.21 3.088A7.028 7.028 0 0 1 8 2.5c5 0 8 5.5 8 5.5s-.939 1.721-2.641 3.238l-2.062-2.062a3.5 3.5 0 0 0-4.474-4.474L5.21 3.089z" />
                    <path
                        d="M5.525 7.646a2.5 2.5 0 0 0 2.829 2.829l-2.83-2.829zm4.95.708-2.829-2.83a2.5 2.5 0 0 1 2.829 2.829zm3.171 6-12-12 .708-.708 12 12-.708.708z" />
                </svg>
            </div>
        </div>

        <p v-if="error" class="pt-1 text-xs text-center text-red-500">{{ error }}</p>
    </div>
</template>
