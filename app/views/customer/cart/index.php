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
                <input name="submit" type="submit" value="Order Now" id="submit" class="btn btn-secondary">  
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
document.addEventListener("DOMContentLoaded", function () {
    // Quantity increase and decrease buttons
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
            updateTotal(); // Update total price & items
        });
    });

    // Checkbox listener for individual cart items
    document.querySelectorAll(".cartCheckbox").forEach(checkbox => {
        checkbox.addEventListener("change", function () {
            updateTotal();
        });
    });

    // Select All Checkbox functionality
    document.getElementById("selectAll").addEventListener("change", function () {
        let isChecked = this.checked;
        document.querySelectorAll(".cartCheckbox").forEach(checkbox => {
            checkbox.checked = isChecked;
        });
        updateTotal();

    });

    // Function to update the quantity in the backend
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
                }
                updateTotal(); // Recalculate totals after updating the cart
            }
        })
        .catch(error => console.error("Error:", error));
    }

    // Function to calculate and update total items and price
    function updateTotal() {
        let totalItemCount = 0;
        let totalPriceAmount = 0;

        document.querySelectorAll(".cartCheckbox:checked").forEach(checkbox => {
            let cartId = checkbox.value;
            let priceElement = document.querySelector(`#subtotal-${cartId}`);
            let quantityInput = document.querySelector(`.productQuantity[data-id='${cartId}']`);

            if (priceElement && quantityInput) {
                let price = parseFloat(priceElement.getAttribute("data-price")) || 0;
                let quantity = parseInt(quantityInput.value) || 0;

                totalItemCount++;
                totalPriceAmount += price * quantity;
            }
        });
        console.log(document.querySelectorAll(".cartCheckbox:checked"));

        document.getElementById("totalItems").innerText = totalItemCount;
        document.getElementById("totalPrice").innerText = totalPriceAmount.toFixed(2);
    }

    $("#submit").click(function(e) {  
    e.preventDefault(); // Prevents default form submission

    var selectedItems = $("[name='cartIds[]']:checked").map(function() {
        return $(this).val();
    }).get(); // Get all checked cart item IDs

    if (selectedItems.length === 0) {
        alert("Please select a product(s) to order.");
        return false;
    }

    var confirmMessage = selectedItems.length === 1 
        ? "Are you sure you want to order this product?" 
        : "Are you sure you want to order these products?";

    if (!confirm(confirmMessage)) {
        return false;
    }
    
    // Send AJAX POST request
    $.ajax({
        url: "/customer/cart/checkoutSelected",
        type: "POST",
        data: { cartIds: selectedItems },  // Ensure it's sent as an array
        dataType: "json",
        success: function(response) {
            if (response.status === "success") {
                alert(response.message);
                location.reload(); // Reload page to update cart
            } else {
                alert(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
            alert("An error occurred. Please try again.");
        }
    });
});



});
</script>

