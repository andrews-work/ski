<script setup>
import { ref, watch, onMounted } from 'vue';
import { truncateContent, formatDate, getCategoryName } from '@/utils/forums';

const props = defineProps({
  posts: Object,
  currentUser: Object,
  filters: Object,
  categories: {
    type: Array,
    default: () => [],
  },
  latestPost: Object, // Add latestPost prop
});

const emit = defineEmits(['fetch-posts', 'post-clicked']);

const categories = ref(props.categories);
const postsList = ref(props.posts.data); // Use a ref for posts to make it reactive

// Watch for changes to the latestPost prop
watch(
  () => props.latestPost,
  (newPost) => {
    console.log('latestPost prop changed:', newPost); // Log the newPost value
    if (newPost) {
      console.log('Adding new post to the list:', newPost); // Log when adding the new post
      postsList.value.unshift(newPost);
    } else {
      console.log('No new post to add');
    }
  },
  { immediate: true }
);

// Watch for changes to the posts prop (e.g., when paginating)
watch(
  () => props.posts,
  (newPosts) => {
    console.log('Posts prop changed:', newPosts); // Log when posts change
    postsList.value = newPosts.data;
  },
  { immediate: true }
);

const handlePagination = (page) => {
  emit('fetch-posts', page);
};

const handlePostClick = (post) => {
  emit('post-clicked', post);
};

// Listen for the PostCreated event
onMounted(() => {
    console.log('PostList component mounted');
    window.Echo.channel('posts')
        .listen('PostCreated', (data) => {
            console.log('New post received:', data.post);
            postsList.value.unshift(data.post);
        })
        .error((error) => {
            console.error("Error listening to event:", error);
        });
});
</script>


<template>
  <div class="mx-auto space-y-6 text-white">
    <ul>
      <li v-for="post in postsList" :key="post.id">
        <div @click="handlePostClick(post)" class="cursor-pointer">
          <div class="min-w-full py-4 my-4 border border-gray-500">
            <div class="mx-4">
              <div class="flex justify-between">
                <p class="text-lg font-bold">{{ post.title }}</p>
                <p class="text-sm text-gray-500">
                  {{ getCategoryName(categories, post.category_id) }}
                </p>
              </div>
              <p class="mt-5 text-sm">{{ truncateContent(post.content, 20) }}</p>
              <div class="flex justify-between mt-4">
                <p class="text-sm text-gray-400">{{ post.user.name }}</p>
                <p class="text-sm text-gray-400">{{ formatDate(post.created_at) }}</p>
              </div>
            </div>
          </div>
        </div>
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


