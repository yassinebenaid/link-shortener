<script setup lang="ts">
import axios from 'axios';
import { ref } from 'vue';

const emit = defineEmits<{
    (e: 'delete'): void
}>()

const props = defineProps<{
    href: string;
}>()

const open = ref<boolean>(false)
const progressing = ref(false)

function drop(): void {
    progressing.value = true

    axios({
        url: props.href,
        method: 'delete',
        validateStatus: (status) => status === 204,
    }).then(() => {
        emit('delete')
        open.value = false
    }).finally(() => {
        progressing.value = false
    })
}

</script>

<template>
    <div>
        <div @click="open = true">
            <button data-title="delete"
                class="flex items-center gap-1 p-2 text-sm font-medium text-red-500 transition-all rounded-md active:bg-red-500 active:text-white hover:bg-red-50">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd"
                        d="M16.5 4.478v.227a48.816 48.816 0 013.878.512.75.75 0 11-.256 1.478l-.209-.035-1.005 13.07a3 3 0 01-2.991 2.77H8.084a3 3 0 01-2.991-2.77L4.087 6.66l-.209.035a.75.75 0 01-.256-1.478A48.567 48.567 0 017.5 4.705v-.227c0-1.564 1.213-2.9 2.816-2.951a52.662 52.662 0 013.369 0c1.603.051 2.815 1.387 2.815 2.951zm-6.136-1.452a51.196 51.196 0 013.273 0C14.39 3.05 15 3.684 15 4.478v.113a49.488 49.488 0 00-6 0v-.113c0-.794.609-1.428 1.364-1.452zm-.355 5.945a.75.75 0 10-1.5.058l.347 9a.75.75 0 101.499-.058l-.346-9zm5.48.058a.75.75 0 10-1.498-.058l-.347 9a.75.75 0 001.5.058l.345-9z"
                        clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <Teleport to="body">

            <Transition name="blur">
                <div v-if="open" @click="open = false"
                    class="fixed top-0 left-0 z-50 w-full h-full backdrop-blur-sm bg-dark/30">
                </div>
            </Transition>

            <Transition name="model">
                <div v-if="open"
                    class="fixed top-0 z-50 grid w-full overflow-hidden text-center -translate-x-1/2 translate-y-1/2 bg-white rounded-md text-dark left-1/2 sm:w-[30rem]">

                    <div class="p-3 text-sm font-medium border-b dark:border-gray-600">Warning !</div>

                    <div class="grid w-full gap-4 p-5 text-lg font-medium ">
                        <span class="grid text-red-500 place-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor"
                                class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                <path
                                    d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                            </svg>
                        </span>
                        <p class="text-sm text-dark">
                            Are you sure you want to delete this link
                        </p>
                    </div>

                    <div class="flex justify-end gap-5 p-3 border-t translate-y-fu transla-fu sm:grid-cols-2">

                        <button @click="open = false" :disabled="progressing"
                            class="px-5 py-2 text-sm font-medium transition-all border border-gray-200 rounded-md text-dark/80 hover:bg-gray-100 active:bg-gray-200 focus:ring-4 focus:ring-gray-300 ">
                            Cancel
                        </button>

                        <button @click="drop" :disabled="progressing"
                            class="flex items-center gap-2 px-5 py-2 text-sm font-medium text-white transition-all bg-red-600 border-2 border-transparent rounded-md disabled:bg-red-600/50 disabled:text-red-600 disabled:border-red-600 active:bg-red-500 focus:ring-4 focus:ring-red-300">
                            <svg v-if="progressing" class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75 " fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Delete
                        </button>
                    </div>

                </div>
            </Transition>
        </Teleport>
    </div>
</template>
<style scoped>
.blur-enter-active,
.blur-leave-active,
.model-enter-active,
.model-leave-active {
    transition-property: all;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
    transition-duration: 250ms;
}

.blur-enter-from,
.blur-leave-to {
    opacity: 0;
}

.model-enter-from,
.model-leave-to {
    opacity: 0;
}

.model-enter-from,

.model-leave-to {
    --tw-translate-y: 100%;
    transform: translate(var(--tw-translate-x), var(--tw-translate-y)) rotate(var(--tw-rotate)) skewX(var(--tw-skew-x)) skewY(var(--tw-skew-y)) scaleX(var(--tw-scale-x)) scaleY(var(--tw-scale-y));
}
</style>
