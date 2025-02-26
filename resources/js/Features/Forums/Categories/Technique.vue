<script setup>
const props = defineProps({
  category: Object,
});

const emit = defineEmits(['view-category']);

const goToCategory = (categoryId) => {
  emit('view-category', categoryId);
  console.log(`Navigate to category with ID: ${categoryId}`);
};
</script>

<template>
    <div class="p-4 border border-gray-300 rounded-lg shadow-md">
      <div class="flex items-center justify-between">
        <h4 class="text-2xl font-bold text-white">{{ props.category.name }}</h4>
        <p class="mt-2 text-white">{{ props.category.description }}</p>
        <button
          @click="goToCategory(props.category.id)"
          class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
          View
        </button>
      </div>

      <div v-for="subcategory in props.category.children" :key="subcategory.id" class="mt-6">
        <h6 class="text-lg font-bold text-gray-300">{{ subcategory.name }}</h6>
      </div>
    </div>
  </template>
