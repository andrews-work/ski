<script setup>
import { defineProps, defineEmits, watch, ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  posts: Object,
  currentUser: Object,
  filters: Object,
  categories: {
    type: Array,
    default: () => [],
  },
});

const categories = ref(props.categories);

watch(
  () => props.categories,
  (newCategories) => {
    categories.value = newCategories;
  },
  { immediate: true }
);

const topLevelCategories = computed(() => {
  return categories.value.filter(category => category.parent_id === null);
});

const emit = defineEmits(['fetch-posts']);

const truncateContent = (content, maxWords) => {
  const words = content.split(' ');
  return words.length <= maxWords ? content : words.slice(0, maxWords).join(' ') + '...';
};

const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleDateString('en-GB', {
    year: 'numeric',
    month: 'long',
    day: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  });
};

const handlePagination = (page) => {
  emit('fetch-posts', page);
};

const getCategoryName = (categoryId) => {
  const category = topLevelCategories.value.find(category => category.id === categoryId);
  return category ? category.name : 'Uncategorized';
};
</script>

<template>
  <div class="mx-auto space-y-6 max-w-7xl">
    <ul>
      <li v-for="post in posts.data" :key="post.id">
        <Link :href="`/forums/${post.id}`">
          <div class="py-4 my-4 border border-gray-700">
            <div class="mx-10">
              <div class="flex justify-between">
                <p class="text-lg font-bold">{{ post.title }}</p>
                <p class="text-sm text-gray-500">
                  {{
                    getCategoryName(post.category_id)
                  }}
                </p>
              </div>
              <p class="mt-5 text-sm">{{ truncateContent(post.content, 20) }}</p>
              <div class="flex justify-between mt-4">
                <p class="text-sm text-gray-400">{{ post.user.name }}</p>
                <p class="text-sm text-gray-400">{{ formatDate(post.created_at) }}</p>
              </div>
            </div>
          </div>
        </Link>
      </li>
    </ul>

    <div class="flex justify-center gap-2 mt-6">
      <button
        @click="handlePagination(posts.current_page - 1)"
        :disabled="posts.current_page === 1"
        class="px-4 py-2 text-gray-200 bg-gray-700 rounded-lg hover:bg-gray-600 disabled:opacity-50"
      >
        Previous
      </button>
      <span class="px-4 py-2 text-gray-200">
        Page {{ posts.current_page }} of {{ posts.last_page }}
      </span>
      <button
        @click="handlePagination(posts.current_page + 1)"
        :disabled="posts.current_page === posts.last_page"
        class="px-4 py-2 text-gray-200 bg-gray-700 rounded-lg hover:bg-gray-600 disabled:opacity-50"
      >
        Next
      </button>
    </div>
  </div>
</template>
