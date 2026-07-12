<template>
  <div class="min-h-screen bg-gradient-to-br from-gray-900 to-gray-800">
    <nav class="bg-gray-800 border-b border-gray-700">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
          <div class="flex items-center">
            <h1 class="text-white text-2xl font-bold">Perfect World Panel</h1>
          </div>
          <div class="flex items-center space-x-4">
            <div v-if="authStore.isAuthenticated" class="flex items-center space-x-4">
              <span class="text-gray-300">{{ authStore.user?.name }}</span>
              <button
                @click="handleLogout"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded"
              >
                Logout
              </button>
            </div>
            <div v-else class="flex items-center space-x-2">
              <router-link to="/login" class="text-gray-300 hover:text-white">
                Login
              </router-link>
              <router-link to="/register" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Register
              </router-link>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <router-view />
    </div>
  </div>
</template>

<script setup>
import { useAuthStore } from '@/stores/authStore';
import { useRouter } from 'vue-router';

const authStore = useAuthStore();
const router = useRouter();

const handleLogout = async () => {
  await authStore.logout();
  router.push('/login');
};
</script>
