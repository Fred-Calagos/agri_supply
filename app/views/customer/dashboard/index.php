<div class="container mt-4">
    <div class="row g-3">
        <?php foreach($categories as $category): ?>
            <!-- First Card -->
            <div class="col-md-3">
                <div class="card shadow-sm text-white" style="
                    background: url('/uploads/logo.png') center/cover no-repeat;
                    height: 180px; /* Adjust as needed */
                    position: relative;
                    overflow: hidden;">
                    <div class="card-body d-flex align-items-center justify-content-center" style="background: rgba(0, 0, 0, 0.4); height: 100%;">
                        <h5 class="card-title text-center"><?= htmlspecialchars($category['product_category']) ?></h5>
                        <a href="/customer/category?category=<?= htmlspecialchars($category['id']) ?>" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>
<!-- Search Box -->
<div class="p-3 border rounded bg-white mt-4">
<!-- Header Section with Search Bar -->
<div class="row g-3 border-bottom bottom-primary mb-3">
    <div class="col-md-6 mb-2">
            <!-- Title on the Left -->
            <h4 class="mb-0">Agri-Supply Products</h4>
        </div>
        <div class="col-md-6">
        <!-- Search Bar with Icon -->
        <div class="mb-2 position-relative" style="right:0; width: 100%;">
            <!-- Search Icon -->
            <i class='bx bx-search-alt-2 position-absolute' style="left: 20px; top: 50%; transform: translateY(-50%); font-size: 1.2rem; color: gray;"></i>
            <!-- Search Input -->
            <input type="text" id="searchInput" class="form-control ps-5" placeholder="Search for products...">


            <!-- Search Results (With High Z-Index) -->
            <div id="searchResults" class="position-absolute d-flex flex-column"></div>
        </div>
</div>

    

</div>


<!-- Product Cards -->
<div class="row g-3">
    <?php foreach ($products as $product): ?> 
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card product-card h-100 shadow-sm add-to-cart-card" 
                data-id="<?= htmlspecialchars($product['id']) ?>" 
                onclick="window.location.href='/customer/product_detail?id=<?= htmlspecialchars($product['id']) ?>'">
                
                <img src="<?= htmlspecialchars($product['image_path']) ?>" class="card-img-top product-img" alt="Product Image">
                <div class="card-body text-center border border-top">
                    <h5 class="card-title"><?= htmlspecialchars($product['product_name']) ?></h5>
                    <p class="card-text text-success fw-bold">₱ <?= number_format($product['selling_price'], 2) ?> per kilo</p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</div>

<script>
$(document).ready(function () {
    $("#searchInput").on("keyup", function () {
        let query = $(this).val().trim();

        if (query.length > 0) {
            $.ajax({
                type: "POST",
                url: "/customer/search", // Fixed endpoint
                data: { query: query },
                success: function (response) {
                    try {
                        let result = JSON.parse(response);
                        if (result.status === "success") {
                            let resultHTML = '<ul class="list-group mb-3">';
                            result.products.forEach(product => {
                                resultHTML += `<li class="list-group-item">
                                    <a href="/customer/product_detail?id=${product.id}" class="text-decoration-none">
                                        ${product.product_name} - ${product.product_category}
                                    </a>
                                </li>`;
                            });
                            resultHTML += '</ul>';
                            $("#searchResults").html(resultHTML);
                        } else {
                            $("#searchResults").html('<p class="text-danger">No products found</p>');
                        }
                    } catch (error) {
                        console.error("Error parsing JSON:", error);
                        $("#searchResults").html('<p class="text-danger">Error loading search results</p>');
                    }
                },
                error: function () {
                    $("#searchResults").html('<p class="text-danger">Server error. Try again later.</p>');
                }
            });
        } else {
            $("#searchResults").html("");
        }
    });

    $(".add-to-cart-card").click(function () {
        const productId = $(this).data("id");
        window.location.href = `/customer/product_detail?id=${productId}`;
    });
});


</script>
