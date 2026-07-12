import { defineStore } from 'pinia';
import { ref, computed } from 'vue';
import api from '@/services/api';

export const useAuthStore = defineStore('auth', () => {
  const user = ref(null);
  const token = ref(localStorage.getItem('token'));
  const loading = ref(false);
  const error = ref(null);

  const isAuthenticated = computed(() => !!token.value);
  const isAdmin = computed(() => user.value?.roles?.some(r => ['admin', 'super_admin'].includes(r.name)));

  const register = async (credentials) => {
    loading.value = true;
    error.value = null;
    try {
      const response = await api.post('/auth/register', credentials);
      token.value = response.data.token;
      user.value = response.data.user;
      localStorage.setItem('token', token.value);
      return response.data;
    } catch (err) {
      error.value = err.response?.data?.message || 'Registration failed';
      throw err;
    } finally {
      loading.value = false;
    }
  };

  const login = async (credentials) => {
    loading.value = true;
    error.value = null;
    try {
      const response = await api.post('/auth/login', credentials);
      token.value = response.data.token;
      user.value = response.data.user;
      localStorage.setItem('token', token.value);
      return response.data;
    } catch (err) {
      error.value = err.response?.data?.message || 'Login failed';
      throw err;
    } finally {
      loading.value = false;
    }
  };

  const logout = async () => {
    try {
      await api.post('/auth/logout');
    } catch (err) {
      console.error('Logout error:', err);
    } finally {
      token.value = null;
      user.value = null;
      localStorage.removeItem('token');
    }
  };

  const fetchCurrentUser = async () => {
    loading.value = true;
    try {
      const response = await api.get('/auth/me');
      user.value = response.data;
      return response.data;
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to fetch user';
      throw err;
    } finally {
      loading.value = false;
    }
  };

  return {
    user,
    token,
    loading,
    error,
    isAuthenticated,
    isAdmin,
    register,
    login,
    logout,
    fetchCurrentUser,
  };
});
