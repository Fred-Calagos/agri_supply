<div class="container mt-4">
    <div class="row">
        <?php foreach($categories as $category): ?>
            <div class="col-12 mb-2">
                <div class="card shadow-sm card-category">
                    <div class="card-body d-flex align-items-center justify-content-start">
                        <h5 class="card-title text-left m-0"><?= htmlspecialchars($category['product_category']) ?></h5>
                        <a href="/customer/category?category=<?= htmlspecialchars($category['id']) ?>" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
/* Full-width category card */
.card-category {
    background: #f8f9fa; /* Light gray background */
    border-radius: 10px;
    border: none;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    padding: 10px;
}
</style>
