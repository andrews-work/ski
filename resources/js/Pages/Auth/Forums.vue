<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, router } from '@inertiajs/vue3';
import { ref, watch, onMounted } from 'vue';
import ForumList from '@/Features/Forums/List.vue';
import Post from '@/Features/Forums/Post.vue';
import ForumCategoriesList from '@/Features/Forums/Categories.vue';
import ForumCategoriesPage from '@/Features/Forums/CategoryPage.vue';
import ForumHeader from '@/Features/Forums/Header.vue';

const props = defineProps({
  posts: Object,
  currentUser: Object,
  filters: Object,
  post: Object,
  categories: Object,
  category: Object,
});

const selectedCategory = ref(props.category);
const posts = ref(props.posts);
const categories = ref(props.categories || []);
const selectedPost = ref(props.post);

watch(
  () => props.category,
  (newCategory) => {
    selectedCategory.value = newCategory;
  },
  { immediate: true }
);

const fetchPosts = (page) => {
  router.get('/forums', { page }, {
    preserveState: true,
    onSuccess: (data) => {
      posts.value = data.props.posts;
    }
  });
};

onMounted(() => {
  if (!posts.value) {
    fetchPosts(1);
  }
});

const handlePostClick = (post) => {
  selectedPost.value = post;
  selectedCategory.value = null;
};

const handleCategoryClick = (categoryId) => {
  router.get(`/forums/categories/${categoryId}`, {}, {
    preserveState: true,
    onSuccess: (data) => {
      selectedCategory.value = data.props.category;
    }
  });
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
      <div class="w-full mx-auto sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
          <div class="p-6 text-gray-900 dark:text-gray-100">
            <div class="flex">
              <div v-if="!selectedPost && !selectedCategory" class="w-2/3 mr-4 overflow-y-scroll">
                <ForumCategoriesList
                  :categories="categories"
                  @view-category="handleCategoryClick"
                />
              </div>

              <div :class="selectedPost || selectedCategory ? 'w-full' : 'w-1/3'">
                <div class="flex flex-col">
                  <ForumHeader v-if="!selectedPost && !selectedCategory" />

                  <ForumList
                    v-if="!selectedPost && !selectedCategory"
                    :key="posts.current_page"
                    :posts="posts"
                    :currentUser="props.currentUser"
                    :filters="props.filters"
                    :categories="categories"
                    @fetch-posts="fetchPosts"
                    @post-clicked="handlePostClick"
                  />

                  <Post v-if="selectedPost" :post="selectedPost" :categories="categories" />
                  <ForumCategoriesPage v-if="selectedCategory" :category="selectedCategory" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
