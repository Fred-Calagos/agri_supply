<div class="container">
    <!-- Navigation and Button Container -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/settings"><i class='bx bx-cog bread-icon'></i> Settings</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Variety</li>
            </ol>
        </nav>

        <!-- Add Variety Button -->
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#varietyModal">
            <i class="bx bx-plus-circle"></i> Add Variety
        </button>
    </div>

    <!-- Message Container -->
    <div id="message-container"></div>

    <!-- Variety Table -->
    <table class="table table-striped">
        <thead class="table-dark">
            <tr>
                <th>No.</th>
                <th>Variety</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($varieties as $index => $variety): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $variety['variety_name'] ?></td>
                    <td>    
                        <button class="edit-variety btn btn-warning btn-sm" 
                                data-id="<?= $variety['id'] ?>" 
                                data-variety-name="<?= $variety['variety_name'] ?>">
                            <i class="bx bxs-edit"></i> Edit
                        </button>
                        <button class="delete-variety btn btn-danger btn-sm" 
                                data-id="<?= $variety['id'] ?>">
                            <i class="bx bxs-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<!-- Modal for Adding Variety -->
<div class="modal fade" id="varietyModal" tabindex="-1" aria-labelledby="varietyModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="varietyModalLabel">Add Variety</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addVarietyForm">
                    <!-- Product Auto-Suggest -->
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product</label>
                        <input type="text" class="form-control" id="productName" name="product_name" placeholder="Search Product..." autocomplete="off" required>
                        <input type="text" id="productId" name="product_id">
                        <div id="productList" class="list-group position-absolute w-100" style="z-index:1000;"></div>
                    </div>
                    <!-- Variety Name -->
                    <div class="mb-3">
                        <label for="varietyName" class="form-label">Variety Name</label>
                        <input type="text" class="form-control" id="varietyName" name="variety_name" placeholder="Enter Variety Name" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success btn-sm" id="saveVariety"><i class="bx bx-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>


    <!-- Edit Variety Modal -->
    <div class="modal fade" id="editVarietyModal" tabindex="-1" aria-labelledby="editVarietyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editVarietyModalLabel">Edit Variety</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editVarietyForm">
                        <input type="hidden" id="editVarietyId" name="id">
                        <div class="mb-3">
                            <label for="editVarietyName" class="form-label">Variety Name</label>
                            <input type="text" class="form-control" id="editVarietyName" name="variety_name" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm" id="saveEditedVariety"><i class="bx bx-save"></i> Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Variety Modal -->
    <div class="modal fade" id="deleteVarietyModal" tabindex="-1" aria-labelledby="deleteVarietyLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteVarietyLabel">Delete Variety</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this variety?</p>
                    <p id="varietyInfo"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteVariety">Delete</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
$(document).ready(function() {
    $('#productName').keyup(function() {
        let query = $(this).val();
        if (query.length > 0) {
            $.ajax({
                url: '/product_suggest', // Change this to your route/controller
                method: 'POST',
                data: { query: query },
                success: function(data) {
                    $('#productList').fadeIn();
                    $('#productList').html(data);
                }
            });
        } else {
            $('#productList').fadeOut();
        }
    });

    $(document).on('click', '.product-item', function() {
        $('#productName').val($(this).text());
        $('#productId').val($(this).data('id'));
        $('#productList').fadeOut();
    });

    $(document).click(function(event) {
        if (!$(event.target).closest('#productName, #productList').length) {
            $('#productList').fadeOut();
        }
    });
});
$(document).ready(function () {
    function showMessage(message, type = 'success') {
        $('#message-container').html(`<div class="alert alert-${type}">${message}</div>`);
        setTimeout(() => location.reload(), 2000);
    }

    $("#saveVariety").click(() => {
        $('#varietyModal').modal('hide');
        $.post("/variety/store", $("#addVarietyForm").serialize())
            .done(() => showMessage('Variety Added Successfully!'))
            .fail(() => showMessage('Error adding Variety.', 'danger'));
    });

    $(document).on('click', '.edit-variety', function () {
        $('#editVarietyId').val($(this).data('id'));
        $('#editVarietyName').val($(this).data('variety-name'));
        $('#editVarietyModal').modal('show');
    });

    $("#saveEditedVariety").click(() => {
        const id = $('#editVarietyId').val();
        $.post(`/variety/update/${id}`, $("#editVarietyForm").serialize())
            .done(() => showMessage('Variety Updated Successfully!'))
            .fail(() => showMessage('Error updating Variety.', 'danger'));
    });

    $(document).on('click', '.delete-variety', function () {
        $('#varietyInfo').text('Variety: ' + $(this).closest('tr').find('td:nth-child(2)').text());
        $('#confirmDeleteVariety').data('id', $(this).data('id'));
        $('#deleteVarietyModal').modal('show');
    });

    $('#confirmDeleteVariety').click(function () {
        $.get(`/variety/delete/${$(this).data('id')}`)
            .done(() => showMessage('Variety Deleted Successfully!'))
            .fail(() => showMessage('Error deleting Variety.', 'danger'));
    });
});
</script>
