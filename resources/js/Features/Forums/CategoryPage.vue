<template>
    <div>
      <div v-if="category">
        <!-- Main Category Details -->
        <div class="mb-8">
          <h2 class="text-3xl font-bold text-white">{{ category.name }}</h2>
          <p class="text-lg text-gray-300">{{ category.description }}</p>
        </div>

        <!-- Subcategories Grid -->
        <div class="flex flex-wrap gap-6">
          <div v-for="subcategory in category.children" :key="subcategory.id" class="flex-1 min-w-[300px] max-w-[400px] p-6 bg-gray-800 rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300">
            <!-- Subcategory Name -->
            <h3 class="mb-4 text-2xl font-semibold text-white">{{ subcategory.name }}</h3>

            <!-- Countries -->
            <div class="space-y-4">
              <div v-for="country in subcategory.children" :key="country.id" class="p-4 bg-gray-700 rounded-lg">
                <!-- Country Name -->
                <h4 class="text-xl font-semibold text-white">{{ country.name }}</h4>

                <!-- Resorts -->
                <div class="mt-3 space-y-2">
                  <div v-for="resort in country.children" :key="resort.id" class="text-gray-300">
                    <span class="ml-2">{{ resort.name }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div v-else>
        <p class="text-white">Loading...</p>
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
