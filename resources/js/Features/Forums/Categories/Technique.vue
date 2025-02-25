<script setup>
// Hardcoded data for technique subcategories
const techniqueSubcategories = [
  { id: 61, name: 'Groomers' },
  { id: 62, name: 'Park' },
  { id: 63, name: "Tree's" },
  { id: 64, name: "Powder" },
  { id: 65, name: "Cliff's" },
  { id: 66, name: "Backcountry" },
  { id: 67, name: "Crosscountry" },
];

const goToCategory = (categoryId) => {
  console.log(`Navigate to category with ID: ${categoryId}`);
};
</script>

<template>
  <div class="p-4 border border-gray-300 rounded-lg shadow-md">
    <div class="flex items-center justify-between">
      <h4 class="text-2xl font-bold text-white">Technique</h4>
      <p class="mt-2 text-white">Improve your skiing or snowboarding technique.</p>
      <button
        @click="goToCategory(61)"
        class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
        View
      </button>
    </div>

    <div v-for="subcategory in techniqueSubcategories" :key="subcategory.id" class="mt-6">
      <h6 class="text-lg font-bold text-gray-300">{{ subcategory.name }}</h6>
    </div>
  </div>
</template>
