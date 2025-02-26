<script setup>
import { defineProps, defineEmits } from 'vue';
import ResortsCategory from './Categories/Resorts.vue';
import GearCategory from './Categories/Gear.vue';
import EventsCategory from './Categories/Events.vue';
import SafetyCategory from './Categories/Safety.vue';
import TechniqueCategory from './Categories/Technique.vue';

const props = defineProps({
  categories: {
    type: Array,
    required: true,
  },
});

const emit = defineEmits(['view-category']);

// console.log('categories - Received categories:', props.categories);

const componentMap = {
  Resorts: ResortsCategory,
  Gear: GearCategory,
  Events: EventsCategory,
  Safety: SafetyCategory,
  Technique: TechniqueCategory,
};

const handleViewCategory = (categoryId) => {
  console.log('View category triggered with ID:', categoryId);
  emit('view-category', categoryId);
};
</script>

<template>
  <div class="mx-auto space-y-6 max-w-7xl">
    <div v-for="category in categories" :key="category.id">
      <component
        :is="componentMap[category.name]"
        :category="category"
        @view-category="handleViewCategory"
      />
    </div>
  </div>
</template>
