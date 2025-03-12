<div class="container">
    <div class="d-flex align-items-center justify-content-end mb-3">

        <div>
        <a href="/products/create" class="btn btn-primary btn-sm">+ Add Product</a>
        </div>
    </div>
    <!-- Search and Filters -->
<div class="container mt-4 bg-white p-3 mb-3 rounded shadow-sm">
    <h6>Search and Filter Products</h6>
  <form class="row g-2 align-items-center justify-content-center">
    
    <!-- Search Input -->
    <div class="col-md-4">
        <input type="text" name="search" id="searchInput" class="form-control" placeholder="Search for products...">
    </div>

    <!-- Category Filter -->
    <div class="col-md-3">
    <select name="category_id" id="categoryFilter" class="form-select">
        <option value="">All Categories</option>
        <?php foreach($categories as $category): ?>
          <option value="<?= $category['id'] ?>"><?= $category['product_category'] ?></option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Variety Filter -->
    <div class="col-md-3">
    <select name="variety" id="varietyFilter" class="form-select">
        <option value="">All Varieties</option>
        <?php foreach($varieties as $variety): ?>
          <option value="<?= $variety ?>"><?= $variety ?></option>
        <?php endforeach; ?>
      </select>
    </div>

  </form>
</div>

    <div id="message-container"></div>
    <div class="container-fluid mt-4 bg-white rounded p-3  shadow-sm">
        <div class="table-responsive table-responsive-sm table-responsive-md table-responsive-lg table-responsive-xl table-responsive-xxl">

            <table class="table table-hover" id="myTable">
                <thead class=" p-3" >
                    <tr>
                        <th>No.</th>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php foreach ($products as $index => $product): ?>
                        <tr class="product-row"
                                    data-category="<?= $product['product_category_id'] ?>"
                                    data-category-name="<?= $product['product_category'] ?>"
                                    data-variety="<?= htmlspecialchars($product['variety']) ?>"
                                    data-name="<?= htmlspecialchars(strtolower($product['product_name'])) ?>">

                            <td><?= $index + 1 ?></td>
                            <td>
                                <img src="<?= htmlspecialchars($product['image_path']) ?>"
                                    alt="Product Image"
                                    class="img-thumbnail product-img-tbl">
                            </td>
                            <td class="text-start"><?= htmlspecialchars($product['product_name']) ?></td>
                            <td class="text-start"><?= htmlspecialchars($product['product_category']) ?></td>
                            <td>
                                <div class="d-flex justify-content-start gap-2">
                                    <a href="/products/edit/<?= $product['id'] ?>" class="btn btn-warning btn-sm">
                                        <i class="bx bxs-edit"></i>
                                    </a>
                                    <a href="/products/batch/<?= $product['id'] ?>" class="btn btn-success btn-sm">
                                        <i class="bx bxs-plus-circle"></i> Batch
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
    $('#myTable').DataTable();
});
document.addEventListener("DOMContentLoaded", function () {
    const categoryFilter = document.getElementById('categoryFilter');
    const varietyFilter = document.getElementById('varietyFilter');
    const searchInput = document.getElementById('searchInput');
    const productRows = document.querySelectorAll('.product-row');

    function filterProducts() {
        const selectedCategory = categoryFilter.value;
        const selectedVariety = varietyFilter.value.toLowerCase();
        const searchText = searchInput.value.toLowerCase();

        productRows.forEach(row => {
            const rowCategory = row.getAttribute('data-category');
            const rowCategoryName = row.getAttribute('data-category-name').toLowerCase();
            const rowVariety = row.getAttribute('data-variety').toLowerCase();
            const rowName = row.getAttribute('data-name');

            const matchesCategory = !selectedCategory || rowCategory === selectedCategory;
            const matchesVariety = !selectedVariety || rowVariety === selectedVariety;
            const matchesSearch = !searchText || rowName.includes(searchText) || rowCategoryName.includes(searchText);

            if (matchesCategory && matchesVariety && matchesSearch) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    categoryFilter.addEventListener('change', filterProducts);
    varietyFilter.addEventListener('change', filterProducts);
    searchInput.addEventListener('input', filterProducts);
});

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
