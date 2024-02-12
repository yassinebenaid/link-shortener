<script setup lang="ts">
import Primary from '@/Layout/Primary.vue';
import Stats from './Partials/Stats.vue';

const props = defineProps<{
    totalLinks: number;
    totalClicks: number;
}>()
</script>
<template>
    <Primary>
        <div class="flex flex-col gap-10 p-2">
            <section class="flex items-center justify-between">
                <div class="text-2xl font-bold">
                    Dashboard
                </div>
            </section>
            <section>
                <Stats :links="totalLinks" :clicks="totalClicks" />
            </section>
        </div>
    </Primary>
</template>
