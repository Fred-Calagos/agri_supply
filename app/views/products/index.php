<div class="container">
    <div class="d-flex align-items-center justify-content-end mb-3">

        <div>
        <a href="/products/create" class="btn btn-primary btn-sm">+ Add Product</a>
        </div>
    </div>
    <!-- Search and Filters -->
<div class="container mt-4 bg-white p-3 mb-3 rounded">
    <h6>Search and Filter Products</h6>
  <form method="GET" action="/products/filter" class="row g-2">
    
    <!-- Search Input -->
    <div class="col-md-4">
      <input type="text" name="search" class="form-control" placeholder="Search product, variety, or category..." id="searchInput" autocomplete="off">
      <div id="searchResults" class="list-group"></div>
    </div>

    <!-- Category Filter -->
    <div class="col-md-3">
      <select name="category_id" class="form-select">
        <option value="">All Categories</option>
        <?php foreach($categories as $category): ?>
          <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Variety Filter -->
    <div class="col-md-3">
      <select name="variety" class="form-select">
        <option value="">All Varieties</option>
        <?php foreach($varieties as $variety): ?>
          <option value="<?= $variety ?>"><?= $variety ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Submit Button -->
    <div class="col-md-2">
      <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>

  </form>
</div>

    <div id="message-container"></div>
    <div class="container-fluid mt-4 bg-white rounded p-3">
    <div class="table-responsive table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl table-responsive-xxl">

            <table class="table table-hover text-center">
                <thead class="table-light p-3 ">
                    <tr>
                        <th>No.</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Selling Price</th>
                        <th>Stocks</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php foreach ($products as $index => $product): ?>
                        <tr class="text-center">
                            <td><?= $index + 1 ?></td>
                            <td>
                                <img src="<?= htmlspecialchars($product['image_path']) ?>"
                                    alt="Product Image"
                                    class="img-thumbnail product-img-tbl">
                            </td>
                            <td class="text-start"><?= htmlspecialchars($product['product_name']) ?></td>
                            <td>₱<?= number_format($product['selling_price'], 2) ?></td>
                            <td><?= htmlspecialchars($product['stocks']) ?></td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="/products/edit/<?= $product['id'] ?>" class="btn btn-warning btn-sm">
                                        <i class="bx bxs-edit"></i>
                                    </a>
                                    <button class="delete-product btn btn-danger btn-sm" data-id="<?= $product['id'] ?>">
                                        <i class="bx bxs-trash"></i>
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

<script>
    $(document).ready(function() {
        $(document).on('click', '.edit-product', function() {
            $('#editProductId').val($(this).data('id'));
            $('#editProductName').val($(this).data('name'));
            $('#editProductModal').modal('show');
        });

        $('#saveEditedProduct').click(function (event) {
            event.preventDefault();
            
            var productId = $('#editProductId').val();
            
            $.ajax({
                type: "POST",
                url: "/products/update/" + productId, 
                data: $("#editProductForm").serialize(),
                dataType: "json",
                success: function () {
                    alert("Product Updated Successfully!");
                    location.reload();
                },
                error: function () {
                    alert("Error updating product.");
                }
            });
        });

        $(document).on('click', '.delete-product', function() {
            if (confirm("Are you sure you want to delete this product?")) {
                $.ajax({
                    type: "GET",
                    url: "/products/delete/" + $(this).data('id'),
                    success: function() {
                        alert("Product Deleted Successfully!");
                        location.reload();
                    },
                    error: function() {
                        alert("Error deleting product.");
                    }
                });
            }
        });
    });

    


</script>
