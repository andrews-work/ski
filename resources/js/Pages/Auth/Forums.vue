<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ForumList from '@/Features/Forums/List.vue';
import Post from '@/Features/Forums/Post.vue';
import ForumCategories from '@/Features/Forums/Categories.vue';

const props = defineProps({
    posts: Object,
    currentUser: Object,
    filters: Object,
    post: Object,
    categories: Object,
});
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
              <!-- Conditionally render ForumCategories if there's no post -->
              <div v-if="!props.post" class="w-2/3 mr-4 overflow-y-scroll">
                <ForumCategories :categories="props.categories" />
              </div>

              <div class="w-1/3">
                <ForumList
                  v-if="!props.post"
                  :key="props.posts.current_page"
                  :posts="props.posts"
                  :currentUser="props.currentUser"
                  :filters="props.filters"
                  :categories="props.categories"
                />
                <Post v-else :post="props.post" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

