<template>
  <AuthenticatedLayout>
    <div class="dark:bg-neutral-800 mx-auto py-10">
      <div class="text-center">
        <h1 class="mb-4 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl">
          <span class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">Timber Analytics</span>
        </h1>
        <p class="text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">
          Empowering the timber industry with cutting-edge analytics and insights that drive sustainable growth and innovation.
        </p>
      </div>
    </div>
      <div class="max-w-md mx-auto mt-10 p-6 bg-white dark:bg-neutral-800 rounded-xl shadow-lg">
        <div class="text-center dark:text-white text-black">
        <h2 class="text-2xl font-bold mb-4">Total Timber Volume in Database</h2>
        <div class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2 transition duration-150">{{ timberCount }}</div>
      </div>
    </div>
      <div class="max-w-md mx-auto mt-10 p-6 bg-white dark:bg-neutral-800 rounded-xl shadow-lg">
        <div class="text-center dark:text-white text-black">
        <h2 class="text-2xl font-bold mb-4">Number of Users</h2>
        <div class="text-white bg-gradient-to-r from-purple-500 via-purple-600 to-purple-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-purple-300 dark:focus:ring-purple-800 shadow-lg shadow-purple-500/50 dark:shadow-lg dark:shadow-purple-800/80 font-medium rounded-lg text-sm px-5 py-2.5 text-center mb-2 transition duration-150">{{ userCount }}</div>
      </div>
    </div>

  </AuthenticatedLayout>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import axios from 'axios';

// State to store user count
const userCount = ref(0);
const timberCount = ref(0);
const vipCount = ref(0);


// Fetch user count from the backend
const fetchUserCount = async () => {
  try {
    const response = await axios.get('/api/user-count');
    userCount.value = response.data.userCount;
  } catch (error) {
    console.error('Error fetching user count:', error);
  }
};

console.log(vipCount);

const fetchtimberCount = async () => {
  try {
    const response = await axios.get('/api/timber-count');
    timberCount.value = response.data.timberCount;
  } catch (error) {
    console.error('Error fetching user count:', error);
  }
};

onMounted(() => {
  fetchtimberCount();
  fetchUserCount();
});

</script>
