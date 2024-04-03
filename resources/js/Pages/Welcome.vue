<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useDark, useToggle} from '@vueuse/core';
  
import lightIcon from '../icons/Logo/icon.png';
import darkIcon from '../icons/Logo/darkicon.png';
  
import lightmode from '../icons/Mode/sun.png'
import darkmode from '../icons/Mode/moon.png'

import Start from '../Components/Home/About.vue';
import Footer from '../Components/Footers/Footer.vue';
const isDark = useDark();
const toggleDark = useToggle(isDark);
console.log(isDark.value);
  
const mode = computed(() => isDark.value ? darkmode : lightmode);
const iconSrc = computed(() => isDark.value ? darkIcon : lightIcon);
import { defineProps } from 'vue';
defineProps({
    canLogin: {
        type: Boolean,
        required: true,
    },
    canRegister: {
        type: Boolean,
        required: true,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

</script>

<template class="antialiased bg-neutral-900">
<!-- Navbar -->
<div class="text-white  dark:bg-neutral-800 flex h-[60px] m-0 px-[35px] py-0">
    <div class="flex items-center justify-center mx-auto w-11/12">
      <div class="container flex items-center ">
        <a href="/">
          <img class="scale-50" :src="iconSrc" alt="Icon" />
        </a>
        <a  href="/" class="dark:text-white text-black text-3xl tracking-wider font-bold">STATSTREAM</a>
        </div>
      <div v-if="canLogin" class="flex items-center space-x-6">
        <template v-if="$page.props.auth.user">
          <Link :href="route('dashboard')"
                class="navbar-btn">
            Dashboard
          </Link>
          <button @click="toggleDark()"
                  class="py-2 px-4 bg-stone-900 hover:bg-stone-700 dark:hover:bg-stone-400 dark:bg-white  text-white font-bold rounded-xl shadow-md transition duration-150">
            <img class="h-7" :src="mode" alt="Dark Mode Icon" />
          </button>
        </template>
        <template v-else>
          <Link :href="route('login')"
                class="navbar-btn">
            Log in
          </Link>
          <Link v-if="canRegister" :href="route('register')"
                class="navbar-btn">
            Register
          </Link>
          <button @click="toggleDark()"
                  class="py-2 px-4 bg-stone-900 hover:bg-stone-700 dark:hover:bg-stone-400 dark:bg-white  text-white font-bold rounded-xl shadow-md transition duration-150">
            <img class="h-7" :src="mode" alt="Dark Mode Icon" />
          </button>
        </template>
      </div>
    </div>
</div>
<!-- Home page -->
<Start />


<!-- Footer -->
<Footer />

</template>

