<script setup>
import { ref } from 'vue';

const props = defineProps({
  sortDirection: {
    type: String,
    default: 'desc',
  },
});

const emit = defineEmits(['update:searchQuery', 'update:sortBy', 'create-post']);

const searchQuery = ref('');
const sortBy = ref('date');
const showMyPosts = ref(false);

const setSortBy = (criteria) => {
  if (criteria === 'date') {
    emit('update:sortBy', criteria);
  } else {
    emit('update:sortBy', criteria);
  }
};

const handleCreatePost = () => {
  emit('create-post');
};
</script>

<template>
  <div class="forum-header">
    <div class="flex flex-col gap-4 p-4 bg-gray-900 border border-gray-500 rounded-lg md:grid md:grid-cols-2 lg:grid-cols-1 justify-evenly">
      <input
        type="text"
        v-model="searchQuery"
        placeholder="Search posts..."
        class="px-4 py-2 text-sm text-gray-200 bg-gray-700 border border-gray-600 rounded-lg focus:outline-none focus:border-blue-500"
      />

      <div class="flex gap-4">
        <button
          @click="setSortBy('date')"
          :class="{
            'bg-blue-700 text-white': sortBy === 'date',
            'bg-gray-700 text-gray-200': sortBy !== 'date',
          }"
          class="px-4 py-2 text-sm transition-colors rounded-lg hover:bg-blue-900"
        >
          Sort by Date {{ sortDirection === 'asc' ? '↑' : '↓' }}
        </button>

        <button
          @click="setSortBy('author')"
          :class="{
            'bg-blue-500 text-white': sortBy === 'author',
            'bg-gray-700 text-gray-200': sortBy !== 'author',
          }"
          class="px-4 py-2 text-sm transition-colors rounded-lg hover:bg-blue-600"
        >
          Sort by Author
        </button>

        <button
          @click="setSortBy('category')"
          :class="{
            'bg-blue-500 text-white': sortBy === 'category',
            'bg-gray-700 text-gray-200': sortBy !== 'category',
          }"
          class="px-4 py-2 text-sm transition-colors rounded-lg hover:bg-blue-600"
        >
          Sort by Category
        </button>
      </div>

      <button
        @click="handleCreatePost"
        class="px-4 py-2 text-sm text-center text-white transition-colors bg-green-800 rounded-lg hover:bg-green-600"
      >
        Create New Post
      </button>
    </div>
  </div>
</template>
