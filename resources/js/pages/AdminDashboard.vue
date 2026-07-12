<template>
  <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
      <h3 class="text-gray-400 text-sm font-medium">Total Accounts</h3>
      <p class="text-3xl font-bold text-white mt-2">{{ stats.total_accounts }}</p>
    </div>
    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
      <h3 class="text-gray-400 text-sm font-medium">Active Accounts</h3>
      <p class="text-3xl font-bold text-green-400 mt-2">{{ stats.active_accounts }}</p>
    </div>
    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
      <h3 class="text-gray-400 text-sm font-medium">Online Characters</h3>
      <p class="text-3xl font-bold text-blue-400 mt-2">{{ stats.online_characters }}</p>
    </div>
    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
      <h3 class="text-gray-400 text-sm font-medium">Total Revenue</h3>
      <p class="text-3xl font-bold text-yellow-400 mt-2">{{ formatCurrency(stats.total_revenue) }}</p>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
      <h2 class="text-xl font-bold text-white mb-4">Recent Transactions</h2>
      <div class="space-y-2">
        <div v-for="transaction in recentTransactions" :key="transaction.id" class="flex justify-between items-center py-2 border-b border-gray-700">
          <div>
            <p class="text-white">{{ transaction.transaction_type }}</p>
            <p class="text-gray-400 text-sm">{{ formatDate(transaction.created_at) }}</p>
          </div>
          <p class="text-green-400 font-bold">+{{ formatCurrency(transaction.amount) }}</p>
        </div>
      </div>
    </div>

    <div class="bg-gray-800 rounded-lg p-6 border border-gray-700">
      <h2 class="text-xl font-bold text-white mb-4">Pending Reports</h2>
      <div class="space-y-2">
        <div v-for="report in recentReports" :key="report.id" class="flex justify-between items-center py-2 border-b border-gray-700">
          <div>
            <p class="text-white">{{ report.report_type }}</p>
            <p class="text-gray-400 text-sm">{{ formatDate(report.created_at) }}</p>
          </div>
          <span class="bg-red-600 text-white px-2 py-1 rounded text-sm">{{ report.status }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import api from '@/services/api';

const stats = ref({
  total_accounts: 0,
  active_accounts: 0,
  online_characters: 0,
  total_revenue: 0,
});
const recentTransactions = ref([]);
const recentReports = ref([]);

const fetchDashboard = async () => {
  try {
    const response = await api.get('/admin/dashboard');
    stats.value = response.data.stats;
    recentTransactions.value = response.data.recent_transactions;
    recentReports.value = response.data.recent_reports;
  } catch (error) {
    console.error('Failed to fetch dashboard:', error);
  }
};

const formatCurrency = (value) => {
  return new Intl.NumberFormat('en-US', {
    style: 'currency',
    currency: 'USD',
  }).format(value);
};

const formatDate = (date) => {
  return new Date(date).toLocaleDateString('en-US', {
    year: 'numeric',
    month: 'short',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  });
};

onMounted(() => {
  fetchDashboard();
});
</script>
