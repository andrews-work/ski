<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  category: {
    type: Object,
    required: true,
  },
});

const emit = defineEmits(['view-category']);

const handleViewClick = () => {
  console.log('View Category:', props.category.name);
  emit('view-category', props.category.name);
};
</script>

<template>
  <div class="p-4 bg-gray-800 border border-gray-500 rounded-lg shadow-md">
    <div class="flex items-center justify-between">
      <h4 class="text-2xl font-bold text-white">{{ props.category.name }}</h4>
      <p class="mt-2 text-white">{{ props.category.description }}</p>
      <Link
        :href="`/forums/categories/${props.category.name}`"
        class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-orange-700"
        @click="handleViewClick"
      >
        View
      </Link>
    </div>

    <div v-if="props.category.children && props.category.children.length > 0">
      <div v-for="subcategory in props.category.children" :key="`subcategory-${subcategory.id}`" class="mt-6">
        <h6 class="text-lg font-bold text-gray-300">
          <Link
            :href="`/forums/categories/${props.category.name}/${subcategory.name}`"
            class="px-4 py-2 text-white bg-gray-900 rounded-md hover:bg-orange-700"
            @click="handleViewClick"
          >
            {{ subcategory.name }}
          </Link>
        </h6>

        <div v-if="subcategory.children && subcategory.children.length > 0">
          <div v-for="country in subcategory.children" :key="`country-${country.id}`" class="mt-4">
            <div class="flex items-center">
              <span class="mr-4 font-semibold text-white">
                <Link
                  :href="`/forums/categories/${props.category.name}/${subcategory.name}/${country.name}`"
                  class="px-4 py-2 text-white bg-gray-700 rounded-lg hover:bg-orange-700"
                  @click="handleViewClick"
                >
                  {{ country.name }}:
                </Link>
              </span>

              <div class="flex py-2 space-x-4 overflow-x-auto">
                <Link
                  v-for="resort in country.children"
                  :key="`resort-${resort.id}`"
                  class="flex-shrink-0 px-4 py-1 text-gray-300 bg-gray-500 rounded-lg hover:bg-orange-700"
                  :href="`/forums/categories/${props.category.name}/${subcategory.name}/${country.name}/${resort.name}`"
                  @click="handleViewClick"
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
</template>
