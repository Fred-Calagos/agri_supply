<div class="container">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/products"><i class='bx bx-category-alt'></i> Product</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Creating Specification</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container bg-white p-3 mt-3 mb-3 rounded shadow-sm">
<div id="add-specification-message" class="z-5"></div>

    <div class="d-flex align-items-center justify-content-between mb-3">
        <!-- Specification Form -->
        <form id="addSpecificationForm" class="w-100">

            <div class="row">
                <div class="col-md-8">
                    <input type="text" class="form-control" id="specificationName" name="name" placeholder="Enter Specification name"required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary btn-sm btn-md w-100">
                        <i class="bx bx-plus-circle"></i> Add Specification
                </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="message-container"></div>
    <div class="container-fluid mt-4 bg-white rounded p-3  shadow-sm">

        <div class="table-responsive table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl table-responsive-xxl">

            <table class="table table-hover" id="myTable">
                <thead class=" p-3" >
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php foreach ($specifications as $index => $specification): ?>
                        <tr>

                            <td><?= $index + 1 ?></td>
                            <td class="text-start"><?= htmlspecialchars($specification['name']) ?></td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <!-- Edit Specification Button -->
                                    <button class="edit-specification btn btn-warning btn-sm" 
                                        data-id="<?= $specification['id'] ?>"
                                        data-name="<?= $specification['name'] ?>">
                                        <i class="bx bxs-edit"></i> Edit
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>   
        </div>
    </div>
    </div>
<!-- Edit Specification Modal -->
<div class="modal fade" id="editSpecificationModal" tabindex="-1" aria-labelledby="editSpecificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSpecificationModalLabel">Edit Specification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editSpecificationForm">
                    <input type="hidden" id="editSpecificationId" name="id">
                    <div class="mb-3">
                        <label for="editSpecificationName" class="form-label">Specification Name</label>
                        <input type="text" class="form-control" id="editSpecificationName" name="name" required>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="saveEditedSpecification"><i class="bx bx-save"></i> Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>

$(document).ready(function() {
    handleAjaxForm({
        formId: '#addSpecificationForm',
        messageContainerId: '#add-specification-message',
        postUrl: '/products/add_specification',
        successMessage: 'Specification added successfully!',
        successTimeout: 2000,
        reloadOnSuccess: true
    });

    handleEditModalForm({
        triggerSelector: '.edit-specification',
        modalId: '#editSpecificationModal',
        formId: '#editSpecificationForm',
        saveButtonId: '#saveEditedSpecification',
        messageContainerId: '#message-container',
        postUrlBase: '/product/specification/update',
        successMessage: 'Specification updated successfully!',
        fieldMappings: [
            { fieldId: 'editSpecificationId', dataKey: 'id' },
            { fieldId: 'editSpecificationName', dataKey: 'name' }
        ]
    });
});


</script>