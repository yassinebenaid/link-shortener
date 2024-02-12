<script setup lang="ts">
import Primary from '@/Layout/Primary.vue';
import Stats from './Partials/Stats.vue';
import ClicksHistory from './Partials/ClicksHistory.vue';

const props = defineProps<{
    totalLinks: number;
    totalClicks: number;
    clicksHistory: { day: number, count: number }[]
}>()

console.log(props.clicksHistory)
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
            <ClicksHistory :clicks-history="clicksHistory" />
        </div>
    </Primary>
</template>
