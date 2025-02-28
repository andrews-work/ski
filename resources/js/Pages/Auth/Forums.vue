<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, watch, onMounted } from 'vue';
import { fetchPosts, fetchCategory } from '@/api/forums';
import PostList from '@/Features/Forums/PostList.vue';
import Post from '@/Features/Forums/Post.vue';
import ForumCategoriesList from '@/Features/Forums/CategoryList.vue';
import ForumCategoriesPage from '@/Features/Forums/CategoryPage.vue';
import ForumHeader from '@/Features/Forums/Header.vue';
import CreatePostModal from '@/Features/Forums/PostCreate.vue';
import Sidebar from '@/Features/Forums/Sidebar.vue';

const props = defineProps({
  posts: Object,
  currentUser: Object,
  filters: Object,
  post: Object,
  categories: Object,
  category: Object,
  reloadPage: Boolean,
});

const selectedCategory = ref(props.category);
const posts = ref(props.posts);
const categories = ref(props.categories || []);
const selectedPost = ref(props.post);
const showCreateModal = ref(false);

onMounted(async () => {
  if (!posts.value) {
    loadPosts(1);
  }
});

watch(() => props.reloadPage, (newValue) => {
  if (newValue) {
    loadPosts(1);
  }
});

const loadPosts = async (page = 1) => {
  const response = await fetchPosts(page, props.filters);
  posts.value = response.props.posts;
};

const handlePostClick = (post) => {
  router.get(`/forums/${post.id}`);
};

const handleCategoryClick = async (categoryId) => {
  router.get(`/forums/categories/${categoryId}`);
};
</script>
<template>
    <Head title="Forums" />
    <AuthenticatedLayout>
      <template #header>
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
          Forums
        </h2>
      </template>

      <div class="py-12">
        <div class="flex justify-center w-full mx-auto sm:px-6 lg:px-10">
          <div class="flex flex-col w-full gap-12 sm:flex-row">

            <!-- Sidebar with dynamic width (flex) -->
            <div class="flex-shrink-0 w-full sm:w-2/12">
              <Sidebar />
            </div>

            <!-- Main content area -->
            <div v-if="!selectedPost && !selectedCategory" class="flex-grow w-full space-y-8 sm:w-7/12">
              <ForumCategoriesList
                :categories="categories"
                @view-category="handleCategoryClick"
              />
            </div>

            <!-- Post detail or category page -->
            <div :class="[selectedPost || selectedCategory ? 'w-full sm:w-9/12' : 'w-full sm:w-3/12', 'space-y-8', 'flex-grow']">
              <div class="flex flex-col">
                <ForumHeader
                  v-if="!selectedPost && !selectedCategory"
                  @create-post="showCreateModal = true"
                />

                <PostList
                  v-if="!selectedPost && !selectedCategory"
                  :key="posts.current_page"
                  :posts="posts"
                  :currentUser="props.currentUser"
                  :filters="props.filters"
                  :categories="categories"
                  @fetch-posts="loadPosts"
                  @post-clicked="handlePostClick"
                />

                <Post v-if="selectedPost" :post="selectedPost" :categories="categories" />
                <ForumCategoriesPage v-if="selectedCategory" :category="selectedCategory" />
              </div>
            </div>

          </div>
        </div>
      </div>

      <CreatePostModal
        :show="showCreateModal"
        :categories="categories"
        @close="showCreateModal = false"
      />
    </AuthenticatedLayout>
  </template>

