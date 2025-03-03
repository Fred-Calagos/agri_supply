
    <div class="container-fluid mt-4 bg-dark-50">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/products"><i class='bx bx-store-alt bread-icon'></i> Products</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Create Product</li>
            </ol>
        </nav>
    </div>
    
    <form id="addProductForm" action="/products/store" method="POST" enctype="multipart/form-data">

            <div class="row mb-1">
                <!-- Left Column: Product Details -->
                <div class="p-3 border rounded bg-white">
                    <div class="row p-3">
                        <!-- Left Column: Image Upload & Preview -->
                        <div class="col-md-3 text-center">
                            <div class="section-title mb-1">Product Image</div>
                            <img src="" 
                                    class="img-fluid img-thumbnail mb-1" 
                                    id="productImagePreview" 
                                    alt="Product Image"
                                    style="width: 400px; height: 200px; object-fit: contain; ">

                            <input type="file" class="form-control" id="productImage" name="image" accept="image/*" onchange="previewImage(event)">
                        </div>

                        <!-- Right Column: Product Details -->
                        <div class="col-md-9">
                            <div class="section-title mb-2">Product Details</div>

                            <div class="row mt-2">
                                <!-- Product Name -->
                                <div class="col-md-3 mb-3">
                                    <label for="productName" class="form-label">Product Name</label>
                                    <input type="text" class="form-control" id="productName" name="product_name" required>
                                </div>
                                <div class="col-md-3 mb-3 position-relative">
                                    <label for="variety" class="form-label">Variety</label>
                                    <input type="text" class="form-control" id="variety" name="variety" placeholder="Search Variety..." autocomplete="off" required>
                                    <div id="varietyList" class="list-group position-absolute w-100" style="z-index:1000;"></div>
                                </div>


                                <!-- Product Category -->
                                <div class="col-md-3 mb-3">
                                    <label for="productCategory" class="form-label">Category</label>
                                    <select class="form-control" id="productCategory" name="product_category_id" required>
                                        <option value="" selected hidden disabled>Select a Category</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?= $category['id'] ?>"><?= $category['product_category'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="col-md-3 mb-3">
                                    <label for="productStatus" class="form-label">Product Status</label>
                                    <select class="form-control" id="productStatus" name="product_status_id" required>
                                        <?php foreach ($productStatus as $prodStat): ?>
                                            <option value="<?= $prodStat['id'] ?>"><?= $prodStat['product_status'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="mb-3">
                                <label for="productDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="productDescription" name="product_description" rows="3" required></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row p-3">
                        <div class="section-title">Pricing & Shipping</div>

                        <div class="col-md-3">
                            <label for="costPrice" class="form-label">Cost Price (₱)</label>
                            <input type="number" class="form-control" id="costPrice" name="cost_price" min="0" step="0.01" required>
                        </div>

                        <div class="col-md-3">
                            <label for="profitMargin" class="form-label">Profit Margin (%)</label>
                            <input type="number" class="form-control" id="profitMargin" name="profit_margin" min="0" max="100" step="0.01">
                        </div>

                        <div class="col-md-3">
                            <label for="productPrice" class="form-label">Selling Price (₱)</label>
                            <input type="number" class="form-control" id="productPrice" name="selling_price" min="0" step="0.01" readonly>
                        </div>

                        <div class="col-md-3">
                            <label for="shippingFee" class="form-label">Shipping Fee (₱)</label>
                            <input type="number" class="form-control" id="shippingFee" name="shipping_fee" min="0" step="0.01">
                        </div>
                    </div>
                    <div class="row p-3 mb-3">
                        <div class="col-md-3">
                            <label for="stocks" class="form-label">Stocks</label>
                            <input type="number" class="form-control" id="stocks" name="stocks" min="0" step="0.01">
                        </div>
                        <div class="col-md-3">
                            <label for="stock_unit" class="form-label">Stock Units</label>
                            <input type="text" class="form-control" id="stock_unit" name="stock_unit">
                        </div>
                    </div>
                        <div class="d-flex justify-content-between md-3 mb-3 p-3">
                            <button type="reset" class="btn btn-secondary btn-lg  btn-sm ">Reset</button>
                            <button type="submit" class="btn btn-success btn-lg btn-sm"><i class="bx bx-save"></i> Save Product</button>
                        </div>
                </div>
            </div>
            
        </form>
    </div>
    <script>
        $(document).ready(function() {
    $('#variety').keyup(function() {
        let query = $(this).val();
        if (query.length > 1) {
            $.ajax({
                url: '/variety_suggest', // Route for fetching varieties
                method: 'POST',
                data: { query: query },
                success: function(data) {
                    $('#varietyList').fadeIn();
                    $('#varietyList').html(data);
                }
            });
        } else {
            $('#varietyList').fadeOut();
        }
    });

    $(document).on('click', '.variety-item', function() {
        $('#variety').val($(this).text());
        $('#varietyList').fadeOut();
    });

    $(document).click(function(event) {
        if (!$(event.target).closest('#variety, #varietyList').length) {
            $('#varietyList').fadeOut();
        }
    });
});

        // Auto-calculate product price based on cost price & profit margin
        document.getElementById('profitMargin').addEventListener('keyup', function () {
            const costPrice = parseFloat(document.getElementById('costPrice').value) || 0;
            const profitMargin = parseFloat(this.value) || 0;
            const sellingPrice = costPrice + (costPrice * (profitMargin / 100));
            document.getElementById('productPrice').value = sellingPrice.toFixed(2);
        });


        function previewImage(event) {
            const imagePreview = document.getElementById('productImagePreview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.src = "https://via.placeholder.com/150"; // Reset to default if no file selected
            }
        }
    </script>

