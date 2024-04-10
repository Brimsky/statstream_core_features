<!-- <template>
    <div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-gray-200 to-gray-400 dark:from-neutral-700 dark:to-neutral-800">
      <form class="w-full max-w-2xl bg-white dark:bg-neutral-900 shadow-md px-8 pt-6 pb-8 mb-4 rounded-lg" @submit.prevent="submit">
        <div class="mb-6">
          <h2 class="text-center text-5xl font-bold text-black dark:text-white">Login</h2>
        </div>
        <div class="mb-4">
          <label class="form-label">Email</label>
          <input type="text" class="form-input focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-violet-500" placeholder="Email" v-model="form.email" required autofocus>
          <InputError class="mt-2" :message="form.errors.email" />
        </div>
        <div class="mb-4">
          <label class="form-label">Password</label>
          <input type="password" class="form-input focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-violet-500" placeholder="Password" v-model="form.password" required>
          <InputError class="mt-2" :message="form.errors.password" />
        </div>
        <div class="mb-4 flex items-center justify-center">
          <h4 class="text-black dark:text-gray-200">Don't have an account? <a href="/register" class="ml-1 text-blue-500 hover:text-blue-800 dark:text-violet-500 dark:hover:text-violet-800">Click here!</a></h4>
        </div>
        <div class="flex items-center justify-between pt-5">
          <button type="submit" class="form-button" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
            Login
          </button>
        </div>
      </form>
    </div>
  </template> -->


<template>
  <section class="bg-gray-50 dark:bg-gray-900">
  <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
      <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
        <img class="scale-50" :src="iconSrc" alt="Icon" />
        STATSTREAM    
      </a>
      <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700" @submit.prevent="submit">
          <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
              <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">
                  Log in to your account
              </h1>
              <form class="space-y-4 md:space-y-6">
                  <div>
                      <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                      <input type="text" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@gmail.com" v-model="form.email" required>
                  </div>
                  <div>
                      <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                      <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" v-model="form.password" required>
                  </div>
                  <div class="flex items-center justify-between">
                      <div class="flex items-start">
                          <div class="flex items-center h-5">
                            <input id="remember" aria-describedby="remember" type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-primary-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-primary-600 dark:ring-offset-gray-800" required="">
                          </div>
                          <div class="ml-3 text-sm">
                            <label class="text-gray-500 dark:text-gray-300">Remember me</label>
                          </div>
                      </div>
                      <a href="#" class="text-sm font-medium text-primary-600 hover:underline dark:text-primary-500">Forgot password?</a>
                  </div>
                  <button type="submit" class="w-full text-white bg-blue-500 hover:bg-blue-700 dark:bg-purple-500 dark:hover:bg-purple-700 p-2 rounded-lg">Sign in</button>
                  <p class="text-sm font-light text-gray-500 dark:text-gray-400">
                      Don’t have an account yet? <a href="/register" class="font-medium text-primary-600 hover:underline dark:text-primary-500">Sign up</a>
                  </p>
              </form>
          </div>
      </div>
  </div>
</section>
</template>
  
  <script setup>
  // import lightIcon from '@/icons/Logo/icon.png';
  // import darkIcon from '@/icons/Logo/darkicon.png';
  import { useForm } from '@inertiajs/vue3';
  
  // const iconSrc = computed(() => isDark.value ? darkIcon : lightIcon);

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
  