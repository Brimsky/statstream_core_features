<template>
  <section class="min-h-screen justify-center items-center bg-gradient-to-r from-gray-200 to-gray-300 dark:from-neutral-700 dark:to-neutral-800">
    <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
        <img class="scale-50" :src="iconSrc" alt="Icon" />
        STATSTREAM
      </a>
      <div @submit.prevent="submit" class="w-full rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 bg-white dark:bg-neutral-700 dark:border-neutral-700">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">Log in to your account</h1>
          <form class="space-y-4 md:space-y-6">
            <div>
              <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
              <input type="text" name="email" id="email" placeholder="name@gmail.com" v-model="form.email" required class="mt-1 w-full rounded-md border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-600 text-sm text-gray-700 dark:text-white shadow-sm">
              <InputError :message="form.errors.email" />
            </div>
            <div>
              <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
              <input type="password" name="password" id="password" placeholder="••••••••" class="mt-1 w-full rounded-md border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-600 text-sm text-gray-700 dark:text-white shadow-sm" v-model="form.password" required>
              <InputError :message="form.errors.password" />
            </div>
            <div class="flex items-center justify-between">
              <div class="flex items-start">
                <div class="flex items-center h-5">
                  <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800">
                </div>
                <div class="ml-3 text-sm">
                  <label class="text-gray-500 dark:text-gray-300">Remember me</label>
                </div>
              </div>
              <a href="#" class="text-sm font-medium hover:underline text-gray-500 dark:text-gray-300">Forgot password?</a>
            </div>
            <button type="submit" class="w-full shrink-0 rounded-md border border-blue-600 dark:border-purple-600 bg-blue-600 dark:bg-purple-600 px-12 py-3 text-sm font-medium text-white dark:text-black transition hover:bg-transparent dark:hover:bg-transparent hover:text-blue-600 dark:hover:text-purple-600 focus:outline-none focus:ring active:text-blue-500 dark:active:text-purple-500" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Sign in</button>
            <p class="text-sm font-light text-gray-500 dark:text-gray-400">Don’t have an account yet? <a href="/register" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign up</a></p>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import lightIcon from '@/icons/Logo/icon.png';
import darkIcon from '@/icons/Logo/darkicon.png';
import { useForm } from '@inertiajs/vue3';
import { computed } from 'vue';
import { useDark } from '@vueuse/core';
import InputError from '@/Components/InputError.vue';  

const isDark = useDark();
const iconSrc = computed(() => isDark.value ? darkIcon : lightIcon);

const form = useForm({
  email: '',
  password: '',
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>
