<div class="container">
    <!-- Navigation and Button Container -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/products"><i class='bx bx-box bread-icon'></i> Products</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"> Product Category</li>
            </ol>
        </nav>

        <!-- Add Product Category Button -->
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#productCategoryModal">
            <i class="bx bx-plus-circle"></i> Add Product Category
        </button>
    </div>

    <!-- Message Container -->
    <div id="message-container"></div>

    <!-- Product Category Table -->
    <div class="container-fluid container-sm">
        <div class="p-3 border rounded bg-white mt-4">
        <table class="table">
        <thead class="table-light">
            <tr>
                <th>No.</th>
                <th>Category Name</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productCategories as $index => $category): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $category['product_category'] ?></td>
                    <td><?= $category['description'] ?></td>
                    <td>    
                        <button class="edit-product-category btn btn-warning btn-sm" 
                                data-id="<?= $category['id'] ?>" 
                                data-product-category="<?= $category['product_category'] ?>"
                                data-product-description="<?= $category['description'] ?>">
                            <i class="bx bxs-edit"></i> Edit
                        </button>
                        <a href="/product/category/specification?category=<?= $category['id'] ?>" class="btn btn-success btn-sm">
                            <i class="bx bx-plus-circle"></i> Specification
                        </a>
                        <button class="btn btn-danger delete-category  btn-sm" 
                                data-id="<?= $category['id'] ?>">
                            <i class="bx bxs-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

        </div>
    </div>

    <!-- Modal for Adding Product Category -->
    <div class="modal fade" id="productCategoryModal" tabindex="-1" aria-labelledby="productCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productCategoryModalLabel">Add Product Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addCategoryForm">
                        <div class="mb-3">
                            <label for="categoryName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="categoryName" name="product_category" placeholder="Enter Category Name" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoryDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="categoryDescription" name="description" placeholder="Enter Description" rows="4" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-sm" id="saveCategory"><i class="bx bx-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Category Modal -->
    <div class="modal fade" id="editProductCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Product Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductCategoryForm">
                        <input type="hidden" id="editCategoryId" name="id">
                        <div class="mb-3">
                            <label for="editProductCategoryName" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="editProductCategoryName" name="product_category" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductCategoryDescription" class="form-label">Category Description</label>
                            <textarea class="form-control" id="editProductCategoryDescription" name="description" rows="4" required></textarea>
                        </div>
                        <div class="modal-footer d-flex justify-content-between">
                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary btn-sm" id="saveEditedCategory"><i class="bx bx-save"></i> Save Changes</button>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#saveCategory").click(function() {
            $('#productCategoryModal').modal('hide');

            $.ajax({
                type: "POST",
                url: "/product_category/store",
                data: $("#addCategoryForm").serialize(),
                success: function (response) {
                var message = $('<div class="alert alert-success">Product Category Added Successfully!</div>');

                    $('#message-container').html('').append(message);

                    setTimeout(function () {
                        message.fadeOut();
                        location.reload();
                    }, 2000);
                },
                error: function () {
                    var message = $('<div class="alert alert-danger">Error Adding Product Category.</div>');

                    $('#message-container').html('').append(message);

                    setTimeout(function () {
                        message.fadeOut();
                    }, 2000);
                }
                });
            });


        $(document).on('click', '.edit-product-category', function() {
            $('#editCategoryId').val($(this).data('id'));
            $('#editProductCategoryName').val($(this).data('product-category'));
            $('#editProductCategoryDescription').val($(this).data('product-description'));
            $('#editProductCategoryModal').modal('show');
        });

        $('#saveEditedCategory').click(function (event) {
            event.preventDefault();
            
            var prodCatId = $('#editCategoryId').val();
            
            $.ajax({
                type: "POST",
                url: "/product_category/update/" + prodCatId, // Send the ID in the URL
                data: $("#editProductCategoryForm").serialize(),
                dataType: "json",
                success: function (response) {
                    var message = $('<div class="alert alert-success">Product Category Successfully!</div>');
                    $('#message-container').html('').append(message);

                    $('#editProductCategoryModal').modal('hide');

                    setTimeout(function () {
                        message.fadeOut();
                        location.reload();
                    }, 2000);
                },
                error: function () {
                    var message = $('<div class="alert alert-danger">Error updating Product Category.</div>');
                    $('#message-container').html('').append(message);

                    setTimeout(function () {
                        message.fadeOut();
                    }, 2000);
                }
            });
        });

    });
</script>