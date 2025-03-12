<div class="container ">
<div class="d-flex align-items-center justify-content-between mb-3 bg-white p-3 rounded shadow-sm">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/products"><i class='bx bx-store-alt bread-icon'></i> Products</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Create Batches</li>
            </ol>
        </nav>
    </div>

<form action="/batch/store" method="POST" class="p-4 border rounded shadow-sm bg-white p-4 shadow-sm rounded">
    <div class="row">
        <!-- Product ID -->
        <div class="col-md-4 mb-3">
            <label for="product_id" class="form-label">Product Name</label>
            <input type="hidden" class="form-control" id="product_id" name="product_id" value="<?= $product['id'] ?>"  required>
            <input type="text" class="form-control text-muted" id="product_name" name="product_name" value="<?= $product['product_name'] ?>" readonly>
        </div>

        <!-- Batch Number -->
        <div class="col-md-4 mb-3">
            <label for="batch_number" class="form-label">Batch Number</label>
            <input type="number" class="form-control" id="batch_number" name="batch_number">
        </div>
        <div class="col-md-4 mb-3">
            <label for="productStatus" class="form-label">Status</label>
            <select class="form-control" id="productStatus" name="product_status_id" required>
                <?php foreach ($productStatus as $prodStatus): ?>
                    <option value="<?= $prodStatus['id'] ?>" required>
                        <?= $prodStatus['product_status'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Cost Price -->
        <div class="col-md-4 mb-3">
            <label for="cost_price" class="form-label">Cost Price</label>
            <input type="number" step="0.01" class="form-control" id="cost_price" name="cost_price">
        </div>

        <!-- Profit Margin -->
        <div class="col-md-4 mb-3">
            <label for="profit_margin" class="form-label">Profit Margin (%)</label>
            <input type="number" step="0.01" class="form-control" id="profit_margin" name="profit_margin">
        </div>

        <!-- Selling Price -->
        <div class="col-md-4 mb-3">
            <label for="selling_price" class="form-label">Selling Price</label>
            <input type="number" step="0.01" class="form-control" id="selling_price" name="selling_price">
        </div>


        <!-- Stocks -->
        <div class="col-md-4 mb-3">
            <label for="stocks" class="form-label">Stocks</label>
            <input type="number" class="form-control" id="stocks" name="stocks">
        </div>



        <!-- Stock Unit -->
        <div class="col-md-4 mb-3">
            <label for="stock_unit" class="form-label">Stock Unit</label>
            <input type="text" class="form-control" id="stock_unit" name="stock_unit">
            <div id="stockUnitList" class="list-group position-absolute" style="z-index:1000;"></div>
            
        </div>

        <!-- Best Before Date -->
        <div class="col-md-4 mb-3">
            <label for="best_before_date" class="form-label">Best Before Date</label>
            <input type="date" class="form-control" id="best_before_date" name="best_before_date">
        </div>


        <!-- Submit Button -->
        <div class="col-12 text-end mt-3">
            <button type="submit" class="btn btn-primary">Save Product Batch</button>
        </div>
    </div>
</form>
<div id="message-container"></div>
    <div class="container-fluid mt-4 bg-white rounded p-3  shadow">
        <div class="table-responsive table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl table-responsive-xxl">
        <table class="table table-hover" id="myTable">
                <thead class=" p-3" >
                    <tr>
                        <th>No.</th>
                        <th>Batch No.</th>
                        <th>Selling Price</th>
                        <th>Stocks</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($productBatches)): ?>
                    <?php foreach ($productBatches as $index => $batch): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= $batch['batch_number'] ?></td>
                            <td><?= $batch['selling_price'] ?></td>
                            <td><?= $batch['stocks'] ?></td>
                            <td><?= $batch['product_status'] ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-batch" 
                                        data-id="<?= $batch['id'] ?>"
                                        data-batch-number="<?= $batch['batch_number'] ?>"
                                        data-cost-price="<?= $batch['cost_price'] ?>"
                                        data-profit-margin="<?= $batch['profit_margin'] ?>"
                                        data-selling-price="<?= $batch['selling_price'] ?>"
                                        data-stocks="<?= $batch['stocks'] ?>"
                                        data-stock-unit="<?= $batch['stock_unit'] ?>"
                                        data-best-before-date="<?= $batch['best_before_date'] ?>"
                                        data-product-status="<?= $batch['stock_category'] ?>">
                                    <i class="bx bxs-edit"></i> Edit
                                </button>
                                <button class="btn btn-danger btn-sm delete-batch" data-id="<?= $batch['id'] ?>">
                                    <i class="bx bxs-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No product batches found!</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
        </div>
    </div>  


</div>

<script>
        // Auto-calculate product price based on cost price & profit margin
        document.getElementById('profit_margin').addEventListener('keyup', function () {
        const costPrice = parseFloat(document.getElementById('cost_price').value) || 0;
        const profitMargin = parseFloat(this.value) || 0;
        const sellingPrice = costPrice + (costPrice * (profitMargin / 100));
        document.getElementById('selling_price').value = sellingPrice.toFixed(2);
    });

    $(document).ready(function() {
    $('#stock_unit').on('keyup', function() {
        let query = $(this).val();
        if (query.length > 0) {
            $.ajax({
                url: "/stock_units/search", // Adjust this route to your PHP MVC controller
                method: "POST",
                data: { query: query },
                success: function(data) {
                    $('#stockUnitList').fadeIn().html(data);
                }
            });
        } else {
            $('#stockUnitList').fadeOut();
        }
    });

    $(document).on('click', '.stock-unit-item', function() {
        $('#stock_unit').val($(this).text());
        $('#stockUnitList').fadeOut();
    });

    $(document).click(function(e) {
        if (!$(e.target).closest('#stock_unit').length) {
            $('#stockUnitList').fadeOut();
        }
    });
});

$(document).ready(function () {
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