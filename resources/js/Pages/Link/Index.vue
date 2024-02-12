<script setup lang="ts">
import Table from '@/Components/Table.vue';
import Primary from '../Layout/Primary.vue';
import type { LinksCollection } from '@/types/link';
import { computed } from 'vue';
import { ref } from 'vue';

const props = defineProps<{
    sort: string;
    links: LinksCollection
}>()

const linksList = ref(props.links.data)

function refresh(): void {
    linksList.value = props.links.data
}

</script>

<template>
    <Primary>
        <div class="flex flex-col gap-10 p-2">
            <section class="flex items-center justify-between">
                <div class="text-2xl font-bold">
                    My Links
                </div>
                <div class="btn">
                    Create
                </div>
            </section>
            <section class="flex flex-col gap-5">
                <Table @refresh="refresh" :labels="{
                    id: '#',
                    original: 'Original',
                    slug: 'Slug',
                    created_at: 'Created At'
                }" :sort="sort" :ignore="['slug', 'original']" :empty="!linksList.length" collection-name="links">
                    <template #body>
                        <tr v-for="link in linksList" :key="link.id">
                            <td class="px-2 py-3 text-sm whitespace-nowrap">
                                {{ link.id }}
                            </td>
                            <td class="px-2 py-3 text-sm whitespace-nowrap">
                                {{ link.original }}
                            </td>
                            <td class="px-2 py-3 text-sm whitespace-nowrap">
                                {{ link.slug }}
                            </td>
                            <td class="px-2 py-3 text-sm whitespace-nowrap">
                                {{ link.created_at }}
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
