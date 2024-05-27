<template>
    <AuthenticatedLayout>
      <div class="container mx-auto px-4 py-10">
        <div class="p-6 bg-gray-500 rounded-xl">
          <h4 class="text-xl font-semibold text-white content-center">Saved Materials</h4>
          <div class="mb-4">
            <label for="sort" class="text-white">Sort by:</label>
            <select id="sort" v-model="sortCriterion" @change="sortMaterials" class="ml-2 p-1 rounded">
              <option value="species">Species</option>
              <option value="price">Price</option>
              <option value="date">Date</option>
            </select>
          </div>
          <div v-if="sortedMaterials.length">
            <div class="space-y-4">
              <div v-for="material in sortedMaterials" :key="material.id" class="p-4 bg-gray-600 rounded-md">
                <div class="flex items-center space-x-4 mb-4">
                  <div class="flex self-start w-14 h-14 items-center justify-center rounded-md bg-gray-700">
                    <img class="bg-contain" :src="logicon">
                  </div>
                  <div>
                    <h5 class="text-sm leading-none font-semibold text-gray-100">{{ material.timber_species.speacies }}</h5>
                    <span class="text-xs leading-none text-gray-300 font-medium">Class: {{ material.timber_species.class }}</span>
                  </div>
                  <button @click="deleteMaterial(material.id)" class="text-red-500">Delete</button>
                </div>
                <div class="grid grid-cols-2 gap-4 text-gray-100">
                  <div>
                    <p><strong>Location:</strong> {{ material.timber_species.location }}</p>
                    <p><strong>Length:</strong> {{ material.timber_species.length }} m</p>
                  </div>
                  <div>
                    <p><strong>Diameter:</strong> {{ material.timber_species.diameter }} cm</p>
                    <p><strong>Date Recorded:</strong> {{ material.timber_species.date }}</p>
                    <p><strong>Current Price:</strong> {{ material.timber_species.price }} $</p>
                    <p><strong>Initial Price:</strong> {{ material.initial_price }} $</p>
                    <p><strong>Price Change:</strong> {{ material.price_change }} $ ({{ material.price_change_percentage.toFixed(2) }}%)</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            <p>No materials saved yet.</p>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import { computed, ref, watch } from 'vue';
  import { usePage } from '@inertiajs/vue3';
  import { Inertia } from '@inertiajs/inertia';
  import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
  import timberlog from '../icons/timber/logs.png';
  const logicon = computed(() => timberlog);
  
  const { props } = usePage();
  const savedMaterials = computed(() => props.savedMaterials ?? []);
  
  const sortCriterion = ref(props.sort || 'species');
  
  const sortedMaterials = computed(() => {
    return [...savedMaterials.value].sort((a, b) => {
      if (sortCriterion.value === 'price') {
        return a.timber_species.price - b.timber_species.price;
      } else if (sortCriterion.value === 'date') {
        return new Date(a.timber_species.date) - new Date(b.timber_species.date);
      } else {
        return a.timber_species.speacies.localeCompare(b.timber_species.speacies);
      }
    });
  });
  
  const sortMaterials = () => {
    Inertia.visit(window.location.href.split('?')[0], {
      method: 'get',
      data: { sort: sortCriterion.value },
      preserveState: true,
    });
  };
  
  const deleteMaterial = (id) => {
    if (confirm('Are you sure you want to delete this material?')) {
      Inertia.delete(`/saved-materials/${id}`, {
        onSuccess: () => {
          window.location.reload(); // Force a full-page reload
        }
      });
    }
  };
  
  watch(sortCriterion, sortMaterials);
  </script>
  