<div class="container">
    <div class="d-flex align-items-center justify-content-between mb-3">

        <div>
        <a href="/products/create" class="btn btn-primary">+ Add Product</a>
        </div>
    </div>

    <div id="message-container"></div>

    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>No.</th>
                <th>Image</th>
                <th>Product Name</th>
                <th>Product Description</th>
                <th>Selling Price</th>
                <th>Stocks</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($products as $index => $product): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td>
                    <img src="<?= htmlspecialchars( $product['image_path']) ?>"
                        alt="Product Image"
                        class="img-thumbnail"
                        style="width: 50px; height: 50px; object-fit: cover;">
                </td>
                <td><?= htmlspecialchars($product['product_name']) ?></td>
                <td><?= htmlspecialchars($product['product_description']) ?></td>
                <td>₱<?= number_format($product['selling_price'], 2) ?></td>
                <td><?= htmlspecialchars($product['stocks']) ?></td>
                <td>
                    <div class="d-flex justify-content-between">
                        <!-- Edit Button (Left) -->
                        <a href="/products/edit/<?= $product['id'] ?>" class="btn btn-warning">
                            <i class="bx bxs-edit"></i>
                        </a>

                        <a href="/products/batch/<?= $product['id'] ?>" class="btn btn-success">
                            <i class='bx bx-list-plus'></i>
                        </a>
                        <!-- Delete Button (Right) -->
                        <button class="delete-product btn btn-danger" data-id="<?= $product['id'] ?>">
                            <i class="bx bxs-trash"></i>
                        </button>
                    </div>
                </td>

            </tr>
        <?php endforeach; ?>

        </tbody>
    </table>





    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editProductForm">
                    <div class="modal-body">
                        <input type="hidden" name="id" id="editProductId">
                        <label for="editProductName">Product Name:</label>
                        <input type="text" id="editProductName" name="name" class="form-control" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" id="saveEditedProduct"><i class="bx bx-save"></i> Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteProductModal" tabindex="-1" aria-labelledby="deleteProductModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProductModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete <strong id="delete_product_name"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <form id="deleteProductForm">
                        <input type="hidden" name="id" id="delete_product_id">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger" id="confirmDeleteProduct"><i class="bx bxs-trash"></i> Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).on('click', '.edit-product', function() {
            $('#editProductId').val($(this).data('id'));
            $('#editProductName').val($(this).data('name'));
            $('#editProductModal').modal('show');
        });

        $('#saveEditedProduct').click(function (event) {
            event.preventDefault();
            
            var productId = $('#editProductId').val();
            
            $.ajax({
                type: "POST",
                url: "/products/update/" + productId, 
                data: $("#editProductForm").serialize(),
                dataType: "json",
                success: function () {
                    alert("Product Updated Successfully!");
                    location.reload();
                },
                error: function () {
                    alert("Error updating product.");
                }
            });
        });

        $(document).on('click', '.delete-product', function() {
            if (confirm("Are you sure you want to delete this product?")) {
                $.ajax({
                    type: "GET",
                    url: "/products/delete/" + $(this).data('id'),
                    success: function() {
                        alert("Product Deleted Successfully!");
                        location.reload();
                    },
                    error: function() {
                        alert("Error deleting product.");
                    }
                });
            }
        });
    });

    


</script>
