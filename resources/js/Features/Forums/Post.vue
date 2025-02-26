<template>
    <div class="space-y-4">

      <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-200">
        <template v-if="isEditing">
          <input
            v-model="editedPost.title"
            class="text-2xl font-bold text-gray-800 border-b-2 dark:text-gray-200"
            placeholder="Title"
          />
        </template>
        <template v-else>
          {{ post.title }}
        </template>
      </h1>

      <p class="text-gray-700 dark:text-gray-300 min-h-[50vh]">
        <template v-if="isEditing">
          <textarea
            v-model="editedPost.content"
            class="w-full p-2 border-2 rounded-md"
            placeholder="Content"
          ></textarea>
        </template>
        <template v-else>
          {{ post.content }}
        </template>
      </p>

      <p class="text-sm text-gray-500 dark:text-gray-400">
        Category:
        <template v-if="isEditing">
          <input
            v-model="editedPost.category"
            class="border-b-2"
            placeholder="Category"
          />
        </template>
        <template v-else>
          {{ getCategoryPath(post.category_id) }}
        </template>
      </p>

      <p class="text-sm text-gray-500 dark:text-gray-400">Posted by: {{ post.user.name }}</p>

      <div class="flex gap-2">
        <template v-if="canEdit">
          <button
            v-if="!isEditing"
            @click="startEditing"
            class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700"
          >
            Edit
          </button>
          <button
            v-if="isEditing"
            @click="saveChanges"
            class="px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700"
          >
            Save
          </button>
          <button
            v-if="isEditing"
            @click="cancelEditing"
            class="px-4 py-2 text-sm font-medium text-white bg-gray-600 rounded-lg hover:bg-gray-700"
          >
            Cancel
          </button>
        </template>

        <button
          v-if="canDelete"
          @click="deletePost"
          class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700"
        >
          Delete
        </button>
      </div>

      <!-- Use the PostComment component -->
      <PostComment
        :comments="comments"
        :currentUser="currentUser"
        :postId="post.id"
        @comment-added="handleCommentAdded"
        @comment-edited="handleCommentEdited"
        @comment-deleted="handleCommentDeleted"
      />

    </div>
  </template>

<script setup>
  import { computed, ref } from 'vue';
  import { usePage, router } from '@inertiajs/vue3';
  import PostComment from '@/Features/Forums/PostComment.vue';

  const props = defineProps({
    post: Object,
    categories: Array,
  });

  const currentUser = usePage().props.currentUser;

  const comments = ref([...props.post.comments]);

  const isEditing = ref(false);
  const editedPost = ref({ ...props.post });

  const canEdit = computed(() => currentUser.id === props.post.user_id);
  const canDelete = computed(() => currentUser.id === props.post.user_id);

  const startEditing = () => {
    isEditing.value = true;
  };

  const saveChanges = async () => {
    await router.put(`/forums/${props.post.id}`, editedPost.value);
    isEditing.value = false;
    props.post.title = editedPost.value.title;
    props.post.content = editedPost.value.content;
    props.post.category = editedPost.value.category;
  };

  const cancelEditing = () => {
    isEditing.value = false;
    editedPost.value = { ...props.post };
  };

  const deletePost = async () => {
    if (confirm('Are you sure you want to delete this post?')) {
      await router.delete(`/forums/${props.post.id}`);
    }
  };

  // Function to get the full category path
  const getCategoryPath = (categoryId) => {
    const findCategory = (categories, categoryId) => {
      for (const category of categories) {
        if (category.id === categoryId) {
          return category;
        }
        if (category.children && category.children.length) {
          const found = findCategory(category.children, categoryId);
          if (found) return found;
        }
      }
      return null;
    };

    const category = findCategory(props.categories, categoryId);
    if (!category) return 'Uncategorized';

    // Build the category path
    const path = [];
    let currentCategory = category;

    while (currentCategory) {
      path.unshift(currentCategory.name);
      currentCategory = props.categories.find(c => c.id === currentCategory.parent_id);
    }

    return path.join(' > ');
  };

  // Handle comment events
  const handleCommentAdded = (newComment) => {
    comments.value.push(newComment);
  };

  const handleCommentEdited = ({ id, content }) => {
    const index = comments.value.findIndex((c) => c.id === id);
    if (index !== -1) {
      comments.value[index].content = content;
    }
  };

  const handleCommentDeleted = (commentId) => {
    comments.value = comments.value.filter((c) => c.id !== commentId);
  };
  </script>
