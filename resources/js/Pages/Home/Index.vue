<script setup>
import Primary from '@/Layout/Primary.vue';
import Stats from './Partials/Stats.vue';

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
                <Stats />
            </section>
        </div>
    </Primary>
</template>
