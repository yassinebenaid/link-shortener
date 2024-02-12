<script setup lang="ts">
import Table from '@/Components/Table.vue';
import Create from './Partials/Create.vue';
import Primary from '../Layout/Primary.vue';
import type { LinksCollection } from '@/types/link';
import { ref } from 'vue';
import Delete from './Partials/Delete.vue';

const props = defineProps<{
    sort: string;
    links: LinksCollection
}>()

const linksList = ref(props.links.data)

function refresh(): void {
    linksList.value = props.links.data
}

function deleetLink(id: number): void {
    linksList.value = linksList.value.filter(e => e.id != id)
}
</script>

<template>
    <Primary>
        <div class="flex flex-col gap-10 p-2">
            <section class="flex items-center justify-between">
                <div class="text-2xl font-bold">
                    My Links
                </div>
                <Create @refresh="refresh" />
            </section>
            <section class="flex flex-col gap-5">
                <Table @refresh="refresh" :labels="{
                    id: '#',
                    url: 'URL',
                    clicks_count: 'Clicks',
                    original: 'Original',
                    created_at: 'Created'
                }" :sort="sort" :ignore="['slug', 'original']" :empty="!linksList.length" collection-name="links">
                    <template #body>
                        <tr v-for="link in linksList" :key="link.id">
                            <td class="px-2 py-3 text-sm whitespace-nowrap">
                                {{ link.id }}
                            </td>
                            <td class="px-2 py-3 text-sm whitespace-nowrap">
                                <a :href="link.url" target="_blank" class="hover:text-blue-500 hover:underline">
                                    {{ link.url }}
                                </a>
                            </td>
                            <td class="px-2 py-3 text-sm whitespace-nowrap">
                                {{ link.clicks }}
                            </td>
                            <td class="px-2 py-3 text-sm whitespace-nowrap">
                                {{ link.original }}
                            </td>
                            <td class="px-2 py-3 text-sm whitespace-nowrap">
                                {{ link.created_at }}
                            </td>
                            <td class="px-5">
                                <Delete @delete="deleetLink(link.id)" :href="route('links.destroy', link)" />
                            </td>
                        </tr>
                    </template>
                </Table>

                <nav class="flex items-center justify-between gap-2 text-sm">
                    <A :href="links.links.prev ?? ''" :disabled="!links.links.prev" as="button"
                        class="px-3 py-1 rounded-md disabled:text-dark/70 hover:bg-gray-100 active:bg-gray-200">
                        Previos
                    </A>
                    <A :href="links.links.next ?? ''" :disabled="!links.links.next" as="button"
                        class="px-3 py-1 rounded-md disabled:text-dark/70 hover:bg-gray-100 active:bg-gray-200">
                        Next
                    </A>
                </nav>
            </section>
        </div>
    </Primary>
</template>
