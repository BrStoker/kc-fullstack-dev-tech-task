<?php
header("Content-Type: text/html; charset=utf-8");
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Catalog</title>
    <link rel="stylesheet" href="src/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

</head>
<body class="bg-gray-300">
<div id="app" class="container mx-auto p-4">
    <div class="flex flex-col md:flex-row md:gap-6">
        <div id="categories-button" class="block md:hidden w-full p-4 rounded">
            <button onclick="toggleCategories()">
                <span id="hamburger-icon" class="block w-6 h-1 bg-white mb-1"></span>
                <span id="hamburger-icon" class="block w-6 h-1 bg-white mb-1"></span>
                <span id="hamburger-icon" class="block w-6 h-1 bg-white mb-1"></span>
            </button>
        </div>
        <div id="categories-list" class="lg:w-1/4 md:block hidden lg:mt-16 md:mt-16">
            <ul id="category-list" class="space-y-2"></ul>
        </div>
        <div id="courses-list" class="w-full sm:w-1/2 md:w-3/4 lg:w-3/4">
            <h1 class="text-3xl font-bold mb-6 text-center">
                <a href="/">Course Catalog</a>
            </h1>
            <div id="courses-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-1 lg:grid-cols-3 gap-6"></div>
        </div>
    </div>
</div>



<script type="module" src="src/js/app.js"></script>
<script>
    function toggleCategories() {
        let categoriesList = document.getElementById('categories-list');
        let button = document.getElementById('categories-button');
        categoriesList.classList.toggle('hidden');
        button.classList.toggle('opened');
    }
</script>
</body>
</html>
