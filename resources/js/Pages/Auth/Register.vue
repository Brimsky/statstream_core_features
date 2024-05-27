<template>
    <div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-gray-200 to-gray-300 dark:from-neutral-700 dark:to-neutral-800">
      <a href="#" class="flex mb-6 p-6 text-2xl font-semibold text-gray-900 dark:text-white">
        <img class="scale-50" :src="iconSrc" alt="Icon" />
        STATSTREAM    
      </a>
      <div class="p-6 bg-white dark:bg-neutral-700 rounded-lg shadow">
        <!-- <img class="scale-50" :src="imgSrc" alt="Icon" /> -->
        <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                  Sign up for your account
              </h1>
      <form @submit.prevent="submit" class="mt-8 grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-3">
              <div :src="iconSrc" class="block text-sm font-medium text-gray-700 dark:text-white">
                First Name
              </div>
  
              <input
                type="text" v-model="form.name"
                placeholder="Bob"
                id="FirstName"
                name="first_name"
                class="mt-1 w-full rounded-md border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-600 text-sm text-gray-700 dark:text-white shadow-sm"
              />
            </div>
            
            <div class="col-span-6 sm:col-span-3">
              <label for="LastName" class="block text-sm font-medium text-gray-700 dark:text-white">
                Last Name
              </label>
  
              <input
                type="text"
                placeholder="Marley"
                id="LastName"
                name="last_name"
                class="mt-1 w-full rounded-md border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-600 text-sm text-gray-700 dark:text-white shadow-sm"
              />
            </div>
  
            <div class="col-span-6">
              <label for="Email" class="block text-sm font-medium text-gray-700 dark:text-white"> Email </label>
  
              <input
                type="email" v-model="form.email"
                id="Email"
                placeholder="youremail.@mail.com"
                name="email"
                class="mt-1 w-full rounded-md border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-600 text-sm text-gray-700 dark:text-white shadow-sm"
              />
            </div>
  
            <div class="col-span-6 sm:col-span-3">
              <label for="Password" class="block text-sm font-medium text-gray-700 dark:text-white"> Password </label>
  
              <input
                type="password" v-model="form.password"
                id="Password"
                placeholder="••••••••"
                name="password"
                class="mt-1 w-full rounded-md border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-600 text-sm text-gray-700 dark:text-white shadow-sm"
              />
            </div>
  
            <div class="col-span-6 sm:col-span-3">
              <label for="PasswordConfirmation" class="block text-sm font-medium text-gray-700 dark:text-white">
                Password Confirmation
              </label>
  
              <input
                type="password" v-model="form.password_confirmation"
                id="PasswordConfirmation"
                placeholder="••••••••"
                name="password_confirmation"
                class="mt-1 w-full rounded-md border-gray-200 dark:border-neutral-700 bg-white dark:bg-neutral-600 text-sm text-gray-700 dark:text-white shadow-sm"
              />
            </div>
  
            
  
            <div class="col-span-6">
              <p class="text-sm text-gray-500 dark:text-white">
                By creating an account, you agree to our
                <a href="#" class="text-gray-700 underline dark:text-white"> terms and conditions </a>
                and
                <a href="#" class="text-gray-700 underline dark:text-white">privacy policy</a>.
              </p>
            </div>
  
            <div class="col-span-6 sm:flex sm:items-center sm:gap-4">
              <button type="submit"
                class="inline-block shrink-0 rounded-md border border-blue-600 dark:border-purple-600 bg-blue-600 dark:bg-purple-600 px-12 py-3 text-sm font-medium text-white dark:text-black transition hover:bg-transparent dark:hover:bg-transparent hover:text-blue-600 dark:hover:text-purple-600 focus:outline-none focus:ring active:text-blue-500 dark:active:text-purple-500"
                :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                >
                Create an account
              </button>
  
              <p class="mt-4 text-sm text-gray-500 sm:mt-0 dark:text-white" >
                Already have an account?
                <a href="/login" class="text-gray-700 dark:text-white underline">Log in</a>.
              </p>
            </div>
            <InputError class="mt-2" :message="form.errors.name" />
            <InputError class="mt-2" :message="form.errors.email" />
            <InputError class="mt-2" :message="form.errors.password" />
            <InputError class="mt-2" :message="form.errors.password_confirmation" />
          </form>
    </div>
    </div>

  </template>

  
  <script setup>
  import lightIcon from '@/icons/Logo/icon.png';
  import darkIcon from '@/icons/Logo/darkicon.png';
  import { useForm } from '@inertiajs/vue3';
  import { computed } from 'vue';
  import { useDark} from '@vueuse/core';

  const isDark = useDark();
  const iconSrc = computed(() => isDark.value ? darkIcon : lightIcon);
  
  
  const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
  });
  
  const submit = () => {
    form.post(route('register'), {
      onFinish: () => form.reset('password', 'password_confirmation'),
    });
  };
  </script>