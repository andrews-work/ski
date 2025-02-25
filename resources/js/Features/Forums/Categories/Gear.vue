<script setup>
// Accepting the category prop passed from the parent
const props = defineProps({
  category: Object //
});

// Log the category name to verify its value
console.log('Category Name:', props.category.name);

// Hardcoded data for gear subcategories
const subcategories = [
  { id: 21, name: 'Skis' },
  { id: 22, name: 'Snowboards' },
  { id: 23, name: 'Boots' },
  { id: 24, name: 'Bindings' },
  { id: 25, name: 'Brands' },
  { id: 26, name: 'Poles' },
  { id: 27, name: 'Gloves' },
  { id: 28, name: 'Goggles' },
];

const goToCategory = (categoryId) => {
  console.log(`Navigate to category with ID: ${categoryId}`);
};
</script>

<template>
  <div class="p-4 border border-gray-300 rounded-lg shadow-md">
    <!-- Render category name and description dynamically -->
    <div class="flex items-center justify-between">
      <h4 class="text-2xl font-bold text-white">{{ props.category.name }}</h4>
      <p class="mt-2 text-white">{{ props.category.description }}</p>
      <button
        @click="goToCategory(props.category.id)"
        class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
        View
      </button>
    </div>

    <!-- Loop through the hardcoded gear subcategories -->
    <div v-for="subcategory in subcategories" :key="subcategory.id" class="mt-6">
      <h6 class="text-lg font-bold text-gray-300">{{ subcategory.name }}</h6>
    </div>
  </div>
</template>
