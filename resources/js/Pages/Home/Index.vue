<script setup lang="ts">
import Primary from '@/Layout/Primary.vue';
import Stats from './Partials/Stats.vue';
import ClicksHistory from './Partials/ClicksHistory.vue';
import ClicksByField from './Partials/ClicksByField.vue';
import type { Link } from '@/types/link';

defineProps<{
    totalLinks: number;
    totalClicks: number;
    clicksHistory: { day: number, count: number }[];
    clicksByPlatform: { label: string, count: number }[];
    clicksByDevice: { label: string, count: number }[];
    topLinks: Link[]
}>()

</script>
<template>
    <Primary>
        <div class="flex flex-col gap-5 p-2">
            <section class="flex items-center justify-between">
                <div class="text-2xl font-bold">
                    Dashboard
                </div>
            </section>

            <Stats :links="totalLinks" :clicks="totalClicks" />
            <div class="grid-cols-3 xl:grid">
                <div class="xl:col-span-2">
                    <ClicksHistory :clicks-history="clicksHistory" />
                    <div class="flex flex-col gap-2 p-3">
                        <div class="flex items-center justify-between">
                            <h1 class="text-sm font-semibold">Top {{ topLinks.length }} Links</h1>
                            <A :href="route('links.index', { sort: 'clicks_count.desc' })"
                                class="flex items-center gap-1 p-1 text-sm font-medium hover:underline text-dark/80">
                                View All <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-arrow-up-right-circle" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8m15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.854 10.803a.5.5 0 1 1-.708-.707L9.243 6H6.475a.5.5 0 1 1 0-1h3.975a.5.5 0 0 1 .5.5v3.975a.5.5 0 1 1-1 0V6.707z" />
                                </svg>
                            </A>
                        </div>
                        <div class="flex flex-col border divide-y divide-gray-100 rounded-md">
                            <div v-for="link, i in topLinks" :key="link.id"
                                class="flex items-center justify-between gap-2 transition-all hover:bg-gray-100">
                                <div class="flex items-center gap-2">
                                    <div class="p-2 bg-gray-100 clear-start">
                                        #{{ i + 1 }}
                                    </div>
                                    <div class="p-1">
                                        {{ link.url }}
                                    </div>
                                </div>
                                <div class="flex items-center gap-1 p-2">
                                    {{ link.clicks }}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-hand-index-thumb-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M8.5 1.75v2.716l.047-.002c.312-.012.742-.016 1.051.046.28.056.543.18.738.288.273.152.456.385.56.642l.132-.012c.312-.024.794-.038 1.158.108.37.148.689.487.88.716q.113.137.195.248h.582a2 2 0 0 1 1.99 2.199l-.272 2.715a3.5 3.5 0 0 1-.444 1.389l-1.395 2.441A1.5 1.5 0 0 1 12.42 16H6.118a1.5 1.5 0 0 1-1.342-.83l-1.215-2.43L1.07 8.589a1.517 1.517 0 0 1 2.373-1.852L5 8.293V1.75a1.75 1.75 0 0 1 3.5 0" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <ClicksByField :by-platform="clicksByPlatform" :by-device="clicksByDevice" />
                </div>
            </div>
        </div>
    </Primary>
</template>
