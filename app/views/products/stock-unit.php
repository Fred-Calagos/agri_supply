<div class="container">
    <!-- Navigation and Button Container -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/settings"><i class='bx bx-cog bread-icon'></i> Settings</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Stock Unit</li>
            </ol>
        </nav>

        <!-- Add Stock Unit Button -->
        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#stockUnitModal">
            <i class="bx bx-plus-circle"></i> Add Stock Unit
        </button>
    </div>

    <!-- Message Container -->
    <div id="message-container"></div>
    <div class="container-fluid container-sm">
        <div class="p-3 border rounded bg-white mt-4">
            <div class="table-responsive">
            <table class="table">
        <thead class="table-light">
            <tr>
                <th>No.</th>
                <th>Stock Unit</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($stock_units as $index => $stock_unit): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= $stock_unit['name'] ?></td>
                    <td>    
                        <button class="edit-stock-unit btn btn-warning btn-sm" 
                                data-id="<?= $stock_unit['id'] ?>" 
                                data-stock-unit-name="<?= $stock_unit['name'] ?>"
                                data-stock-category="<?= $stock_unit['category'] ?>"
                                data-stock-description="<?= $stock_unit['description'] ?>">
                            <i class="bx bxs-edit"></i> Edit
                        </button>
                        <button class="delete-stock-unit btn btn-danger btn-sm" 
                                data-id="<?= $stock_unit['id'] ?>">
                            <i class="bx bxs-trash"></i> Delete
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

            </div>
        </div>
    </div>
    <!-- Stock Unit Table -->

<!-- Add Stock Unit Modal -->
<div class="modal fade" id="stockUnitModal" tabindex="-1" aria-labelledby="stockUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="stockUnitModalLabel">Add Stock Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="addStockUnitForm">
                    <div class="mb-3">
                        <label for="stockUnitName" class="form-label">Stock Unit Name</label>
                        <input type="text" class="form-control" id="stockUnitName" name="stock_unit_name" placeholder="Enter Stock Unit Name" required>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Stock Unit Name</label>
                        <select name="category" class="form-control" id="category">
                            <option value="" selected disabled hidden>Select category</option>
                            <option value="Unit">Unit</option>
                            <option value="Packaging">Packaging</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="2" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success btn-sm" id="saveStockUnit"><i class="bx bx-save"></i> Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Stock Unit Modal -->
<div class="modal fade" id="editStockUnitModal" tabindex="-1" aria-labelledby="editStockUnitModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStockUnitModalLabel">Edit Stock Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editStockUnitForm">
                    <input type="hidden" id="editStockUnitId" name="id">
                    <div class="mb-3">
                        <label for="editStockUnitName" class="form-label">Stock Unit Name</label>
                        <input type="text" class="form-control" id="editStockUnitName" name="stock_unit_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editcategory" class="form-label">Stock Unit Name</label>
                        <select name="category" class="form-control" id="editcategory">
                            <option value="" selected disabled hidden>Select category</option>
                            <option value="Unit">Unit</option>
                            <option value="Packaging">Packaging</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="editdescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editdescription" name="description" rows="2" required></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-sm" id="saveEditedStockUnit"><i class="bx bx-save"></i> Save Changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Stock Unit Modal -->
<div class="modal fade" id="deleteStockUnitModal" tabindex="-1" aria-labelledby="deleteStockUnitLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteStockUnitLabel">Delete Stock Unit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this stock unit?</p>
                <p id="stockUnitInfo"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteStockUnit">Delete</button>
            </div>
        </div>
    </div>
</div>

</div>

<script>
$(document).ready(function () {
    function showMessage(message, type = 'success') {
        $('#message-container').html(`<div class="alert alert-${type}">${message}</div>`);
        setTimeout(() => location.reload(), 2000);
    }

    $("#saveStockUnit").click(() => {
        $('#stockUnitModal').modal('hide');
        $.post("/stock_unit/store", $("#addStockUnitForm").serialize())
            .done(() => showMessage('Stock Unit Added Successfully!'))
            .fail(() => showMessage('Error adding Stock Unit.', 'danger'));
    });

    $(document).on('click', '.edit-stock-unit', function () {
        $('#editStockUnitId').val($(this).data('id'));
        $('#editStockUnitName').val($(this).data('stock-unit-name'));
        $('#editcategory').val($(this).data('stock-category'));
        $('#editdescription').val($(this).data('stock-description'));
        $('#editStockUnitModal').modal('show');
    });

// Handle button click
$("#saveEditedStockUnit").click(() => {
    submitEditedStockUnit();
});

// Handle Enter key press in the form
$("#editStockUnitForm").on("keydown", function(event) {
    if (event.key === "Enter" && !event.shiftKey) {
        event.preventDefault(); // Prevent default form submission or line break
        submitEditedStockUnit();
    }
});

// Function to handle form submission
function submitEditedStockUnit() {
    const id = $('#editStockUnitId').val();
    $('#editStockUnitModal').modal('hide'); // Hide the modal (if using modal)
    $.post(`/stock_units/update/${id}`, $("#editStockUnitForm").serialize())
        .done(() => showMessage('Stock Unit Updated Successfully!'))
        .fail(() => showMessage('Error updating Stock Unit.', 'danger'));
}


    $(document).on('click', '.delete-stock-unit', function () {
        $('#stockUnitInfo').text('Stock Unit: ' + $(this).closest('tr').find('td:nth-child(2)').text());
        $('#confirmDeleteStockUnit').data('id', $(this).data('id'));
        $('#deleteStockUnitModal').modal('show');
    });

    $('#confirmDeleteStockUnit').click(function () {
        $.get(`/stock_unit/delete/${$(this).data('id')}`)
            .done(() => showMessage('Stock Unit Deleted Successfully!'))
            .fail(() => showMessage('Error deleting Stock Unit.', 'danger'));
    });
});
</script>
