<template>
    <div>
      <div v-if="category">
        <h2 class="text-2xl">{{ category.name }}</h2>
        <p>{{ category.description }}</p>

        <!-- Include nested category structure if it exists -->
        <div v-if="category.children && category.children.length > 0">
          <div class="flex py-2 space-x-4 overflow-x-auto">
            <!-- Make resorts clickable -->
            <Link
              v-for="resort in category.children"
              :key="`resort-${resort.id}`"
              class="flex-shrink-0 px-4 py-1 text-gray-300 bg-gray-500 rounded-lg hover:bg-orange-700"
              :href="`/forums/categories/${category.parent.parent.name}/${category.parent.name}/${category.name}/${resort.name}`"
            >
              {{ resort.name }}
            </Link>
          </div>
        </div>
      </div>
      <div v-else>
        <p>Loading...</p>
      </div>
    </div>
  </template>

  <script setup>
  import { Link } from '@inertiajs/vue3';

  const props = defineProps({
    category: Object,
  });
  </script>
