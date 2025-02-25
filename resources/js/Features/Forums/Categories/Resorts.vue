<script setup>
const props = defineProps({
  category: Object
});

const subcategories = [
  {
    id: 11,
    continent: 'North America',
    resortList: [
      {
        id: 111,
        countries: 'USA',
        resorts: [
          { id: 1111, resortName: 'Aspen' },
          { id: 1112, resortName: 'Park City' },
        ],
      },
      {
        id: 112,
        countries: 'Canada',
        resorts: [
          { id: 1121, resortName: 'Whistler' },
          { id: 1122, resortName: 'Banff' },
        ],
      },
    ],
  },
  {
    id: 12,
    continent: 'Europe',
    resortList: [
      {
        id: 121,
        countries: 'France',
        resorts: [
          { id: 1211, resortName: 'Chamonix' },
          { id: 1212, resortName: 'Les Arcs' },
        ],
      },
      {
        id: 122,
        countries: 'Italy',
        resorts: [
          { id: 1221, resortName: 'Cortina d\'Ampezzo' },
          { id: 1222, resortName: 'Val Gardena' },
        ],
      },
    ],
  },
  {
    id: 13,
    continent: 'Australia/New Zealand',
    resortList: [
      {
        id: 131,
        countries: 'Australia',
        resorts: [
          { id: 1311, resortName: 'Perisher' },
          { id: 1312, resortName: 'Mt Buller' },
          { id: 1313, resortName: 'Mt Hotham' },
        ],
      },
      {
        id: 132,
        countries: 'New Zealand',
        resorts: [
          { id: 1321, resortName: 'Remarkables' },
        ],
      },
    ],
  },
];

// Function to navigate to category
const goToCategory = (categoryId) => {
  console.log(`Navigate to category with ID: ${categoryId}`);
};
</script>

<template>
  <div class="p-4 border border-gray-300 rounded-lg shadow-md">
    <!-- Render category name and description dynamically -->
    <div class="flex items-center justify-between">
      <h4 class="text-2xl font-bold text-white">{{ props.category.name }}</h4>
      <p class="mt-2 text-white">{{ props.category.description }}</p>
      <button
        @click="goToCategory(props.category.id)"
        class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
        View
      </button>
    </div>

    <!-- Loop through the hardcoded subcategories data -->
    <div v-for="subcategory in subcategories" :key="subcategory.id" class="mt-6">
      <h6 class="text-lg font-bold text-gray-300">{{ subcategory.continent }}</h6>
      <div v-for="resort in subcategory.resortList" :key="resort.id" class="space-y-4">
        <div class="text-white">
          <span class="mt-4 mr-2 font-semibold">{{ resort.countries }}:</span>
          <span v-for="res in resort.resorts" :key="res.id" class="ml-4 text-gray-300">
            {{ res.resortName }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>
