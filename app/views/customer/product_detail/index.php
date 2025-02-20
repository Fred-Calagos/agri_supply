<div class="container-sm mt-3">
    <!-- Breadcrumb Navigation -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/customer/dashboard"><i class='bx bx-store-alt bread-icon'></i> Dashboard</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Product</li>
            </ol>
        </nav>
        <a href="/cart" class="cart-container">
            <i class='bx bx-cart-alt'></i>
            <span class="cart-badge" id="cartCount">33</span>
        </a>

    </div>
</div>
<div class="message-container"></div> <!-- This is where the success message appears -->

        <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start bg-white p-4 rounded shadow-sm">

            <!-- Product Image (Left) -->
            <div class="me-md-4 mb-3 mb-md-0">

                <img src="<?= htmlspecialchars($product['image_path']) ?>" class="img-fluid rounded" 
                    alt="Product Image" style="max-width: 250px; height: 200px;">
            </div>

            <!-- Product Information (Right) -->
            <div class="flex-grow-1">
                <h3 class="mb-1"><?= htmlspecialchars($product['product_name']) ?></h3>
                <p class="text-muted mb-1">Category: <?= htmlspecialchars($product['product_category']) ?></p>
                <h5 class="text-success fw-bold">₱ <?= number_format($product['selling_price'], 2) ?> per kilo</h5>
                <p class="small"><?= nl2br(htmlspecialchars($product['product_description'])) ?></p>
            
                <form id="addToCartForm">
                <input type="hidden" id="productId" name="product_id" value="<?= $product['id'] ?>">
                <input type="hidden" id="userId" name="user_id" value="<?= $user['id'] ?>">
                            <!-- Quantity Selector -->
                <div class="mb-3">
                    <label for="productQuantity" class="form-label small">Quantity (kg)</label>
                    <div class="input-group">
                        <button class="btn btn-outline-secondary btn-sm" type="button" id="decreaseQty">-</button>
                        <input type="number" id="productQuantity" class="form-control text-center" name="quantity"
                            value="1" min="1" style="max-width: 70px;">
                        <button class="btn btn-outline-secondary btn-sm" type="button" id="increaseQty">+</button>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class='bx bx-cart-add'></i> Add to Cart
                    </button>

                    <button class="btn btn-outline-danger btn-sm">
                        <i class='bx bx-heart'></i> Wishlist
                    </button>
                </div>
            </form>

            </div>
        </div> 
     </form>
   

<script>
$(document).ready(function () {
    $("#addToCartForm").submit(function (e) {
        e.preventDefault(); // Prevent normal form submission
        var productId = $('#productId').val(); // Get grade_id
        let formData = $(this).serialize(); // Serialize form data

        $.ajax({
            type: "POST",
            url: "/customer/cart/store",
            data: formData,
            dataType: "json", // Expect JSON response
            success: function (response) {
                $(".message-container").html(
                    `<div class="alert alert-${response.status === "success" ? "success" : "danger"}">
                        ${response.message}
                    </div>`
                );

                // Hide the message after 3 seconds
                if (response.status === "success") {
                    setTimeout(() => {
                        $(".message-container").fadeOut();
                        window.location.href = "/customer/product_detail?id=" + productId;
                    }, 2000);
                }
            },
            error: function () {
                $(".message-container").html(
                    `<div class="alert alert-danger">An error occurred. Please try again.</div>`
                );
            }
        });
    });
});


    
    document.addEventListener("DOMContentLoaded", function () {
        let decreaseBtn = document.getElementById("decreaseQty");
        let increaseBtn = document.getElementById("increaseQty");
        let quantityInput = document.getElementById("productQuantity");

        decreaseBtn.addEventListener("click", function () {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });

        increaseBtn.addEventListener("click", function () {
            quantityInput.value = parseInt(quantityInput.value) + 1;
        });
    });
</script>

