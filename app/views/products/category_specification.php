<div class="container">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/product_category"><i class='bx bx-category-alt'></i> Product Category</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Creating Specification</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container bg-white p-3 mt-3 mb-3 rounded shadow-sm">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <!-- Specification Form -->
        <form action="/products/category/add_specification" method="POST" class="w-100">
            <div class="row">
            <input type="hidden" name="category_id" value="<?= htmlspecialchars($categoryId) ?>">
                <div class="col-md-8 mb-3 position-relative">
                    <label for="categoryName" class="form-label mb-2">
                        <strong>Product Category: <?= htmlspecialchars($categoryName) ?></strong>
                    </label>
                    <input type="hidden" class="form-control" name="specification_id" id="specificationId">

                    <input type="text" class="form-control" id="specificationName" placeholder="Enter Specification name" autocomplete="off" required>
                    <div id="specificationList" class="list-group position-absolute w-100" style="z-index:1000;"></div>
                </div>

                <div class="col-md-4 d-flex align-items-center justify-content-end">
                    <button type="submit" class="btn btn-primary btn-sm btn-md w-100 mt-2">
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
                        <th>Specification</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php foreach ($categorySpecification as $index => $specification): ?>
                        <tr>

                            <td><?= $index + 1 ?></td>
                            <td class="text-start"><?= htmlspecialchars($specification['name']) ?></td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <!-- Edit Specification Button -->
                                    <button class="edit-specification btn btn-warning btn-sm" 
                                        data-id="<?= $specification['id'] ?>"
                                        data-category-id="<?= $specification['category_id'] ?>"
                                        data-specification-name="<?= $specification['name'] ?>"
                                        data-specification-id="<?= $specification['specification_id'] ?>">
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
                    <input type="hidden" id="categoryId" name="category_id">
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
    $('#myTable').DataTable();
});

$(document).ready(function() {
    $('#specificationName').keyup(function() {
        let query = $(this).val();
        if (query.length > 0) {
            $.ajax({
                url: '/specification_suggest', // Route for fetching specification names
                method: 'POST',
                data: { query: query },
                success: function(data) {
                    $('#specificationList').fadeIn();
                    $('#specificationList').html(data);
                }
            });
        } else {
            $('#specificationList').fadeOut();
        }
    });

    $(document).on('click', '.specification-item', function() {
        let selectedName = $(this).text();
        let selectedId = $(this).data('id');

        $('#specificationName').val(selectedName);
        $('#specificationId').val(selectedId); // Set the hidden input value
        $('#specificationList').fadeOut();
    });


    $(document).click(function(event) {
        if (!$(event.target).closest('#specificationName, #specificationList').length) {
            $('#specificationList').fadeOut();
        }
    });
});

// Open the Edit Specification Modal and populate fields
$(document).on('click', '.edit-specification', function() {
    $('#editSpecificationId').val($(this).data('id'));
    $('#categoryId').val($(this).data('category-id'));
    $('#editSpecificationName').val($(this).data('name'));
    $('#editSpecificationModal').modal('show');
});

// Save Edited Specification
$('#saveEditedSpecification').click(function(event) {
    event.preventDefault();
    $('#editSpecificationModal').modal('hide');
    var specificationId = $('#editSpecificationId').val();
    var cateogryId = $('#categoryId').val();

    $.ajax({
        type: "POST",
        url: "/product/specification/update?categoryId=" + cateogryId, // Update endpoint for specification
        data: $("#editSpecificationForm").serialize(),
        dataType: "json",
        success: function(response) {
            var message = $('<div class="alert alert-success">Specification updated successfully!</div>');
            $('#message-container').html('').append(message);

            $('#editSpecificationModal').modal('hide');

            setTimeout(function() {
                message.fadeOut();
                location.reload();
            }, 2000);
        },
        error: function() {
            var message = $('<div class="alert alert-danger">Error updating specification.</div>');
            $('#message-container').html('').append(message);

            setTimeout(function() {
                message.fadeOut();
            }, 2000);
        }
    });
});

</script>