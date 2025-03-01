<div class="container shadowmt-4 p-3 border rounded bg-white">
    <h3 class="mb-4 border-bottom p-3 border-primary">Shopping Cart</h3>

<?php if (!empty($cartItems)): ?>
    <form id="cartForm">
        <?php foreach ($cartItems as $item): ?>
            <div class="row">
                <div class="p-3 border-bottom bg-white">
                    <div class="row align-items-center">
                        <input type="hidden" class="cartId" value="<?= htmlspecialchars($item['id']) ?>">

                        <div class="col-5 col-sm-5 col-md-5 d-flex align-items-center gap-1">
                            <!-- Checkbox -->
                            <input type="checkbox" class="cartCheckbox" value="<?= htmlspecialchars($item['id']) ?>" name="cartIds[]">
                            <!-- Product Image -->
                            <img src="<?= htmlspecialchars($item['image_path']) ?>" class="img-fluid border rounded cart" style="width: 80px; height: 80px; object-fit: cover;">
                        </div>
                        <div class="col-5 col-sm-5 col-md-5 d-flex flex-column flex-md-row align-items-center justify-content-between text-center text-sm-start">
                            <!-- Product Name -->
                            <div class="w-100 mb-1 mb-md-0">
                                <p class="m-0"><?= htmlspecialchars($item['product_name']) ?></p>
                            </div>
                            <!-- Subtotal -->
                            <div class="w-100 text-success">
                                <span id="subtotal-<?= $item['id'] ?>" data-price="<?= htmlspecialchars($item['selling_price']) ?>">
                                    ₱ <?= number_format($item['selling_price'] * $item['quantity'], 2) ?>
                                </span>
                            </div>
                            <div class="w-100 mb-2 mb-md-0 d-flex justify-content-start">
                                <div class="input-group" style="width: auto;">
                                    <button class="btn btn-outline-secondary btn-sm decreaseQty" type="button" data-id="<?= $item['id'] ?>">-</button>
                                    <input type="number" class="form-control text-center productQuantity" name="quantity" min="1" style="max-width: 70px;" value="<?= $item['quantity'] ?>" data-id="<?= $item['id'] ?>">
                                    <button class="btn btn-outline-secondary btn-sm increaseQty" type="button" data-id="<?= $item['id'] ?>">+</button>
                                </div>
                            </div>
                        </div>
                        
                            <!-- Quantity -->


                        <!-- Remove Button -->
                        <div class="col-2 col-sm-2 col-md-2 text-center">
                            <button class="btn btn-danger btn-sm removeFromCartBtn" data-id="<?= $item['id'] ?>" data-product-name="<?= $item['product_name'] ?>">
                                <i class="bx bx-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="row p-3 mt-4">
            <!-- Select All Checkbox -->
            <div class="col-12 col-sm-12 col-md-6 d-flex align-items-center mb-2 mb-md-0">
                <input type="checkbox" id="selectAll" class="me-2"> <span>Select All</span>
            </div>

            <!-- Total Price & Order Button -->
            <div class="col-12 col-sm-12 col-md-6 d-flex justify-content-md-end align-items-center gap-2">
                <span>Total (<span id="totalItems">0</span> items): ₱ <span id="totalPrice">0.00</span></span>
                <input name="submit" type="submit" value="Order Now" id="submit" class="btn btn-secondary btn-sm">
            </div>
        </div>


    </form>
<?php else: ?>
    <div class="text-center p-4">
        <h5 class="text-muted">Your cart is empty</h5>
    </div>
<?php endif; ?>

</div>

<!-- Delete Cart Item Modal -->
<div class="modal fade" id="deleteCartItemModal" tabindex="-1" aria-labelledby="deleteCartItemLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCartItemLabel">Delete Cart Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to remove this item from your cart?</p>
                <p id="productInfo"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger btn-sm" id="confirmDeleteCartItem">Delete</button>
            </div>
        </div>
    </div>
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
        url: "/customer/cart/OrderSelected",
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

// Delete Cart Item Modal
$(document).on('click', '.removeFromCartBtn', function (e) {
    e.preventDefault();
    var cartId = $(this).data('id'); // Get the cart item ID
    var productName = $(this).data('product-name'); // Get the cart item ID
    var productCategory = $(this).data('product-category'); // Get the cart item ID

    if (!cartId) {
        alert("Error: No item ID found.");
        return;
    }
    // Display the selected product in the Delete Modal
    $('#productInfo').text('Product: ' + productName );
    // Store the cart item ID in the delete confirmation button
    $('#confirmDeleteCartItem').data('id', cartId);

    // Show the delete confirmation modal
    $('#deleteCartItemModal').modal('show');
});

// Confirm Deletion
$('#confirmDeleteCartItem').click(function () {
    var cartId = $(this).data('id');

    if (!cartId) {
        alert("Error: No item ID found.");
        return;
    }


    $.ajax({
        type: "GET",
        url: "/customer/cart/delete/" + cartId,  // Ensure ID is included
        success: function(response) {
            console.log("Delete successful:", response); // Debugging
            $('#deleteCartItemModal').modal('hide');
            location.reload();
        },
        error: function(xhr) {
            console.log("Server Error:", xhr.responseText); // Debugging: Log any server errors
            alert("Error deleting the academic year.");
        }
    });
});

});
</script>

