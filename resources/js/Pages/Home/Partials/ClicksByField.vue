<script setup lang="ts">
import Chart from '@/Components/Chart.vue';
import type { ChartConfiguration } from 'chart.js';

const props = defineProps<{
    byPlatform: { label: string, count: number }[]
    byDevice: { label: string, count: number }[]
}>()

const byPlatformConfig: ChartConfiguration = {
    type: 'radar',
    options: {
        plugins: {
            legend: { position: 'bottom' }
        }
    },
    data: {
        labels: props.byPlatform.map(e => e.label),
        datasets: [{
            label: 'Clicks',
            data: props.byPlatform.map(e => e.count),
            pointStyle: false,
            fill: true,
            backgroundColor: '#e76f5188',
            borderColor: "#e76f51"
        }],
    }
}

const byDeviceConfig: ChartConfiguration = {
    type: 'radar',
    options: {
        plugins: {
            legend: { position: 'bottom' }
        }
    },
    data: {
        labels: props.byDevice.map(e => e.label),
        datasets: [{
            label: 'Clicks',
            data: props.byDevice.map(e => e.count),
            pointStyle: false,
            fill: true,
            backgroundColor: '#00afb988',
            borderColor: "#00afb9"
        }],
    }
}
</script>

<template>
    <div class="grid grid-cols-2 xl:grid-cols-1">
        <div class="flex flex-col gap-2 p-3">
            <h1 class="text-sm font-semibold">Clicks By Platform</h1>
            <Chart :config="byPlatformConfig" />
        </div>
        <div class="flex flex-col gap-2 p-3">
            <h1 class="text-sm font-semibold">Clicks By Device</h1>
            <Chart :config="byDeviceConfig" />
        </div>
    </div>
</template>
