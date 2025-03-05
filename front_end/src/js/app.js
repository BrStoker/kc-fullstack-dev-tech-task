import api from './api.js';

document.addEventListener('DOMContentLoaded', async () => {
    let coursesList = document.getElementById('courses-grid');

    let categories = await api.getCategories();
    let courses = await api.getCourses();

    function renderCategories(parentId = null) {

        let categoriesList = document.getElementById('category-list');
        let categoryMap = {};

        categories.forEach(category => {
            // Если родительская категория существует, добавляем её в соответствующий массив
            if (!categoryMap[category.parent_id]) {
                categoryMap[category.parent_id] = [];
            }
            categoryMap[category.parent_id].push(category);
        });

        let categoriesToRender = parentId ? categoryMap[parentId] || Object.values(categoryMap).flat() : Object.values(categoryMap).flat();

        categoriesToRender.forEach(category => {
            let categoryItem = document.createElement('li');
            categoryItem.classList.add('cursor-pointer', 'text-black', 'font-bold');
            categoryItem.innerHTML = category.name;

            categoryItem.addEventListener('click', () => filterCoursesByCategory(category.id));

            categoriesList.appendChild(categoryItem);

            if (categoryMap[category.id] && categoryMap[category.id].length > 0) {
                let subCategoryList = document.createElement('ul');
                subCategoryList.classList.add('ml-4', 'space-y-1');
                categoryMap[category.id].forEach(subCategory => {
                    let subCategoryItem = document.createElement('li');
                    subCategoryItem.classList.add('cursor-pointer', 'text-black', 'font-bold');
                    subCategoryItem.innerHTML = subCategory.name;
                    subCategoryItem.addEventListener('click', () => filterCoursesByCategory(subCategory.id));
                    subCategoryList.appendChild(subCategoryItem);
                });
                categoryItem.appendChild(subCategoryList);
            }
        });
    }

    function renderCourses(courses) {
        coursesList.innerHTML = ''; // Очищаем список перед добавлением новых курсов

        courses.forEach(course => {
            let courseItem = document.createElement('div');
            courseItem.classList.add('flex', 'flex-col', 'bg-white', 'rounded-lg', 'shadow-md', 'border', 'border-gray-300', 'cursor-pointer', 'overflow-hidden');

            courseItem.innerHTML = `
            <div class="relative">
                <img src="${course.image_preview}" alt="${course.title}" class="w-full h-48 object-cover rounded-t-lg">
                <p class="category-button absolute top-2 right-2 bg-gray-200 text-black text-xs px-2 py-1 rounded border border-gray-400 shadow-sm" data-category-id="${course.category_id}">${getCategoryName(course.category_id)}</p>
            </div>
            <div class="mx-3 my-2">
                <h2 class="text-lg truncate-title font-semibold mt-2">${course.title}</h2>
                <p class="text-base truncate-text font-semibold mt-2">${course.description}</p>
            </div>
        `;
            coursesList.appendChild(courseItem);
        });
        document.querySelectorAll('.category-button').forEach(button => {
            button.addEventListener('click', function() {
                let categoryId = this.getAttribute('data-category-id');
                filterCoursesByCategory(categoryId);
            });
        });
    }


    function filterCoursesByCategory(categoryId) {
        let filteredCourses = courses.filter(course => course.category_id === categoryId);
        renderCourses(filteredCourses);
    }

    function getCategoryName(categoryId) {
        let category = categories.find(item => item['id'] === categoryId)
        return category['name']

    }


    renderCategories(categories);
    renderCourses(courses);
});
