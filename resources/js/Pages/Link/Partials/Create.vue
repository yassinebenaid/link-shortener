<script setup lang="ts">
import Input from '@/Components/Input.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const emit = defineEmits<{
    (e: 'refresh'): void
}>()

const modelIsOpen = ref(false)

const form = useForm({
    original: null,
    slug: null,
})

function submit(): void {
    form.post(route('links.store'), {
        replace: true,
        onSuccess: () => {
            emit('refresh')
            form.reset()
            modelIsOpen.value = false
        }
    })
}
</script>

<template>
    <div>
        <button @click="modelIsOpen = true"
            class="p-2 transition-all bg-gray-100 border border-gray-200 rounded-md hover:bg-gray-300 active:bg-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5" viewBox="0 0 16 16">
                <path fill-rule="evenodd"
                    d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2" />
            </svg>
        </button>

        <Teleport to="body">
            <Transition>
                <div v-if="modelIsOpen" class="fixed top-0 left-0 w-full h-full bg-dark/20 backdrop-blur-sm"></div>
            </Transition>
            <Transition name="model">
                <form @submit.prevent="submit" v-if="modelIsOpen"
                    class="fixed flex flex-col text-dark bg-white top-1/4 w-full sm:w-[38rem] rounded-md -translate-x-1/2 left-1/2 ">
                    <div class="flex items-center justify-between p-2 text-sm font-semibold">
                        Create New Link

                        <div role="button" @click="modelIsOpen = false"
                            class="p-2 transition-all rounded-full hover:bg-gray-100 active:bg-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-x-lg" viewBox="0 0 16 16">
                                <path
                                    d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z" />
                            </svg>
                        </div>
                    </div>
                    <div class="p-2 text-sm">
                        Fill in the original URL and an optional SLUG to create a link, If no slug provided, a random
                        text will be chosen for you, in most cases, you would choose a unique human readable slug to make
                        it readable and easy to remember.
                    </div>
                    <div class="p-2">
                        <Input v-model="form.original" :error="form.errors?.original" required label="Original URL"
                            id="original" type="url" />
                        <Input v-model="form.slug" :error="form.errors?.slug" label="Slug (Optional)" id="slug" />
                    </div>
                    <div class="flex items-center justify-end p-2">
                        <button class="btn">
                            Create
                        </button>
                    </div>
                </form>
            </Transition>
        </Teleport>
    </div>
</template>
<style scoped>
.v-enter-active,
.v-leave-active,
.model-enter-active,
.model-leave-active {
    transition: all 300ms ease-in-out;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}

.model-enter-from,
.model-leave-to {
    opacity: 0;
    transform: translate(-50%, -10%);
}
</style>
