<div class="container">
    <!-- Navigation and Button Container -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/settings"><i class='bx bx-cog bread-icon'></i> Settings</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page"> Payment Methods</li>
            </ol>
        </nav>

        <!-- Add Payment Method Button -->
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#paymentMethodModal">
            <i class="bx bx-plus-circle"></i> Add Payment Method
        </button>
    </div>

    <!-- Message Container -->
    <div id="message-container"></div>

    <div class="container-fluid mt-4 bg-white rounded p-3  shadow-sm">

        <div class="table-responsive table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl table-responsive-xxl">

            <table class="table table-hover" id="myTable">
                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Payment Method</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($paymentMethods as $index => $paymentMethod): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $paymentMethod['payment_method'] ?></td>
                            <td>    
                                <button class="edit-payment-method btn btn-warning btn-sm" 
                                        data-id="<?= $paymentMethod['id'] ?>" 
                                        data-payment-method="<?= $paymentMethod['payment_method'] ?>">
                                    <i class="bx bxs-edit"></i> Edit
                                </button>
                                <button class="delete-payment-method btn btn-danger btn-sm" 
                                        data-id="<?= $paymentMethod['id'] ?>">
                                    <i class="bx bxs-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>

    <!-- Modal for Adding Payment Method -->
    <div class="modal fade" id="paymentMethodModal" tabindex="-1" aria-labelledby="paymentMethodModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentMethodModalLabel">Add Payment Method</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addPaymentMethodForm">
                        <div class="mb-3">
                            <label for="paymentMethod" class="form-label">Payment Method</label>
                            <input type="text" class="form-control" id="paymentMethod" name="payment_method" placeholder="Enter Payment Method" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success btn-sm" id="savePaymentMethod"><i class="bx bx-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Payment Method Modal -->
    <div class="modal fade" id="editPaymentMethodModal" tabindex="-1" aria-labelledby="editPaymentMethodModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPaymentMethodModalLabel">Edit Payment Method</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPaymentMethodForm">
                        <input type="hidden" id="editPaymentMethodId" name="id">
                        <div class="mb-3">
                            <label for="editPaymentMethod" class="form-label">Payment Method</label>
                            <input type="text" class="form-control" id="editPaymentMethod" name="payment_method" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="saveEditedPaymentMethod"><i class="bx bx-save"></i> Save Changes</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Function to save Payment Method
        function savePaymentMethod() {
            $('#paymentMethodModal').modal('hide');

            $.ajax({
            type: "POST",
            url: "/payment/store",
            data: $("#addPaymentMethodForm").serialize(),
            success: function (response) {
                var message = $('<div class="alert alert-success">Payment Method Added Successfully!</div>');
                $('#message-container').html('').append(message);

                setTimeout(function () {
                message.fadeOut();
                location.reload();
                }, 1000);
            },
            error: function () {
                var message = $('<div class="alert alert-danger">Error adding Payment Method.</div>');
                $('#message-container').html('').append(message);

                setTimeout(function () {
                message.fadeOut();
                }, 2000);
            }
            });
        }

        // Click event for Save button
        $("#savePaymentMethod").click(function () {
            savePaymentMethod();
        });

        // Enter key event in input field
        $("#paymentMethod").keypress(function (event) {
            if (event.which === 13) { // Check if Enter key is pressed
            event.preventDefault();
            savePaymentMethod();
            }
        });

        // Open Edit Modal and Pass Data
        $(document).on('click', '.edit-payment-method', function () {
            $('#editPaymentMethodId').val($(this).data('id'));
            $('#editPaymentMethod').val($(this).data('payment-method'));
            $('#editPaymentMethodModal').modal('show');
        });

        // Save Edited Payment Method
        $("#saveEditedPaymentMethod").click(function () {
            var id = $('#editPaymentMethodId').val();
            $.ajax({
                type: "POST",
                url: "/payment/update/" + id,
                data: $("#editPaymentMethodForm").serialize(),
                success: function () {
                    location.reload();
                }
            });
        });

        // Open Delete Modal and Confirm Deletion
        $(document).on('click', '.delete-payment-method', function () {
            var id = $(this).data('id');
            if (confirm("Are you sure you want to delete this payment method?")) {
                $.ajax({
                    type: "GET",
                    url: "/payment/delete/" + id,
                    success: function () {
                        location.reload();
                    }
                });
            }
        });
    });
</script>
