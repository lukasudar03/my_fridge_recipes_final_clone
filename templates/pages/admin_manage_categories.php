<?php //include __DIR__ . '/../partials/header.php'; ?>
<?php //require_login(); require_admin(); ?>
<!--<div class="container">-->
<!--    <h1>Manage Categories</h1>-->
<!--    <form action="../../controllers/admin_controller.php" method="post">-->
<!--        <div class="form-group">-->
<!--            <label for="category_name">Category Name</label>-->
<!--            <input type="text" id="category_name" name="category_name" class="form-control" required>-->
<!--        </div>-->
<!--        <button type="submit" class="btn btn-primary" name="add_category">Add Category</button>-->
<!--    </form>-->
<!--    <h2>Existing Categories</h2>-->
<!--    <ul>-->
<!--        --><?php
//        require_once __DIR__ . '/../../models/category.php';
//        $categories = Category::get_all_categories();
//        foreach ($categories as $category): ?>
<!--            <li>-->
<!--                --><?php //echo htmlspecialchars($category['name']); ?>
<!--                <a href="../../controllers/admin_controller.php?action=delete_category&id=--><?php //echo htmlspecialchars($category['id']); ?><!--" class="btn btn-danger btn-sm">Delete</a>-->
<!--            </li>-->
<!--        --><?php //endforeach; ?>
<!--    </ul>-->
<!--</div>-->
<?php //include __DIR__ . '/../partials/footer.php'; ?>

<?php
include __DIR__ . '/../partials/header.php';
require_once __DIR__ . '/../../models/Category.php';
require_once __DIR__ . '/../../utils/session.php';

require_login(); require_admin();


$categories = Category::get_all_categories();
?>

<div class="container">
    <h1>Manage Categories</h1>
    <form id="category-form">
        <div class="form-group">
            <label for="category-name">Category Name:</label>
            <input type="text" id="category-name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Category</button>
    </form>

    <h2>Existing Categories</h2>
    <ul id="category-list">
        <?php foreach ($categories as $category): ?>
            <li>
                <?php echo htmlspecialchars($category['name']); ?>
                <button class="btn btn-danger delete-category-btn" data-category-id="<?php echo $category['id']; ?>">Delete</button>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<?php include __DIR__ . '/../partials/footer.php'; ?>

<script>
    document.getElementById('category-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        const category_name = document.getElementById('category-name').value;
        formData.append('name', category_name);
        formData.append('action', 'create_category');

        fetch('controllers/category_controller.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Category added successfully!');
                    location.reload();
                } else {
                    alert('Failed to add category. ' + (data.message || ''));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
    });




    document.querySelectorAll('.delete-category-btn').forEach(button => {
        button.addEventListener('click', function() {
            const categoryId = this.dataset.categoryId;
            const formData = new FormData();
            formData.append('action', 'delete_category');
            formData.append('id', categoryId);

            fetch('controllers/category_controller.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Category deleted successfully!');
                        location.reload();
                    } else {
                        alert('Failed to delete category. ' + (data.message || ''));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        });
    });
</script>
