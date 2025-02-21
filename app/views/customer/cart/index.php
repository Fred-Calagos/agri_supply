<div class="container mt-4 p-3 border rounded bg-white">
    <h3 class="mb-4">Shopping Cart</h3>
        <div class="row">
            <div class="p-3 border-bottom border-primary bg-white">
                <div class="row align-items-center">
                    <div class="col-md-3 text-center">
                        <h6>Product</h6>
                    </div>
                    <div class="col-md-2 text-center">
                        <h6>Unit Price (kg)</h6>
                    </div>
                    <div class="col-md-2 text-center">
                        <h6>Quantity</h6>
                    </div>
                    <div class="col-md-2 text-center">
                        <h6>Total Price</h6>
                    </div>
                    <div class="col-md-2 text-center">
                        <h6>Action</h6>
                    </div>

                </div>
            </div>
        </div>
    <?php if (!empty($cartItems)): ?>
            <?php foreach ($cartItems as $item): ?>
                <div class="row">
                    <div class="p-3 border-bottom bg-white">
                        <div class="row align-items-center">
                            <input type="hidden" id="userId" value="<?= htmlspecialchars($user['id']) ?>">
                            <input type="hidden" id="productId" value="<?= htmlspecialchars($item['product_id']) ?>">
                            <input type="hidden" class="cartId" value="<?= htmlspecialchars($item['id']) ?>">

                            <div class="col-md-3 d-flex align-items-center justify-content-center text-center">
                                <div class="row w-100">
                                    <!-- Product Image -->
                                    <div class="col-md-8 d-flex justify-content-center">
                                        <img src="<?= htmlspecialchars($item['image_path']) ?>" class="img-fluid border rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                    </div>
                                    <!-- Product Name -->
                                    <div class="col-md-4 d-flex align-items-center justify-content-center ">
                                        <h6><?= htmlspecialchars($item['product_name']) ?></h6>                                    
                                    </div>
                                </div>
                            </div>

                           <div class="col-md-2 text-center">
                               <?= htmlspecialchars($item['selling_price']) ?>
                           </div>
                                <!-- Quantity -->
                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                        <div class="input-group" style="width: auto;">
                                            <button class="btn btn-outline-secondary btn-sm decreaseQty" type="button" data-id="<?= $item['id'] ?>">-</button>
                                            <input type="number" class="form-control text-center productQuantity" name="quantity" min="1" style="max-width: 70px;" value="<?= $item['quantity'] ?>" data-id="<?= $item['id'] ?>">
                                            <button class="btn btn-outline-secondary btn-sm increaseQty" type="button" data-id="<?= $item['id'] ?>">+</button>
                                        </div>
                                    </div>

                                    <!-- Price -->
                                    <div class="col-md-2 text-center text-success" 
                                            id="subtotal-<?= $item['id'] ?>" 
                                            data-price="<?= htmlspecialchars($item['selling_price']) ?>">
                                            ₱ <?= number_format($item['selling_price'] * $item['quantity'], 2) ?>
                                    </div>

                            <!-- Remove Button -->
                            <div class="col-md-2 text-center">
                                <button class="btn btn-danger btn-sm removeFromCartBtn" data-id="<?= $item['id'] ?>">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <!-- Clear Cart Button -->
        <div class="text-end mt-4">
            <button class="btn btn-danger" id="clearCartBtn">Clear Cart</button>
        </div>
    <?php else: ?>
        <div class="text-center p-4">
            <h5 class="text-muted">Your cart is empty</h5>
        </div>
    <?php endif; ?>
</div>

<script>
document.querySelectorAll(".removeFromCartBtn").forEach(button => {
    button.addEventListener("click", function () {
        let productId = this.getAttribute("data-id");

        fetch("/cart/removeFromCart", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "product_id=" + productId
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                location.reload();
            }
        });
    });
});

document.getElementById("clearCartBtn").addEventListener("click", function () {
    fetch("/cart/clearCart", {
        method: "POST"
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            location.reload();
        }
    });
});


document.querySelectorAll(".decreaseQty, .increaseQty").forEach(button => {
    button.addEventListener("click", function () {
        let cartId = this.getAttribute("data-id");
        let input = document.querySelector(`.productQuantity[data-id='${cartId}']`);
        let action = this.classList.contains("decreaseQty") ? "decrease" : "increase";

        let currentValue = parseInt(input.value);

        if (action === "decrease" && currentValue > 1) {
            input.value = currentValue - 1;
        } else if (action === "increase") {
            input.value = currentValue + 1;
        }

        updateCartQuantity(cartId, input.value);
    });
});


function updateCartQuantity(cartId, quantity) {
    fetch(`/customer/cart/updateQuantity/${cartId}`, { 
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `quantity=${quantity}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            let subtotalElement = document.querySelector(`#subtotal-${cartId}`);

            if (subtotalElement) { // Ensure the element exists
                let price = parseFloat(subtotalElement.getAttribute("data-price")) || 0; // Default to 0 if null
                subtotalElement.innerText = "₱ " + (price * quantity).toFixed(2);
            } else {
                console.error("Subtotal element not found for cartId:", cartId);
            }
        }
    })
    .catch(error => console.error("Error:", error));
}





</script>
