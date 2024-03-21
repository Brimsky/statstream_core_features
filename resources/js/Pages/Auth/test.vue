<template>
    <div class="flex justify-center items-center min-h-screen bg-gradient-to-r from-gray-200 to-gray-400 dark:from-neutral-700 dark:to-neutral-800">
      <form class="w-full max-w-2xl bg-white dark:bg-neutral-900 shadow-md px-8 pt-6 pb-8 mb-4 rounded-lg">
        <div class="mb-6">
          <h2 class="text-center text-5xl font-bold text-black dark:text-white">Login</h2>
        </div>
        <div class="mb-4">
          <label class="form-label">Email</label>
          <input type="text" class="form-input focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-violet-500" placeholder="Email">
  
        </div>
        <div class="mb-4">
          <label class="form-label">Password</label>
          <input type="text" class="form-input focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-violet-500" placeholder="Password">
          <!-- The eye icon button for password visibility will need custom styling as well. -->
        </div>
        <div class="mb-4 flex items-center justify-center">
          <h4 class="text-black dark:text-gray-200">Don't have an account?<router-link to="/signup" class="ml-1 text-blue-500 hover:text-blue-800 dark:text-violet-500 dark:hover:text-violet-800">Click here!</router-link></h4>
        </div>
        <div class="flex items-center justify-between pt-5">
          <button class="form-button" type="button">
            Login
          </button>
        </div>
      </form>
    </div>
</template>
