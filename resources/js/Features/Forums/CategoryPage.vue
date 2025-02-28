<template>
    <div>
      <div v-if="category">
        <h2 class="text-2xl">{{ category.name }}</h2>
        <p>{{ category.description }}</p>

        <!-- Include nested category structure if it exists -->
        <div v-if="category.children && category.children.length > 0">
          <div v-for="subcategory in category.children" :key="`subcategory-${subcategory.id}`" class="mt-6">
            <h6 class="text-lg font-bold text-gray-300">
              <!-- Make subcategory name a clickable link -->
              <Link
                :href="`/forums/categories/${category.name}/${subcategory.name}`"
                class="px-4 py-2 text-white bg-gray-900 rounded-md hover:bg-orange-700"
                @click="handleContinentClick(subcategory.name)"
              >
                {{ subcategory.name }}
              </Link>
            </h6>

            <div v-if="subcategory.children && subcategory.children.length > 0">
              <div v-for="country in subcategory.children" :key="`country-${country.id}`" class="mt-4">
                <div class="flex items-center">
                  <span class="mr-4 font-semibold text-white">
                    <!-- Make country name a clickable link -->
                    <Link
                      :href="`/forums/categories/${category.name}/${subcategory.name}/${country.name}`"
                      class="px-4 py-2 text-white bg-gray-700 rounded-md hover:bg-orange-700"
                    >
                      {{ country.name }}:
                    </Link>
                  </span>

                  <div class="flex py-2 space-x-4 overflow-x-auto">
                    <!-- Make resorts clickable -->
                    <Link
                      v-for="resort in country.children"
                      :key="`resort-${resort.id}`"
                      class="flex-shrink-0 px-4 py-1 text-gray-300 bg-gray-500 rounded-lg hover:bg-orange-700"
                      :href="`/forums/categories/${category.name}/${subcategory.name}/${country.name}/${resort.name}`"
                    >
                      {{ resort.name }}
                    </Link>
                  </div>
                </div>
              </div>
            </div>
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

function handleContinentClick(continentName) {
  console.log('Clicked Continent:', continentName);
}
</script>
