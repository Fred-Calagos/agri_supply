<div class="container">
    <!-- Navigation and Button Container -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/settings"><i class='bx bx-cog bread-icon'></i> Settings</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"> Product Status</li>
            </ol>
        </nav>

        <!-- Add Product Status  Button -->
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#productStatModal">
            <i class="bx bx-plus-circle"></i> Product Status
        </button>
    </div>

    <!-- Message Container -->
    <div id="message-container"></div>

    <!-- Product Status  Table -->
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>No.</th>
                <th>Product Status </th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productStatus as $index => $productStat): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $productStat['product_status'] ?></td>
                    <td>    
                        <button class="edit-product-status btn btn-warning btn-sm" 
                                data-id="<?= $productStat['id'] ?>" 
                                data-product-status="<?= $productStat['product_status'] ?>">
                            <i class="bx bxs-edit"></i> Edit
                        </button>
                        <button class="delete-product-status btn btn-danger btn-sm" 
                                data-id="<?= $productStat['id'] ?>">
                            <i class="bx bxs-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Modal for Adding Product Status  -->
    <div class="modal fade" id="productStatModal" tabindex="-1" aria-labelledby="productStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productStatusModalLabel">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductStatusForm">
                        <div class="mb-3">
                            <label for="productStatus" class="form-label">Product Status</label>
                            <input type="text" class="form-control" id="productStatus" name="product_status" placeholder="Enter Product Status " required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-sm" id="saveProductStatus"><i class="bx bx-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Status  Modal -->
    <div class="modal fade" id="editProductStatusModal" tabindex="-1" aria-labelledby="editLevelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLevelModalLabel">Edit Product Status </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductStatusForm">
                        <input type="hidden" id="editProductStatId" name="id">
                        <div class="mb-3">
                            <label for="editProductStatus" class="form-label">Product Status </label>
                            <input type="text" class="form-control" id="editProductStatus" name="product_status" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="saveEditedProductStatus"><i class="bx bx-save"></i> Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Product Status Modal -->
    <div class="modal fade" id="deleteProductStatusModal" tabindex="-1" aria-labelledby="deleteProductStatusLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteProductStatusLabel">Delete Product Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this product status?</p>
                    <p id="productStatusInfo"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteProductStatus">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
        $(document).ready(function() {
            function saveProductStatus() {
                $('#productStatModal').modal('hide');

                $.ajax({
                    type: "POST",
                    url: "/product_status/store",
                    data: $("#addProductStatusForm").serialize(),
                    success: function (response) {
                        var message = $('<div class="alert alert-success">Product Status Added Successfully!</div>');

                        $('#message-container').html('').append(message);

                        setTimeout(function () {
                            message.fadeOut();
                            location.reload();
                        }, 2000);
                    },
                    error: function () {
                        var message = $('<div class="alert alert-danger">Error adding Product Status.</div>');

                        $('#message-container').html('').append(message);

                        setTimeout(function () {
                            message.fadeOut();
                        }, 2000);
                    }
                });
            }

            // Click event for Save button
            $("#saveProductStatus").click(function () {
                saveProductStatus();
            });

            // Listen for Enter key press in the input field
            $("#productStatus").keypress(function (event) {
                if (event.which === 13) { // Check if Enter key is pressed
                    event.preventDefault();
                    saveProductStatus();
                }
            });


        $(document).on('click', '.edit-product-status', function() {
            $('#editProductStatId').val($(this).data('id'));
            $('#editProductStatus').val($(this).data('product-status'));
            $('#editProductStatusModal').modal('show');
        });


        $(document).ready(function () {
                function saveEditedProductStatus() {
                    var prodStatId = $('#editProductStatId').val();

                    $.ajax({
                        type: "POST",
                        url: "/product_status/update/" + prodStatId, // Send the ID in the URL
                        data: $("#editProductStatusForm").serialize(),
                        dataType: "json",
                        success: function (response) {
                            var message = $('<div class="alert alert-success">Product status Updated Successfully!</div>');
                            $('#message-container').html('').append(message);

                            $('#editProductStatusModal').modal('hide');

                            setTimeout(function () {
                                message.fadeOut();
                                location.reload();
                            }, 2000);
                        },
                        error: function () {
                            var message = $('<div class="alert alert-danger">Error updating Product Status.</div>');
                            $('#message-container').html('').append(message);

                            setTimeout(function () {
                                message.fadeOut();
                            }, 2000);
                        }
                    });
                }

                // Click event for the Save button
                $('#saveEditedProductStatus').click(function (event) {
                    event.preventDefault();
                    saveEditedProductStatus();
                });

                // Listen for Enter key press in the input field
                $('#editProductStatus').keypress(function (event) {
                    if (event.which === 13) { // Check if Enter key is pressed
                        event.preventDefault();
                        saveEditedProductStatus();
                    }
                });
            });

        // deleting the status if necessary
        $(document).on('click', '.delete-product-status', function () {
            var productStatusId = $(this).data('id');
            var productStatusText = $(this).closest('tr').find('td:nth-child(2)').text(); // Get the status text

            $('#productStatusInfo').text('Product Status: ' + productStatusText);
            $('#confirmDeleteProductStatus').data('id', productStatusId); // Store the ID in the button

            $('#deleteProductStatusModal').modal('show');
        });

        $('#confirmDeleteProductStatus').click(function () {
            var productStatusId = $(this).data('id');

            if (!productStatusId) {
                alert("Error: No Product Status ID found.");
                return;
            }

            $.ajax({
                type: "GET",
                url: "/product_status/delete/" + productStatusId,
                success: function(response) {
                    var message = $('<div class="alert alert-success">Product Status Deleted Successfully!</div>');
                    $('#message-container').html('').append(message);
                    $('#deleteProductStatusModal').modal('hide');
                    setTimeout(function () {
                        message.fadeOut();
                        location.reload();
                    }, 2000);
                },
                error: function() {
                    var message = $('<div class="alert alert-danger">Error deleting Product Status.</div>');
                    $('#message-container').html('').append(message);
                    setTimeout(function () {
                        message.fadeOut();
                    }, 2000);
                }
            });
        });
    });

</script>