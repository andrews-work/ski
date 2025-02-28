import { router } from '@inertiajs/vue3';

// Posts
export const fetchPosts = (page = 1, filters = {}) => {
  return router.get('/forums', { page, ...filters }, {
    preserveState: true,
  });
};

export const fetchPost = (postId) => {
  return router.get(`/forums/${postId}`, {}, {
    preserveState: true,
  });
};

export const createPost = (postData) => {
  return router.post('/forums', postData);
};

export const updatePost = (postId, postData) => {
  return router.put(`/forums/${postId}`, postData);
};

export const deletePost = (postId) => {
  return router.delete(route('forums.destroy', { post: postId }));
};

// Categories
export const fetchCategory = (categoryId) => {
  return router.get(`/forums/categories/${categoryId}`, {}, {
    preserveState: true,
  });
};
