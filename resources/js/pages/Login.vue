<template>
  <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
    <h1 class="text-3xl font-bold text-white mb-6">Login</h1>

    <form @submit.prevent="handleLogin" class="max-w-md">
      <div class="mb-4">
        <label class="block text-gray-300 text-sm font-bold mb-2">Email</label>
        <input
          v-model="email"
          type="email"
          required
          class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white placeholder-gray-400"
          placeholder="your@email.com"
        />
      </div>

      <div class="mb-6">
        <label class="block text-gray-300 text-sm font-bold mb-2">Password</label>
        <input
          v-model="password"
          type="password"
          required
          class="w-full bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white placeholder-gray-400"
          placeholder="••••••••"
        />
      </div>

      <div v-if="error" class="mb-4 p-3 bg-red-600 text-white rounded">
        {{ error }}
      </div>

      <button
        type="submit"
        :disabled="loading"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded disabled:opacity-50"
      >
        {{ loading ? 'Logging in...' : 'Login' }}
      </button>

      <div class="mt-4 text-center">
        <p class="text-gray-300">
          Don't have an account?
          <router-link to="/register" class="text-blue-400 hover:text-blue-300">Register here</router-link>
        </p>
      </div>
    </form>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useAuthStore } from '@/stores/authStore';
import { useRouter } from 'vue-router';

const authStore = useAuthStore();
const router = useRouter();

const email = ref('');
const password = ref('');
const loading = ref(false);
const error = ref('');

const handleLogin = async () => {
  loading.value = true;
  error.value = '';
  try {
    await authStore.login({ email: email.value, password: password.value });
    router.push(authStore.isAdmin ? '/admin/dashboard' : '/dashboard');
  } catch (err) {
    error.value = authStore.error || 'Login failed';
  } finally {
    loading.value = false;
  }
};
</script>
