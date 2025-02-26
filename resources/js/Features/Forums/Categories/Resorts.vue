<script setup>
const props = defineProps({
  category: Object,
});

// Log the received category data for debugging
// console.log('resorts - Received category:', JSON.parse(JSON.stringify(props.category)));

// Define an emit function
const emit = defineEmits(['view-category']);

// Function to handle the "View" button click
const goToCategory = (categoryId) => {
  emit('view-category', categoryId);
  console.log(`Navigate to category with ID: ${categoryId}`);

  // Update the URL without a full page refresh
  history.pushState({}, '', `/forums/categories/${categoryId}`);
};
</script>

<template>
  <div class="p-4 border border-gray-300 rounded-lg shadow-md">
    <!-- Category details -->
    <div class="flex items-center justify-between">
      <h4 class="text-2xl font-bold text-white">{{ props.category.name }}</h4>
      <p class="mt-2 text-white">{{ props.category.description }}</p>
      <button
        @click="goToCategory(props.category.id)"
        class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600"
      >
        View
      </button>
    </div>

    <!-- Subcategory details -->
    <div v-if="props.category.children && props.category.children.length > 0">
      <div v-for="subcategory in props.category.children" :key="`subcategory-${subcategory.id}`" class="mt-6">
        <h6 class="text-lg font-bold text-gray-300">
          {{ subcategory.name }}
        </h6>

        <!-- Country and resort details -->
        <div v-if="subcategory.children && subcategory.children.length > 0">
          <div v-for="country in subcategory.children" :key="`country-${country.id}`" class="mt-4">
            <div class="flex items-center">
              <!-- Country name -->
              <span class="mr-4 font-semibold text-white">{{ country.name }}:</span>

              <!-- Resorts container with horizontal scrolling -->
              <div class="flex py-2 space-x-4 overflow-x-auto">
                <!-- List resorts within each country -->
                <div
                  v-for="resort in country.children"
                  :key="`resort-${resort.id}`"
                  class="flex-shrink-0 px-4 py-2 text-gray-300 bg-gray-700 rounded-lg"
                >
                  {{ resort.name }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
