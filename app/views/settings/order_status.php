<div class="container">
    <!-- Navigation and Button Container -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/settings"><i class='bx bx-cog bread-icon'></i> Settings</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"> Order Status</li>
            </ol>
        </nav>

        <!-- Add Order Status  Button -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#orderStatModal">
            <i class="bx bx-plus-circle"></i> Add Order Status
        </button>
    </div>

    <!-- Message Container -->
    <div id="message-container"></div>

    <!-- Order Status  Table -->
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>No.</th>
                <th>Order Status </th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orderStatus as $index => $orderStat): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $orderStat['order_status'] ?></td>
                    <td>    
                        <button class="edit-order-status btn btn-warning" 
                                data-id="<?= $orderStat['id'] ?>" 
                                data-order-status="<?= $orderStat['order_status'] ?>">
                            <i class="bx bxs-edit"></i> Edit
                        </button>
                        <button class="delete-order-status btn btn-danger" 
                                data-id="<?= $orderStat['id'] ?>">
                            <i class="bx bxs-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Modal for Adding Order Status  -->
    <div class="modal fade" id="orderStatModal" tabindex="-1" aria-labelledby="orderStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderStatusModalLabel">Add  Categroy</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addOrderStatusForm">
                        <div class="mb-3">
                            <label for="orderStatus" class="form-label">Order Status</label>
                            <input type="text" class="form-control" id="orderStatus" name="order_status" placeholder="Enter Order Status " required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="saveOrderStatus"><i class="bx bx-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Order Status  Modal -->
    <div class="modal fade" id="editOrderStatusModal" tabindex="-1" aria-labelledby="editLevelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLevelModalLabel">Edit Order Status </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editOrderStatusForm">
                        <input type="hidden" id="editOrderStatId" name="id">
                        <div class="mb-3">
                            <label for="editOrderStatus" class="form-label">Order Status </label>
                            <input type="text" class="form-control" id="editOrderStatus" name="order_status" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveEditedOrderStatus"><i class="bx bx-save"></i> Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#saveOrderStatus").click(function() {
            $('#orderStatModal').modal('hide');

            $.ajax({
                type: "POST",
                url: "/order_status/store",
                data: $("#addOrderStatusForm").serialize(),
                success: function(response) {
                    alert("Order Status Added Successfully!");
                    location.reload();
                },
                error: function() {
                    alert("Error adding Order Status.");
                }
            });
        });

        $(document).on('click', '.edit-order-status', function() {
            var id = $(this).data('id');
            var orderStatus = $(this).data('order-status');

            $('#editOrderStatId').val(id);
            $('#editOrderStatus').val(orderStatus);

            $('#editOrderStatusModal').modal('show');
        });

        $('#editOrderStatusForm').submit(function(e) {
        e.preventDefault(); // Prevent default form submission
        $('#editOrderStatusModal').modal('hide');
        var formData = $(this).serialize(); // Serialize form data
        var order_stat_id = $('#editOrderStatId').val(); // Get category ID

        $.ajax({
            type: "POST",
            url: "/order_status/update/" + order_stat_id, // Append ID to URL
            data: formData,
            dataType: "json",
            success: function(response) {
                var message = $('<div class="alert alert-success">Order Status Updated Successfully!</div>');

                $('#message-container').html('').append(message);

                setTimeout(function () {
                    message.fadeOut();
                    location.reload();
                }, 2000);
            },
            error: function() {
                var message = $('<div class="alert alert-danger">Error updating Order Status.</div>');

                $('#message-container').html('').append(message);

                setTimeout(function () {
                    message.fadeOut();
                }, 2000);
            }
        });
    });
    

        $(document).on('click', '.delete-order-status', function() {
            if (confirm("Are you sure you want to delete this Order Status?")) {
                var id = $(this).data('id');
                $.ajax({
                    type: "GET",
                    url: "/order_status/delete/" + id,
                    success: function(response) {
                        alert("Order Status  Deleted Successfully!");
                        location.reload();
                    },
                    error: function(xhr) {
                        alert("Error deleting Order Status.");
                    }
                });
            }
        });
    });
</script>
