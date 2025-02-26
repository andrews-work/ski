<script setup>
const props = defineProps({
  category: Object,
});

// Define an emit function
const emit = defineEmits(['view-category']);

// Function to handle the "View" button click
const goToCategory = (categoryId) => {
  emit('view-category', categoryId); // Emit the category ID to the parent
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

    <!-- Loop through nested subcategories (without navigation logic) -->
    <div v-for="subcategory in props.category.children" :key="subcategory.id" class="mt-6">
      <h6 class="text-lg font-bold text-gray-300">{{ subcategory.name }}</h6>
      <!-- Subcategories will be displayed, but no navigation logic -->
      <div v-for="country in subcategory.children" :key="country.id" class="space-y-4">
        <div class="text-white">
          <span class="mt-4 mr-2 font-semibold">{{ country.name }}:</span>
          <span v-for="resort in country.children" :key="resort.id" class="ml-4 text-gray-300">
            {{ resort.name }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>
