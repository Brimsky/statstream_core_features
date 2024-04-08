<template>
    <div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-gray-200 to-gray-300 dark:from-neutral-700 dark:to-neutral-800">
      <form @submit.prevent="submit" class="mt-8 grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-3">
              <label for="FirstName" class="block text-sm font-medium text-gray-700">
                First Name
              </label>
  
              <input
                type="text" v-model="form.name"
                id="FirstName"
                name="first_name"
                class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm"
              />
            </div>
            
            <div class="col-span-6 sm:col-span-3">
              <label for="LastName" class="block text-sm font-medium text-gray-700">
                Last Name
              </label>
  
              <input
                type="text"
                id="LastName"
                name="last_name"
                class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm"
              />
            </div>
  
            <div class="col-span-6">
              <label for="Email" class="block text-sm font-medium text-gray-700"> Email </label>
  
              <input
                type="email" v-model="form.email"
                id="Email"
                name="email"
                class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm"
              />
            </div>
  
            <div class="col-span-6 sm:col-span-3">
              <label for="Password" class="block text-sm font-medium text-gray-700"> Password </label>
  
              <input
                type="password" v-model="form.password"
                id="Password"
                name="password"
                class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm"
              />
            </div>
  
            <div class="col-span-6 sm:col-span-3">
              <label for="PasswordConfirmation" class="block text-sm font-medium text-gray-700">
                Password Confirmation
              </label>
  
              <input
                type="password" v-model="form.password_confirmation"
                id="PasswordConfirmation"
                name="password_confirmation"
                class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm"
              />
            </div>
  
            <div class="col-span-6">
              <label for="MarketingAccept" class="flex gap-4">
                <input
                  type="checkbox"
                  id="MarketingAccept"
                  name="marketing_accept"
                  class="size-5 rounded-md border-gray-200 bg-white shadow-sm"
                />
  
                <span class="text-sm text-gray-700">
                  I want to receive emails about events, product updates and company announcements.
                </span>
              </label>
            </div>
  
            <div class="col-span-6">
              <p class="text-sm text-gray-500">
                By creating an account, you agree to our
                <a href="#" class="text-gray-700 underline"> terms and conditions </a>
                and
                <a href="#" class="text-gray-700 underline">privacy policy</a>.
              </p>
            </div>
  
            <div class="col-span-6 sm:flex sm:items-center sm:gap-4">
              <button type="submit"
                class="inline-block shrink-0 rounded-md border border-blue-600 bg-blue-600 px-12 py-3 text-sm font-medium text-white transition hover:bg-transparent hover:text-blue-600 focus:outline-none focus:ring active:text-blue-500"
                :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                >
                Create an account
              </button>
  
              <p class="mt-4 text-sm text-gray-500 sm:mt-0">
                Already have an account?
                <a href="#" class="text-gray-700 underline">Log in</a>.
              </p>
            </div>
            <InputError class="mt-2" :message="form.errors.name" />
            <InputError class="mt-2" :message="form.errors.email" />
            <InputError class="mt-2" :message="form.errors.password" />
            <InputError class="mt-2" :message="form.errors.password_confirmation" />
          </form>
    </div>

  </template>


<!-- <template>
  <form action="#" class="mt-8 grid grid-cols-6 gap-6">
            <div class="col-span-6 sm:col-span-3">
              <label for="FirstName" class="block text-sm font-medium text-gray-700">
                First Name
              </label>
  
              <input
                type="text" v-model="form.name"
                id="FirstName"
                name="first_name"
                class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm"
              />
            </div>
            
            <div class="col-span-6 sm:col-span-3">
              <label for="LastName" class="block text-sm font-medium text-gray-700">
                Last Name
              </label>
  
              <input
                type="text"
                id="LastName"
                name="last_name"
                class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm"
              />
            </div>
  
            <div class="col-span-6">
              <label for="Email" class="block text-sm font-medium text-gray-700"> Email </label>
  
              <input
                type="email" v-model="form.email"
                id="Email"
                name="email"
                class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm"
              />
            </div>
  
            <div class="col-span-6 sm:col-span-3">
              <label for="Password" class="block text-sm font-medium text-gray-700"> Password </label>
  
              <input
                type="password" v-model="form.password"
                id="Password"
                name="password"
                class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm"
              />
            </div>
  
            <div class="col-span-6 sm:col-span-3">
              <label for="PasswordConfirmation" class="block text-sm font-medium text-gray-700">
                Password Confirmation
              </label>
  
              <input
                type="password" v-model="form.password_confirmation"
                id="PasswordConfirmation"
                name="password_confirmation"
                class="mt-1 w-full rounded-md border-gray-200 bg-white text-sm text-gray-700 shadow-sm"
              />
            </div>
  
            <div class="col-span-6">
              <label for="MarketingAccept" class="flex gap-4">
                <input
                  type="checkbox"
                  id="MarketingAccept"
                  name="marketing_accept"
                  class="size-5 rounded-md border-gray-200 bg-white shadow-sm"
                />
  
                <span class="text-sm text-gray-700">
                  I want to receive emails about events, product updates and company announcements.
                </span>
              </label>
            </div>
  
            <div class="col-span-6">
              <p class="text-sm text-gray-500">
                By creating an account, you agree to our
                <a href="#" class="text-gray-700 underline"> terms and conditions </a>
                and
                <a href="#" class="text-gray-700 underline">privacy policy</a>.
              </p>
            </div>
  
            <div class="col-span-6 sm:flex sm:items-center sm:gap-4">
              <button type="submit"
                class="inline-block shrink-0 rounded-md border border-blue-600 bg-blue-600 px-12 py-3 text-sm font-medium text-white transition hover:bg-transparent hover:text-blue-600 focus:outline-none focus:ring active:text-blue-500"
              >
                Create an account
              </button>
  
              <p class="mt-4 text-sm text-gray-500 sm:mt-0">
                Already have an account?
                <a href="#" class="text-gray-700 underline">Log in</a>.
              </p>
            </div>
          </form>
</template> -->

  
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
  