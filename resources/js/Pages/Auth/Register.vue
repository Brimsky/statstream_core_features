<template>
    <div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-gray-200 to-gray-300 dark:from-neutral-700 dark:to-neutral-800">
      <form class="w-full max-w-2xl bg-white dark:bg-neutral-900 shadow-md px-8 pt-6 pb-8 mb-4 rounded-lg" @submit.prevent="submit">
        <div class="mb-6">
          <h2 class="text-center text-5xl font-bold text-black dark:text-white">Sign up</h2>
        </div>
        <div class="mb-4">
          <label class="block text-black dark:text-gray-200 text-sm font-bold mb-2">Name</label>
          <input type="text" v-model="form.name" class="form-input focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-violet-500">
          <InputError class="mt-2" :message="form.errors.name" />
        </div>
        <div class="mb-4">
          <label class="block text-black dark:text-gray-200 text-sm font-bold mb-2">Email</label>
          <input type="email" v-model="form.email" class="form-input focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-violet-500">
          <InputError class="mt-2" :message="form.errors.email" />
        </div>
        <div class="mb-4">
          <label class="block text-black dark:text-gray-200 text-sm font-bold mb-2">Password</label>
          <input type="password" v-model="form.password" class="form-input focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-violet-500">
          <InputError class="mt-2" :message="form.errors.password" />
        </div>
        <div class="mb-4">
          <label class="block text-black dark:text-gray-200 text-sm font-bold mb-2">Confirm password</label>
          <input type="password" v-model="form.password_confirmation" class="form-input focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-violet-500">
          <InputError class="mt-2" :message="form.errors.password_confirmation" />
        </div>
        <div class=" mb-4 flex items-center justify-center">
          <h4 class="text-black dark:text-gray-200">Already have an account? <router-link to="/login" class="transition duration-100 ease-in-out hover:text-blue-400 dark:hover:text-green-400">Click here!</router-link></h4>
        </div>
        <div class="flex items-center justify-between">
          <button type="submit" class="form-button" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
            Sign Up
          </button>
        </div>
      </form>
    </div>
  </template>
  
  <script setup>
  import { useForm } from '@inertiajs/vue3';

  
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
  