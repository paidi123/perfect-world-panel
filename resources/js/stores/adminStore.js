import { defineStore } from 'pinia';
import { ref } from 'vue';
import api from '@/services/api';

export const useAdminStore = defineStore('admin', () => {
  const accounts = ref([]);
  const characters = ref([]);
  const items = ref([]);
  const loading = ref(false);
  const error = ref(null);

  const fetchAccounts = async (filters = {}) => {
    loading.value = true;
    error.value = null;
    try {
      const response = await api.get('/admin/accounts', { params: filters });
      accounts.value = response.data.data;
      return response.data;
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to fetch accounts';
      throw err;
    } finally {
      loading.value = false;
    }
  };

  const fetchCharacters = async (filters = {}) => {
    loading.value = true;
    error.value = null;
    try {
      const response = await api.get('/admin/characters', { params: filters });
      characters.value = response.data.data;
      return response.data;
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to fetch characters';
      throw err;
    } finally {
      loading.value = false;
    }
  };

  const fetchItems = async (filters = {}) => {
    loading.value = true;
    error.value = null;
    try {
      const response = await api.get('/admin/items', { params: filters });
      items.value = response.data.data;
      return response.data;
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to fetch items';
      throw err;
    } finally {
      loading.value = false;
    }
  };

  const banAccount = async (accountId, reason, duration) => {
    try {
      const response = await api.post(`/admin/accounts/${accountId}/ban`, {
        reason,
        until: duration,
      });
      return response.data;
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to ban account';
      throw err;
    }
  };

  const unbanAccount = async (accountId) => {
    try {
      const response = await api.post(`/admin/accounts/${accountId}/unban`);
      return response.data;
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to unban account';
      throw err;
    }
  };

  const distributeItem = async (itemId, characterId, quantity, reason) => {
    try {
      const response = await api.post('/admin/items/distribute', {
        item_id: itemId,
        character_id: characterId,
        quantity,
        reason,
      });
      return response.data;
    } catch (err) {
      error.value = err.response?.data?.message || 'Failed to distribute item';
      throw err;
    }
  };

  return {
    accounts,
    characters,
    items,
    loading,
    error,
    fetchAccounts,
    fetchCharacters,
    fetchItems,
    banAccount,
    unbanAccount,
    distributeItem,
  };
});
