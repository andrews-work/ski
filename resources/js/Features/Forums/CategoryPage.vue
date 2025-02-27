<template>
    <div>
      <h1>Category Details</h1>
      <div v-if="category">
        <h2>{{ category.name }}</h2>
        <p>{{ category.description }}</p>
      </div>
      <div v-else>
        <p>Loading...</p>
      </div>
    </div>
  </template>

  <script setup>
  import { ref, watch } from 'vue';

  const props = defineProps({
    category: Object,
  });

  watch(
    () => props.category,
    (newCategory) => {
      if (newCategory) {
        // Handle any updates if needed
      }
    },
    { immediate: true }
  );
  </script>
