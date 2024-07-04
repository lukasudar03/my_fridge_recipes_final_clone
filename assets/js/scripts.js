document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('search-recipes').addEventListener('keyup', (e) => {
        const query = e.target.value;
        fetch(`api/search_recipes.php?q=${query}`)
            .then(response => response.json())
            .then(data => {
                // Prikaz rezultata pretrage
                const resultsContainer = document.getElementById('search-results');
                resultsContainer.innerHTML = '';
                data.forEach(recipe => {
                    const recipeElement = document.createElement('div');
                    recipeElement.innerHTML = `<h3>${recipe.name}</h3>`;
                    resultsContainer.appendChild(recipeElement);
                });
            });
    });
});
