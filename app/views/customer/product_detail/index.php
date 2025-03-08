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
        <a href="/customer/cart" class="cart-container">
            <i class='bx bx-cart-alt'></i>
            <?php if (isset($cartCount) && $cartCount > 0): ?>
                <span class="cart-badge"><?= $cartCount ?></span>
            <?php else: ?>
                <span class="cart-badge">0</span>
            <?php endif; ?>

        </a>

    </div>
</div>
<div class="container-fluid container-sm ">
<div class="p-3 border rounded bg-white mt-4">
<div class="message-container"></div> <!-- This is where the success message appears -->
    <div class="row">
        <div class="col-3 col-sm-3 col-md-3">
            <!-- Product Image (Left) -->
            <div class="me-md-4 mb-3 mb-md-0">

                <img src="<?= htmlspecialchars($product['image_path']) ?>" class="img-fluid rounded" 
                    alt="Product Image" style="max-width: 250px; height: 250px;">
            </div>
        </div>
        <div class="col-4 col-sm-4 col-md-4">
            <div class="d-flex flex-column flex-md-row align-items-center align-items-md-start gap-1">
                <!-- Product Information (Right) -->
                <div class="flex-grow-1">
                    <h3 class="mb-3"><?= htmlspecialchars($product['product_name']) ?></h3>
                    <h5 class="text-success fw-bold">₱ <?= number_format($product['selling_price'], 2) ?> per <?= $product['stock_unit']  ?></h5>
                
                    <form id="addToCartForm">
                    <input type="hidden" id="productId" name="product_id" value="<?= $product['id'] ?>">
                    <input type="hidden" id="userId" name="user_id" value="<?= $user['id'] ?>">
                                <!-- Quantity Selector -->
                                <div class="mb-3">
                                
                                <div class="d-flex align-items-center justify-content-start gap-1 mt-3">
                                    <label for="productQuantity" class="form-label small">Quantity: </label> 
                                    <div class="input-group" style="width: auto;">
                                        <button class="btn btn-outline-secondary btn-sm" type="button" id="decreaseQty">-</button>
                                        <input type="number" id="productQuantity" class="form-control text-center" name="quantity"
                                            value="1" min="1" style="max-width: 70px;">
                                        <button class="btn btn-outline-secondary btn-sm" type="button" id="increaseQty">+</button>
                                    </div>
                                </div>
                                <div class="mb-3 mt-2">
                                <p class="text-muted fs-6"><?= $product['stocks'] ." ". $product['stock_unit']  ?> available</p>
                                </div>
                                <div class="mb-3 mt-2">
                                <p class="text-muted fs-6"><?= $soldProduct?> sold</p>
                                </div>
                            </div>
                    
                    <!-- Buttons -->
                    <div class="d-flex gap-2 mt-4">
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
        </div>

        <div class="col-12 col-md-4">
            <h5 class="section-title mb-2">Product Specification</h5>
            
            <div class="row  mb-2 small">
                    <div class="col-5 text-muted"><p class="text-muted mb-2 small">Category: </p></div>
                    <div class="col-1">:</div>
                    <div class="col-6 col-md-5 text-start"><?= htmlspecialchars($product['product_category']) ?></div>
            </div>
            <div class="row  mb-2 small">
                    <div class="col-5 text-muted"><p class="small">Description</p></div>
                    <div class="col-1">:</div>
                    <div class="col-6 col-md-5 text-start"> <?= nl2br(htmlspecialchars($product['product_description'])) ?></div>
            </div>
            <?php foreach ($productSpecification as $ps): ?>
                <div class="row  mb-2 small">
                    <div class="col-5 text-muted"><?= htmlspecialchars($ps['name']); ?></div>
                    <div class="col-1">:</div>
                    <div class="col-6 col-md-5 text-start"><?= htmlspecialchars($ps['value']); ?></div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>

</div>

   

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
                    }, 1000);
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

