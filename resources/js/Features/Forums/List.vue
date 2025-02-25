<script setup>
import { ref, defineProps, computed } from 'vue';
import { Link } from '@inertiajs/vue3';

// Props
const props = defineProps({
  posts: Object,
  currentUser: Object,
  filters: Object,
  categories: {
    type: Array,
    default: () => [], // Ensure categories default to an empty array if not passed
  }
});

// Log categories when the component is set up
console.log(' list - Categories prop passed:', props.categories);

// Computed property to map posts with their categories
const postsWithCategories = computed(() => {
  console.log(' list Mapped Categories for Posts:', props.categories);

  // Ensure categories are populated before mapping
  if (props.categories.length === 0) {
    console.warn('Categories are not available!');
  }

  return props.posts.data.map(post => {
    console.log(` list - Post ID: ${post.id}, Category ID: ${post.category_id}`);

    const category = props.categories.find(cat => cat.id === post.category_id);

    console.log(` list -Post ID: ${post.id}, Category Found:`, category);

    return {
      ...post,
      category: category || { name: 'Uncategorized' },
    };
  });
});



// Method to fetch posts for a specific page
const fetchPosts = (page) => {
  const params = {
    page: page,
    sort_by: props.filters?.sort_by || 'date',
    sort_direction: props.filters?.sort_direction || 'desc',
  };

  console.log('Fetching posts with parameters:', params);

  // Fetch posts using inertia router
  router.get('/forums', params, {
    preserveState: true,
    replace: true,
  });
};

// Format content to truncate after a specific number of words
const truncateContent = (content, maxWords) => {
  const words = content.split(' ');
  return words.length <= maxWords ? content : words.slice(0, maxWords).join(' ') + '...';
};

// Format date for display
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
</script>

<template>
  <div class="mx-auto space-y-6 max-w-7xl">
    <!-- Loop through postsWithCategories and render each post -->
    <ul>
      <li v-for="post in postsWithCategories" :key="post.id">
        <Link :href="`/forums/${post.id}`">
          <div class="py-4 my-4 border border-gray-700">
            <div class="mx-10">
              <div class="flex justify-between">
                <p class="text-lg font-bold">{{ post.title }}</p>
                <!-- Display category name dynamically, or 'Uncategorized' -->
                <p class="text-sm text-gray-400">{{ post.category ? post.category.name : 'Uncategorized' }}</p>
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

    <!-- Pagination -->
    <div class="flex justify-center gap-2 mt-6">
      <button
        @click="fetchPosts(props.posts.current_page - 1)"
        :disabled="props.posts.current_page === 1"
        class="px-4 py-2 text-gray-200 bg-gray-700 rounded-lg hover:bg-gray-600 disabled:opacity-50"
      >
        Previous
      </button>
      <span class="px-4 py-2 text-gray-200">
        Page {{ props.posts.current_page }} of {{ props.posts.last_page }}
      </span>
      <button
        @click="fetchPosts(props.posts.current_page + 1)"
        :disabled="props.posts.current_page === props.posts.last_page"
        class="px-4 py-2 text-gray-200 bg-gray-700 rounded-lg hover:bg-gray-600 disabled:opacity-50"
      >
        Next
      </button>
    </div>
  </div>
</template>
