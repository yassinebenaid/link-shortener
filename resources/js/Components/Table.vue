<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

const emit = defineEmits<{
    (e: 'refresh'): void
}>()

const props = defineProps<{
    collectionName: string, // will be used to lazy load items
    labels: { [k: string]: string }, // the table head labels
    sort: string | null // will be used to determine the current sorting column
    ignore?: string[] // labels to ignore from sorting
    empty: boolean,
}>()

const loading = ref<boolean>(false)
const sort = ref<string | null>(props.sort)

function sortBy(columnName: string): void {
    if (!sort.value?.startsWith(columnName)) {
        sort.value = `${columnName}.desc`;
    } else if (sort.value === `${columnName}.desc`) {
        sort.value = `${columnName}.asc`;
    } else if (sort.value === `${columnName}.asc`) {
        sort.value = null;
    }

    router.reload({
        data: { sort: sort.value || undefined },
        only: [props.collectionName],
        onSuccess: () => emit('refresh'),
        onStart: () => loading.value = true,
        onFinish: () => loading.value = false,
    })
}
</script>
<template>
    <div class="border border-gray-100 rounded-lg">
        <div class="overflow-x-auto no-scrollbar">
            <table class="min-w-full divide-y divide-gray-100 ">

                <thead class="select-none bg-gray-50">
                    <tr>
                        <th v-for="(value, key) in labels" :key="key" class="px-2 py-1 text-xs font-medium text-dark/80">

                            <div v-if="ignore?.includes(<string>key)" class="flex items-center gap-1 min-w-max ">
                                {{ value }}
                            </div>

                            <div v-else @click="sortBy(<string>key)"
                                class="flex items-center gap-1 cursor-pointer min-w-max ">
                                {{ value }}

                                <svg v-show="sort?.includes(<string>key)"
                                    :class="{ 'block rotate-180': sort === `${key}.asc` }"
                                    xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor"
                                    class=" bi bi-chevron-up" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z" />
                                </svg>
                            </div>
                        </th>

                        <th scope="col"
                            class="flex justify-end px-2 py-1 text-xs font-normal text-left text-gray-500 rtl:text-right ">
                            <svg v-if="loading" class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75 transial" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </th>
                    </tr>

                </thead>



                <tbody class="bg-white divide-y divide-gray-100">
                    <td v-if="empty" colspan="100">
                        <div class="flex w-full h-60 place-content-center">
                            <img src="../Assets/empty-cat.svg" class="object-contain ">
                        </div>
                    </td>
                    <slot v-else name="body"></slot>
                </tbody>
            </table>
        </div>
    </div>
</template>
