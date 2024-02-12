<script setup lang="ts">
import Primary from '@/Layout/Primary.vue';
import Stats from './Partials/Stats.vue';
import ClicksHistory from './Partials/ClicksHistory.vue';
import ClicksByField from './Partials/ClicksByField.vue';

defineProps<{
    totalLinks: number;
    totalClicks: number;
    clicksHistory: { day: number, count: number }[];
    clicksByPlatform: { label: string, count: number }[];
    clicksByDevice: { label: string, count: number }[];
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
                </div>
                <div>
                    <ClicksByField :by-platform="clicksByPlatform" :by-device="clicksByDevice" />
                </div>
            </div>
        </div>
    </Primary>
</template>
