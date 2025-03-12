
<div class="container-fluid mt-4 bg-dark-50">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/products"><i class='bx bx-store-alt bread-icon'></i> Products</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Edit Product</li>
            </ol>
        </nav>
    </div>
    <form id="editProductForm" action="/products/update/<?= $product['id'] ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

        <div class="row mb-1">
            <div class="p-3 border rounded bg-white">
                <div class="row p-3">
                    <!-- Left Column: Image Upload & Preview -->
                    <div class="col-md-3 text-center">
                        <div class="section-title mb-1">Product Image</div>
                        <img src="<?= !empty($product['image_path']) ? htmlspecialchars($product['image_path']) : '/assets/images/placeholder-image.jpg' ?>" 
                             class="img-fluid img-thumbnail mb-1" 
                             id="productImagePreview" 
                             alt="Product Image"
                             style="width: 400px; height: 200px; object-fit: contain; ">

                        <input type="file" class="form-control" id="productImage" name="image" accept="image/*" onchange="previewImage(event)" value="<?=  htmlspecialchars($product['image_path'])?>">
                    </div>

                    <!-- Right Column: Product Details -->
                    <div class="col-md-9">
                        <div class="section-title mb-2">Product Details</div>

                        <div class="row mt-2">
                            <div class="col-md-4 mb-3">
                                <label for="productName" class="form-label">Product Name</label>
                                <input type="text" class="form-control" id="productName" name="product_name" value="<?= htmlspecialchars($product['product_name']) ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="productCategory" class="form-label">Category</label>
                                <select class="form-control" id="productCategory" name="product_category_id" required>
                                    <option value="" hidden disabled>Select a Category</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?= $category['id'] ?>" <?= ($category['id'] == $product['product_category_id']) ? 'selected' : '' ?>>
                                            <?= $category['product_category'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
        
                            <div class="col-md-4 mb-3">
                                <label for="productStatus" class="form-label">Status</label>
                                <select class="form-control" id="productStatus" name="product_status_id" required>
                                    <?php foreach ($productStatus as $prodStatus): ?>
                                        <option value="<?= $prodStatus['id'] ?>" <?= ($prodStatus['id'] == $product['product_status_id']) ? 'selected' : '' ?> required>
                                            <?= $prodStatus['product_status'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="mb-3">
                                <label for="productDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="productDescription" name="product_description" rows="3" required><?= htmlspecialchars($product['product_description']) ?></textarea>
                            </div>
                        </div>
                    </div>
<div class="row">
    <div class="section-title">Product Specifications</div>
</div>

<div class="row">
    <?php 

    if (!empty($productSpecifications)): ?>
    <div class="row">
        <?php foreach ($productSpecifications as $spec): ?>
            <div class="col-md-3 mb-3">
                <label for="spec_<?= htmlspecialchars($spec['id']) ?>" class="form-label"><?= htmlspecialchars($spec['name']) ?></label>
                <input type="text" class="form-control" id="spec_<?= htmlspecialchars($spec['id']) ?>" name="specifications[<?= htmlspecialchars($spec['id']) ?>]" value="<?= htmlspecialchars($spec['value']) ?>">
            </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
        <p class="text-muted">No specifications available.</p>
    <?php endif; ?>
</div>

                </div>
                
                <div class="d-flex justify-content-between mt-3">
                    <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
                    <button type="submit" class="btn btn-success btn-sm"><i class="bx bx-save"></i> Update Product</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script>

    function previewImage(event) {
        const imagePreview = document.getElementById('productImagePreview');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                imagePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = "<?= !empty($product['image']) ? '/uploads/' . htmlspecialchars($product['image']) : '/assets/images/placeholder-image.jpg' ?>";
        }
    }
</script>
