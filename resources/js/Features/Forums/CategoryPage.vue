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
  import { defineProps } from 'vue';

  const props = defineProps({
    category: {
      type: Object,
      required: true,
    },
  });

  console.log('Category:', props.category); // Debugging
  </script>
