<script setup>
// Hardcoded data for safety subcategories
const safetySubcategories = [
  { id: 51, name: 'Rules' },
  { id: 52, name: 'Avalanche Safety' },
  { id: 53, name: 'First Aid' },
];

const goToCategory = (categoryId) => {
  console.log(`Navigate to category with ID: ${categoryId}`);
};
</script>

<template>
  <div class="p-4 border border-gray-300 rounded-lg shadow-md">
    <div class="flex items-center justify-between">
      <h4 class="text-2xl font-bold text-white">Safety</h4>
      <p class="mt-2 text-white">Learn important safety practices.</p>
      <button
        @click="goToCategory(51)"
        class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
        View
      </button>
    </div>

    <div v-for="subcategory in safetySubcategories" :key="subcategory.id" class="mt-6">
      <h6 class="text-lg font-bold text-gray-300">{{ subcategory.name }}</h6>
    </div>
  </div>
</template>
