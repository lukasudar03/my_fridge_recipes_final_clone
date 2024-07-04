<?php
//include __DIR__ . '/../partials/header.php';
//require_once __DIR__ . '/../../models/recipe.php';
//require_once __DIR__ . '/../../utils/session.php';
//
//if (!isset($_SESSION['user_id'])) {
//    header("Location: login.php");
//    exit();
//}
//
//$recipe_id = $_GET['id'];
//$recipe = Recipe::get_recipe_by_id($recipe_id);
//$user_id = $_SESSION['user_id'];
//$is_favorite = Recipe::is_favorite($user_id, $recipe_id);
//?>
<!---->
<!--<div class="container">-->
<!--    <h1>--><?php //echo $recipe['name']; ?><!--</h1>-->
<!--    <p>--><?php //echo $recipe['description']; ?><!--</p>-->
<!--    <p>Ingredients: --><?php //echo $recipe['ingredients']; ?><!--</p>-->
<!--    <p>Price: --><?php //echo $recipe['price']; ?><!--</p>-->
<!--    --><?php //if ($is_favorite): ?>
<!--        <button onclick="removeFavorite(--><?php //echo $recipe_id; ?>//)">Remove from Favorites</button>
//    <?php //else: ?>
<!--        <button onclick="addFavorite(--><?php //echo $recipe_id; ?>//)">Add to Favorites</button>
//    <?php //endif; ?>
<!--    <form id="comment-form">-->
<!--        <textarea id="comment-text" required></textarea>-->
<!--        <button type="submit">Add Comment</button>-->
<!--    </form>-->
<!--    <div id="comments">-->
<!--        <!-- Comments will be loaded here -->-->
<!--    </div>-->
<!--</div>-->
<?php //include __DIR__ . '/../partials/footer.php'; ?>
<!---->
<!--<script>-->
<!--    function addFavorite(recipeId) {-->
<!--        fetch(`../../controllers/recipe_controller.php?action=add_favorite&id=${recipeId}`)-->
<!--            .then(response => response.json())-->
<!--            .then(data => {-->
<!--                if (data.success) {-->
<!--                    location.reload();-->
<!--                } else {-->
<!--                    alert('Failed to add favorite recipe.');-->
<!--                }-->
<!--            });-->
<!--    }-->
<!---->
<!--    function removeFavorite(recipeId) {-->
<!--        fetch(`../../controllers/recipe_controller.php?action=remove_favorite&id=${recipeId}`)-->
<!--            .then(response => response.json())-->
<!--            .then(data => {-->
<!--                if (data.success) {-->
<!--                    location.reload();-->
<!--                } else {-->
<!--                    alert('Failed to remove favorite recipe.');-->
<!--                }-->
<!--            });-->
<!--    }-->
<!---->
<!--    document.getElementById('comment-form').addEventListener('submit', function(event) {-->
<!--        event.preventDefault();-->
<!--        const commentText = document.getElementById('comment-text').value;-->
<!--        fetch('../../controllers/comment_controller.php', {-->
<!--            method: 'POST',-->
<!--            body: JSON.stringify({ recipe_id: --><?php //echo $recipe_id; ?>//, comment: commentText }),
//            headers: { 'Content-Type': 'application/json' }
//        })
//            .then(response => response.json())
//            .then(data => {
//                if (data.success) {
//                    location.reload();
//                } else {
//                    alert('Failed to add comment.');
//                }
//            });
//    });
//
//    function loadComments() {
//        fetch(`../../controllers/comment_controller.php?action=get_comments&recipe_id=<?php //echo $recipe_id; ?>//`)
//            .then(response => response.json())
//            .then(data => {
//                const commentsDiv = document.getElementById('comments');
//                commentsDiv.innerHTML = '';
//                data.comments.forEach(comment => {
//                    const commentElement = document.createElement('div');
//                    commentElement.textContent = comment.text;
//                    commentsDiv.appendChild(commentElement);
//                });
//            });
//    }
//
//    document.addEventListener('DOMContentLoaded', loadComments);
//</script>
