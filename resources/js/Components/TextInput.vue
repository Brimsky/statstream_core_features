<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 bg-white dark:bg-neutral-900 dark:text-white leading-tight focus:outline-none focus:border-blue-500 focus:ring focus:ring-blue-200 dark:focus:border-violet-500 dark:focus:ring-violet-500"
        v-model="model"
        ref="input"
    />
</template>
