<template>
    <div>
      <label :for="label" class="block dark:text-white text-black text-sm font-bold mb-2">{{ label }}</label>
      <select 
        :value="modelValue" 
        @input="$emit('update:modelValue', $event.target.value)" 
        class="block appearance-none w-full dark:bg-neutral-800 bg-white border border-gray-400 dark:border-purple-700 hover:border-gray-500 dark:hover:border-purple-900 dark:text-white text-black px-4 py-2 pr-8 rounded shadow leading-tight focus:outline-none focus:shadow-outline"
      >
        <option value="">All {{ label.split(' ')[2] }}</option>
        <option v-for="option in options" :key="option" :value="option">{{ option }}</option>
      </select>
    </div>
  </template>
  
  <script setup>
  import { defineProps } from 'vue';
  
  const props = defineProps({
    modelValue: String,
    options: Array,
    label: String,
  });
  </script>
  