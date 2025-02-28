export const truncateContent = (content, maxWords) => {
    const words = content.split(' ');
    return words.length <= maxWords ? content : words.slice(0, maxWords).join(' ') + '...';
  };

  export const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-GB', {
      year: 'numeric',
      month: 'long',
      day: 'numeric',
      hour: '2-digit',
      minute: '2-digit',
    });
  };

  export const getCategoryName = (categories, categoryId) => {
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

    const category = findCategory(categories, categoryId);
    if (!category) return 'Uncategorized';

    const path = [];
    let currentCategory = category;

    while (currentCategory) {
      path.unshift(currentCategory.name);
      currentCategory = categories.find(c => c.id === currentCategory.parent_id);
    }

    return path.join(' > ');
  };
