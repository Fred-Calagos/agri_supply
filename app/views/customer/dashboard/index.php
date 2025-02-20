<div class="p-3 border rounded bg-white">
    <h4 class="section-title mb-3">🍎 Fruit Section</h4>
    <div class="row g-3">
        <?php foreach($fruitProducts as $product): ?>
            <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card product-card h-100 shadow-sm add-to-cart-card" 
                data-id="<?= $product['id'] ?>" 
                style="cursor: pointer;"
                onclick="window.location.href='/customer/product_detail?id=<?= $product['id'] ?>'">

                    
                    <img src="<?= htmlspecialchars($product['image_path']) ?>" class="card-img-top product-img" alt="Product Image">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= htmlspecialchars($product['product_name']) ?></h5>
                        <p class="card-text text-success fw-bold">₱ <?= number_format($product['selling_price'], 2) ?> per kilo</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary btn-sm add-to-cart">
                                <i class='bx bx-cart-add' style="font-size: 1.2rem;"></i> Add to Cart
                            </button>
                            <i class='bx bx-heart heart-icon' style="font-size: 1.5rem; cursor: pointer;"></i>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>


    <!-- Vegetable Section -->
    <div class="p-3 border rounded bg-white">
        <h4 class="section-title mb-3">🥦 Vegetable Section</h4>
        <div class="row g-3">
            <?php foreach ($vegetableProducts as $product): ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card product-card h-100 shadow-sm add-to-cart-card" data-id="<?= $product['id'] ?>" data-name="<?= htmlspecialchars($product['product_name']) ?>" data-price="<?= $product['selling_price'] ?>" data-image="<?= htmlspecialchars($product['image_path']) ?>" style="cursor: pointer;">
                        <img src="<?= htmlspecialchars($product['image_path']) ?>" class="card-img-top product-img" alt="Product Image">
                        <div class="card-body text-center">
                            <h5 class="card-title"><?= htmlspecialchars($product['product_name']) ?></h5>
                            <p class="card-text text-success fw-bold">₱ <?= number_format($product['selling_price'], 2) ?> per kilo</p>
                            <div class="d-flex justify-content-between align-items-center">
                            <button class="btn btn-primary btn-sm add-to-cart" data-id="<?= $product['id'] ?>" data-name="<?= htmlspecialchars($product['product_name']) ?>" data-price="<?= $product['selling_price'] ?>" data-image="<?= htmlspecialchars($product['image_path']) ?>">
                                <i class='bx bx-cart-add' style="font-size: 1.2rem;"></i> Add to Cart
                            </button>

                                <i class='bx bx-heart heart-icon' style="font-size: 1.5rem; cursor: pointer;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

<!-- Product Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Product Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5 text-center">
                        <img id="modalProductImage" src="" class="img-fluid img-thumbnail" style="width: 200px; height: 200px; object-fit: contain; border-radius: 10%;">
                    </div>
                    <div class="col-md-7">
                        <h4 id="modalProductName"></h4>
                        <p class="text-success fw-bold">₱ <span id="modalProductPrice"></span> per kilo</p>

                        <!-- Quantity Selection -->
                        <div class="mb-3">
                            <label for="productQuantity" class="form-label">Quantity (kg)</label>
                            <div class="input-group">
                                <button class="btn btn-outline-secondary" type="button" id="decreaseQty">-</button>
                                <input type="number" id="productQuantity" class="form-control text-center" value="1" min="1">
                                <button class="btn btn-outline-secondary" type="button" id="increaseQty">+</button>
                            </div>
                        </div>

                        <!-- Add to Cart Button -->
                        <button class="btn btn-primary w-100" id="confirmAddToCart">
                            <i class='bx bx-cart-add'></i> Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// $(document).ready(function () {
//     // Open modal and populate details
//     $(".add-to-cart-card").click(function () {
//         var id = $(this).data("id");
//         var name = $(this).data("name");
//         var price = $(this).data("price");
//         var image = $(this).data("image");

//         // Populate modal fields
//         $("#modalProductImage").attr("src", image);
//         $("#modalProductName").text(name);
//         $("#modalProductPrice").text(price);
//         $("#confirmAddToCart").data("id", id).data("name", name).data("price", price);
//     });

//     // Add to cart button inside modal (AJAX request to store in database)
//     $("#confirmAddToCart").click(function () {
//         var productId = $(this).data("id");
//         var productPrice = $(this).data("price");
//         var quantity = parseInt($("#productQuantity").val());

//         $.ajax({
//             type: "POST",
//             url: "/cart/store/",
//             data: {
//                 product_id: productId,
//                 quantity: quantity,
//                 price: productPrice,
//                 total: productPrice * quantity,
//                 status: "pending" // You can modify this if needed
//             },
//             success: function (response) {
//                 $("#productModal").modal("hide");
//                 alert("Added to cart successfully!");
//             },
//             error: function () {
//                 alert("Error adding to cart. Please try again.");
//             }
//         });
//     });
// });

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".product-link").forEach(card => {
        card.addEventListener("click", function () {
            const productId = this.getAttribute("data-id");
            window.location.href = `/customer/product_detail?id=${productId}`;
        });
    });
});


document.getElementById("decreaseQty").addEventListener("click", function () {
        let quantityInput = document.getElementById("productQuantity");
        let currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    });

    document.getElementById("increaseQty").addEventListener("click", function () {
        let quantityInput = document.getElementById("productQuantity");
        quantityInput.value = parseInt(quantityInput.value) + 1;
    });


</script>
