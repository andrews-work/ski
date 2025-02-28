<script setup>
import CategoryComponent from './Categories.vue';

const props = defineProps({
  categories: {
    type: Array,
    required: true,
  },
});

const emit = defineEmits(['view-category']);

const handleViewCategory = (categoryName) => {
  emit('view-category', categoryName);
};
</script>

<template>
  <div class="mx-auto space-y-6 ">
    <div v-for="category in categories" :key="category.id">
      <CategoryComponent
        :category="category"
        @view-category="handleViewCategory"
      />
    </div>
  </div>
</template>
