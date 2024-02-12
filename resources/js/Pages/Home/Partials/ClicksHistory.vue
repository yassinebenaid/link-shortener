<script setup lang="ts">
import Chart from '@/Components/Chart.vue';
import type { ChartConfiguration } from 'chart.js';

const props = defineProps<{
    clicksHistory: { day: number, count: number }[]
}>()

const config: ChartConfiguration = {
    type: 'line',
    options: {
        plugins: {
            legend: { position: 'bottom' }
        }
    },
    data: {
        labels: props.clicksHistory.map(e => e.day),
        datasets: [{
            label: 'Clicks',
            data: props.clicksHistory.map(e => e.count),
            pointStyle: false,
            fill: true,
        }],
    }
}
</script>

<template>
    <div class="flex flex-col gap-2 p-3">
        <h1 class="text-sm font-semibold">Clicks In Last 30 Days</h1>
        <Chart :config="config" />
    </div>
</template>
