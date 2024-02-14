<script setup lang="ts">
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, PointElement, LineElement, ArcElement, Colors, RadialLinearScale, Filler, Chart, type ChartConfiguration, type ChartType, Scale, scales, } from "chart.js";
import { Bar, Line, Pie, Doughnut, Radar } from "vue-chartjs";
import { ref, shallowRef, onMounted, onUnmounted } from "vue";

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    ArcElement,
    Colors,
    Filler,
    RadialLinearScale,
);

const props = defineProps<{
    config: ChartConfiguration;
}>();

const availableCharts = shallowRef<{
    [key: string]: any
}>({
    line: Line,
    bar: Bar,
    pie: Pie,
    doughnut: Doughnut,
    radar: Radar
});

const chart = ref<{ chart: Chart }>()
const chartType = shallowRef(availableCharts.value[props.config.type])

onMounted(() => window.addEventListener('resize', () => chart.value!.chart.resize()))
onUnmounted(() => window.removeEventListener('resize', () => chart.value!.chart.resize()))
</script>

<template>
    <div class="w-full h-full">
        <component :is="chartType" ref="chart" :data="config.data" :options="config.options" />
    </div>
</template>
