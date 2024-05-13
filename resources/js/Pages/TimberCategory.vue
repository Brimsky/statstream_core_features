<template>
  <AuthenticatedLayout>
    <div class="flex flex-col items-center justify-center mx-auto">
      <h1 class="text-5xl font-bold py-10">Available Species</h1>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div v-for="item in species" :key="item.speacies" class="cursor-pointer">
          <Link :href="route('timber-chart.show', { species: item.speacies })" class="block overflow-hidden bg-white rounded-lg shadow hover:shadow-lg transition-shadow duration-300 ease-in-out">
            <div class="aspect-w-1 aspect-h-1 w-full overflow-hidden">
              <img :src="item.imageUrl" alt="" class="object-cover">
            </div>
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
import Footer from '../Components/Footers/Footer.vue';

const props = defineProps({
  species: Array
});

console.log(props.species);
</script>