<template>
  <AuthenticatedLayout>
    <div class="flex flex-col items-center justify-center mx-auto">
      <h1 class="text-5xl font-bold py-10">Available Species</h1>
      <div class="grid grid-cols-3 gap-6">
        <div v-for="item in species" :key="item.speacies" class="cursor-pointer">
          <Link :href="route('timber-chart.show', { species: item.speacies })" class="block overflow-hidden bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300 ease-in-out">
            <img :src="'https://picsum.photos/300/200?random=' + item.species" alt="" class="w-full h-48 object-cover">
            <div class="p-6">
              <h2 class="text-2xl font-bold tracking-tight text-gray-900">{{ item.speacies }}</h2>
            </div>
          </Link>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  species: Array
});

console.log(props.species);
</script>
