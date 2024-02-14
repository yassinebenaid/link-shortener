<script setup lang="ts">
import Primary from '@/Layout/Primary.vue';
import Stats from './Partials/Stats.vue';
import ClicksHistory from './Partials/ClicksHistory.vue';
import ClicksByField from './Partials/ClicksByField.vue';
import type { Link } from '@/types/link';
import TopLinks from './Partials/TopLinks.vue';

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
                <div>
                    <A :href="route('links.index')"
                        class="flex items-center gap-1 p-2 transition-all bg-gray-100 border border-gray-200 rounded-md hover:bg-gray-300 active:bg-gray-100">
                        My Links
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 16 16">
                                <path fill-rule="evenodd"
                                    d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8" />
                            </svg>
                        </div>
                    </A>
                </div>
            </section>

            <Stats :links="totalLinks" :clicks="totalClicks" />
            <div class="grid-cols-3 xl:grid">
                <div class="xl:col-span-2">
                    <ClicksHistory :clicks-history="clicksHistory" />
                    <TopLinks :top-links="topLinks" />
                </div>
                <div>
                    <ClicksByField :by-platform="clicksByPlatform" :by-device="clicksByDevice" />
                </div>
            </div>
        </div>
    </Primary>
</template>
