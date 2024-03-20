<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useDark, useToggle} from '@vueuse/core';
  
import lightIcon from '../icons/Logo/icon.png';
import darkIcon from '../icons/Logo/darkicon.png';
  
import lightmode from '../icons/Mode/sun.png'
import darkmode from '../icons/Mode/moon.png'
  
const isDark = useDark();
const toggleDark = useToggle(isDark);
console.log(isDark.value);
  
const mode = computed(() => isDark.value ? darkmode : lightmode);
const iconSrc = computed(() => isDark.value ? darkIcon : lightIcon);


</script>

<template>
<div class="dark:text-white dark:bg-neutral-800 flex justify-between items-center h-[70px] m-0 px-[15px] py-0">
    <div class="flex items-center justify-center mx-12 w-11/12">
      <div class="container flex items-center">
        <img class="scale-50" :src="iconSrc" alt="Icon" />
        <div  class="dark:text-white text-black text-lg font-bold">StatStream</div>
      </div>
      <div  v-if="canLogin" class="hidden md:flex space-x-10">
        <Link  class="navbar-btn delay-30">Home</Link>
        <div class="hidden md:flex space-x-10">
            <Link :href="route('login')" class="navbar-btn delay-30">Login</Link>
            <Link v-if="canRegister" :href="route('register')" class="navbar-btn delay-30">Sign up</Link>
        </div>
        <Link v-if="$page.props.auth.user" :href="route('dashboard')">Dashboard</Link>
        <button  class="dark:bg-stone-50 dark:text-black text-white font-bold py-1.5 px-4 rounded-xl justify-center dark:hover:bg-stone-400 dark:hover:shadow-lg  bg-stone-900 hover:shadow-lg transition delay-30" @click="toggleDark()"><img class="object-scale-down h-7 w-10" :src="mode" alt="Icon" /></button>
    </div>
    </div>
</div>
</template>

