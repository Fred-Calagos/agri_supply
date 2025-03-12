<!-- Product Cards -->
<?php if (!empty($productCategory)): ?>
<div class="row g-3">
        <?php foreach ($productCategory as $product): ?> 
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card product-card h-100 shadow-sm add-to-cart-card" 
                    data-id="<?= htmlspecialchars($product['id']) ?>" 
                    onclick="window.location.href='/customer/product_detail/<?= htmlspecialchars($product['id']) ?>'">
                    
                    <img src="<?= htmlspecialchars($product['image_path']) ?>" class="card-img-top product-img" alt="Product Image">
                    <div class="card-body text-center border border-top">
                        <h5 class="card-title"><?= htmlspecialchars($product['product_name']) ?></h5>
                        <p class="card-text text-success fw-bold">₱ <?= number_format($product['selling_price'], 2) ?> per kilo</p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
</div>
<?php else: ?>
    <div class="text-center p-4">
        <h5 class="text-muted">No Product Available in this Category Yet!</h5>
    </div>
<?php endif; ?>