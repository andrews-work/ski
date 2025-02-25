<script setup>
// Hardcoded data for events subcategories
const eventsSubcategories = [
  { id: 41, name: 'Free Ride World Tour' },
  { id: 42, name: 'Racing' },
  { id: 43, name: 'Local Events' },
];

const goToCategory = (categoryId) => {
  console.log(`Navigate to category with ID: ${categoryId}`);
};
</script>

<template>
  <div class="p-4 border border-gray-300 rounded-lg shadow-md">
    <div class="flex items-center justify-between">
      <h4 class="text-2xl font-bold text-white">Events</h4>
      <p class="mt-2 text-white">Stay updated on events.</p>
      <button
        @click="goToCategory(41)"
        class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
        View
      </button>
    </div>

    <div v-for="subcategory in eventsSubcategories" :key="subcategory.id" class="mt-6">
      <h6 class="text-lg font-bold text-gray-300">{{ subcategory.name }}</h6>
    </div>
  </div>
</template>
