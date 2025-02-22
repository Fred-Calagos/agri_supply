<div class="container mt-4 p-3 border rounded bg-white">
    <h3 class="mb-4">Shopping Cart</h3>
        <div class="row">
            <div class="p-3 border-bottom border-primary bg-white">
                <div class="row align-items-center">
                    <div class="col-md-3 text-left">
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
    <form id="cartForm">
        <?php foreach ($cartItems as $item): ?>
            <div class="row">
                <div class="p-3 border-bottom bg-white">
                    <div class="row align-items-center">
                        <input type="hidden" class="cartId" value="<?= htmlspecialchars($item['id']) ?>">

                        <div class="col-md-3 d-flex align-items-center justify-content-center text-center">
                            <div class="row w-100">
                                <!-- Checkbox -->
                                <div class="col-md-2 d-flex justify-content-center">
                                    <input type="checkbox" class="cartCheckbox" value="<?= htmlspecialchars($item['id']) ?>" name="cartIds[]">
                                </div>
                                <!-- Product Image -->
                                <div class="col-md-6 d-flex justify-content-center">
                                    <img src="<?= htmlspecialchars($item['image_path']) ?>" class="img-fluid border rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                </div>
                                <!-- Product Name -->
                                <div class="col-md-4 d-flex align-items-center justify-content-center">
                                    <h6><?= htmlspecialchars($item['product_name']) ?></h6>                                    
                                </div>
                            </div>
                        </div>

                        <!-- Price -->
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

                        <!-- Subtotal -->
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

        <!-- Bulk Actions -->
        <div class="d-flex justify-content-between p-3 mt-4">
            <div>
                <input type="checkbox" id="selectAll"> Select All
                <button class="btn text-danger" id="deleteSelectedBtn">Delete</button>
            </div>
            <div>
                <span>Total (<span id="totalItems">0</span> items): ₱ <span id="totalPrice">0.00</span></span>
                <button class="btn btn-danger" id="checkoutSelectedBtn">Buy Now</button>
            </div>
        </div>
    </form>
<?php else: ?>
    <div class="text-center p-4">
        <h5 class="text-muted">Your cart is empty</h5>
    </div>
<?php endif; ?>

</div>

<script>
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

            if (subtotalElement) {
                let price = parseFloat(subtotalElement.getAttribute("data-price")) || 0;
                let newSubtotal = price * quantity;
                subtotalElement.innerText = "₱ " + newSubtotal.toFixed(2);
            } else {
                console.error("Subtotal element not found for cartId:", cartId);
            }

            // **Call updateTotal to recalculate total price**
            updateTotal();
        }
    })
    .catch(error => console.error("Error:", error));    
}

    
document.addEventListener("DOMContentLoaded", function () {
    const selectAllCheckbox = document.getElementById("selectAll");
    const checkboxes = document.querySelectorAll(".cartCheckbox");
    const deleteBtn = document.getElementById("deleteSelectedBtn");
    const checkoutBtn = document.getElementById("checkoutSelectedBtn");
    const totalItems = document.getElementById("totalItems");
    const totalPrice = document.getElementById("totalPrice");

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




    // Select/Deselect All
    selectAllCheckbox.addEventListener("change", function () {
        checkboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
        updateTotal();
    });

    // Update total items & price when selecting individual checkboxes
    checkboxes.forEach(cb => cb.addEventListener("change", updateTotal));

    function updateTotal() {
    let totalItemCount = 0;
    let totalPriceAmount = 0;

    checkboxes.forEach(cb => {
        if (cb.checked) {
            totalItemCount++;

            let priceElement = document.querySelector(`#subtotal-${cb.value}`);
            let quantityInput = document.querySelector(`.productQuantity[data-id='${cb.value}']`);

            if (priceElement && quantityInput) {
                let price = parseFloat(priceElement.getAttribute("data-price")) || 0;
                let quantity = parseInt(quantityInput.value) || 0;

                totalPriceAmount += price * quantity;
            }
        }
    });

    totalItems.innerText = totalItemCount;
    totalPrice.innerText = totalPriceAmount.toFixed(2); // Ensure 2 decimal places
}

    // Delete Selected Items
    deleteBtn.addEventListener("click", function () {
        let selectedIds = Array.from(checkboxes).filter(cb => cb.checked).map(cb => cb.value);

        if (selectedIds.length === 0) {
            alert("Please select items to delete.");
            return;
        }

        if (confirm("Are you sure you want to delete the selected items?")) {
            fetch("/customer/cart/deleteSelected", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: `cartIds=${JSON.stringify(selectedIds)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    selectedIds.forEach(id => document.querySelector(`input[value='${id}']`).closest(".row").remove());
                    updateTotal();
                }
            })
            .catch(error => console.error("Error:", error));
        }
    });

    
    checkoutBtn.addEventListener("click", function () {
    let selectedItems = {};
    document.querySelectorAll(".cartCheckbox:checked").forEach(cb => {
        let quantityInput = document.querySelector(`.productQuantity[data-id='${cb.value}']`);
        selectedItems[cb.value] = quantityInput.value;
    });

    if (Object.keys(selectedItems).length === 0) {
        alert("Please select items to checkout.");
        return;
    }

    fetch("/customer/cart/checkoutSelected", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ cartItemss: selectedItems })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert("Checkout successful!");
            location.reload();
        }
    })
    .catch(error => console.error("Error:", error));
});

});





</script>
