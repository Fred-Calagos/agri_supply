<div class="container mt-4">
    <!-- Fruit Section -->
    <div class="p-3 border rounded bg-white mb-3">
        <h4 class="section-title mb-3">🍎 Fruit Section</h4>
        <div class="row g-3">
            <?php foreach ($fruitProducts as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card product-card h-100 shadow-sm">
                        <img src="<?= htmlspecialchars($product['image_path']) ?>" class="card-img-top product-img" alt="Product Image">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($product['product_name']) ?></h5>
                            <p class="card-text text-success fw-bold">₱ <?= number_format($product['selling_price'], 2) ?> per kilo</p>
                            <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary btn-sm add-to-cart" data-id="<?= $product['id'] ?>">
                                <i class='bx bx-cart-add' style="font-size: 1.2rem;"></i> Add to Cart
                            </button>
                                <i class='bx bx-heart heart-icon' style="font-size: 1.5rem; cursor: pointer;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Vegetable Section -->
    <div class="p-3 border rounded bg-white">
        <h4 class="section-title mb-3">🥦 Vegetable Section</h4>
        <div class="row g-3">
            <?php foreach ($vegetableProducts as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card product-card h-100 shadow-sm">
                        <img src="<?= htmlspecialchars($product['image_path']) ?>" class="card-img-top product-img" alt="Product Image">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($product['product_name']) ?></h5>
                            <p class="card-text text-success fw-bold">₱ <?= number_format($product['selling_price'], 2) ?> per kilo</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <button class="btn btn-primary btn-sm">
                                    <i class='bx bx-cart-add' style="font-size: 1.2rem;"></i> Add to Cart
                                </button>
                                <i class='bx bx-heart heart-icon' style="font-size: 1.5rem; cursor: pointer;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
