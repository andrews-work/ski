<template>
    <div>
      <h1>Edit Post</h1>
      <form @submit.prevent="updatePost">
        <div>
          <label for="title">Title:</label>
          <input type="text" v-model="form.title" id="title" required />
        </div>
        <div>
          <label for="content">Content:</label>
          <textarea v-model="form.content" id="content" required></textarea>
        </div>
        <div>
          <label for="category">Category:</label>
          <select v-model="form.category" id="category" required>
            <option value="General">General</option>
            <option value="Support">Support</option>
            <option value="Off-Topic">Off-Topic</option>
          </select>
        </div>
        <button type="submit">Update Post</button>
      </form>
    </div>
  </template>

  <script setup>
  import { ref, onMounted } from 'vue';
  import { useRoute, useRouter } from 'vue-router';
  import forumService from '@/services/forum';

  const route = useRoute();
  const router = useRouter();
  const form = ref({
    title: '',
    content: '',
    category: 'General',
  });

  onMounted(async () => {
    try {
      const response = await forumService.getPost(route.params.id);
      form.value = response.data;
    } catch (error) {
      console.error('Error fetching post:', error);
    }
  });

  const updatePost = async () => {
    try {
      await forumService.updatePost(route.params.id, form.value);
      router.push('/forums');
    } catch (error) {
      console.error('Error updating post:', error);
    }
  };
  </script>
