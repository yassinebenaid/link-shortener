<script setup lang="ts">
defineEmits(['update:modelValue'])

defineProps<{
    id: string | number,
    label: string,
    required?: boolean,
    type?: 'text' | 'number' | 'email' | 'url' | 'tel',
    error?: string,
    modelValue?: string | number | null
}>()

</script>

<template>
    <div class="w-full p-1">
        <label class="block mb-2 text-xs font-medium tracking-wide select-none" :for="<string | undefined>id">
            {{ label }} <span v-if="required" class="text-xs text-red-500">*</span>
        </label>
        <input :class="{ '!border-red-500 !bg-red-100': error }" :required="required"
            class="block w-full p-2.5 transition-all border rounded appearance-none focus:ring-4 focus:ring-dark/30 focus:outline-0 focus:border-dark/50 border-stone-300"
            :id="<string | undefined>id" :value="modelValue"
            @input="$emit('update:modelValue', (<HTMLInputElement>$event.target).value)" :type="type ?? 'text'">

        <p v-if="error" class="pt-1 text-xs text-center text-red-500">
            {{ error }}
        </p>
    </div>
</template>
