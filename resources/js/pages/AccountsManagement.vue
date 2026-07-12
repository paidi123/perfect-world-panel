<template>
  <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
    <h1 class="text-3xl font-bold text-white mb-6">Accounts Management</h1>

    <div class="mb-6 flex gap-4">
      <input
        v-model="searchQuery"
        type="text"
        placeholder="Search accounts..."
        class="flex-1 bg-gray-700 border border-gray-600 rounded px-4 py-2 text-white placeholder-gray-400"
      />
      <button
        @click="searchAccounts"
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded"
      >
        Search
      </button>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left">
        <thead class="border-b border-gray-700">
          <tr>
            <th class="text-gray-300 font-semibold pb-3">Account Name</th>
            <th class="text-gray-300 font-semibold pb-3">Status</th>
            <th class="text-gray-300 font-semibold pb-3">Characters</th>
            <th class="text-gray-300 font-semibold pb-3">Actions</th>
          </tr>
        </thead>
        <tbody class="space-y-2">
          <tr v-for="account in accounts" :key="account.id" class="border-b border-gray-700 hover:bg-gray-700 transition">
            <td class="py-3 text-white">{{ account.account_name }}</td>
            <td class="py-3">
              <span
                :class="{
                  'bg-green-600': account.account_status === 'active',
                  'bg-red-600': account.account_status === 'suspended',
                  'bg-gray-600': account.account_status === 'inactive',
                }"
                class="px-3 py-1 rounded text-white text-sm"
              >
                {{ account.account_status }}
              </span>
            </td>
            <td class="py-3 text-gray-300">{{ account.characters?.length || 0 }}</td>
            <td class="py-3">
              <button
                @click="viewAccount(account)"
                class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-sm mr-2"
              >
                View
              </button>
              <button
                v-if="!account.is_banned"
                @click="banAccount(account)"
                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm"
              >
                Ban
              </button>
              <button
                v-else
                @click="unbanAccount(account)"
                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm"
              >
                Unban
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useAdminStore } from '@/stores/adminStore';

const adminStore = useAdminStore();
const searchQuery = ref('');
const accounts = ref([]);

const fetchAccounts = async () => {
  try {
    const data = await adminStore.fetchAccounts();
    accounts.value = data.data;
  } catch (error) {
    console.error('Failed to fetch accounts:', error);
  }
};

const searchAccounts = async () => {
  try {
    const data = await adminStore.fetchAccounts({ search: searchQuery.value });
    accounts.value = data.data;
  } catch (error) {
    console.error('Search failed:', error);
  }
};

const viewAccount = (account) => {
  console.log('View account:', account);
};

const banAccount = async (account) => {
  const reason = prompt('Enter ban reason:');
  if (reason) {
    try {
      await adminStore.banAccount(account.id, reason);
      await fetchAccounts();
    } catch (error) {
      console.error('Ban failed:', error);
    }
  }
};

const unbanAccount = async (account) => {
  try {
    await adminStore.unbanAccount(account.id);
    await fetchAccounts();
  } catch (error) {
    console.error('Unban failed:', error);
  }
};

onMounted(() => {
  fetchAccounts();
});
</script>
