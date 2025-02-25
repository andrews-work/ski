<script setup>
import { ref, onMounted } from 'vue';
import ResortsCategory from './Categories/Resorts.vue';
import GearCategory from './Categories/Gear.vue';
import EventsCategory from './Categories/Events.vue';
import SafetyCategory from './Categories/Safety.vue';
import TechniqueCategory from './Categories/Technique.vue';

// State to hold categories data
const categories = ref([]);

// This will map the category name to the Vue component
const componentMap = {
  Resorts: ResortsCategory,
  Gear: GearCategory,
  Events: EventsCategory,
  Safety: SafetyCategory,
  Technique: TechniqueCategory
};

// Fetch categories when the component is mounted
onMounted(() => {
  fetch('/forum-categories')
    .then((response) => {
      if (!response.ok) {
        throw new Error('Failed to fetch categories');
      }
      return response.json();
    })
    .then((data) => {
      categories.value = data.categories;
      console.log('Fetched categories:', categories.value);
    })
    .catch((error) => {
      console.error('Error fetching categories:', error);
    });
});

// Log the category before passing it to the child component
const logCategory = (category) => {
  console.log('Passing category to component:', category.name, category);
  return category;
};
</script>

<template>
  <div class="mx-auto space-y-6 max-w-7xl">
    <!-- Loop through categories and render each component dynamically -->
    <div v-for="category in categories" :key="category.id">
      <!-- Log the category and pass it to the child component -->
      <component :is="componentMap[category.name]" :category="logCategory(category)" />
    </div>
  </div>
</template>
