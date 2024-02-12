<script setup lang="ts">
const props = defineProps<{
    links: number;
    clicks: number;
}>()
</script>

<template>
    <div class="grid grid-cols-2 gap-2">
        <div class="flex items-center gap-3 p-2 border border-teal-100 bg-teal-50 rounded-xl">
            <div class="p-2 text-teal-500 bg-teal-100 border border-teal-200 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-7 h-7" viewBox="0 0 16 16">
                    <path
                        d="M6.354 5.5H4a3 3 0 0 0 0 6h3a3 3 0 0 0 2.83-4H9q-.13 0-.25.031A2 2 0 0 1 7 10.5H4a2 2 0 1 1 0-4h1.535c.218-.376.495-.714.82-1z" />
                    <path
                        d="M9 5.5a3 3 0 0 0-2.83 4h1.098A2 2 0 0 1 9 6.5h3a2 2 0 1 1 0 4h-1.535a4 4 0 0 1-.82 1H12a3 3 0 1 0 0-6z" />
                </svg>
            </div>
            <div>
                <div class="text-sm font-semibold">
                    Total Links
                </div>
                <div class="text-xl font-medium">
                    {{ links }}
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3 p-2 border border-orange-100 bg-orange-50 rounded-xl">
            <div class="p-2 text-orange-500 bg-orange-100 border border-orange-200 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-6 h-6" viewBox="0 0 16 16">
                    <path
                        d="M8.5 1.75v2.716l.047-.002c.312-.012.742-.016 1.051.046.28.056.543.18.738.288.273.152.456.385.56.642l.132-.012c.312-.024.794-.038 1.158.108.37.148.689.487.88.716q.113.137.195.248h.582a2 2 0 0 1 1.99 2.199l-.272 2.715a3.5 3.5 0 0 1-.444 1.389l-1.395 2.441A1.5 1.5 0 0 1 12.42 16H6.118a1.5 1.5 0 0 1-1.342-.83l-1.215-2.43L1.07 8.589a1.517 1.517 0 0 1 2.373-1.852L5 8.293V1.75a1.75 1.75 0 0 1 3.5 0" />
                </svg>
            </div>
            <div>
                <div class="text-sm font-semibold">
                    Total Cicks
                </div>
                <div class="text-xl font-medium">
                    {{ clicks }}
                </div>
            </div>
        </div>
    </div>
</template>
