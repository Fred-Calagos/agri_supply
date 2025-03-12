<div class="container">
    <div class="row">
        <div class="col-12 col-lg-12 col-md-12 col-sm-12">
            <!-- User Information Card -->
            <div class="card mb-3">
                <div class="card-header">
                    User Information
                </div>
                <div class="card-body">
                    <p>Name: <?= htmlspecialchars($user['name']) ?></p>
                    <p>Email: <?= htmlspecialchars($user['email']) ?></p>
                    <p class="small">Address: <?= htmlspecialchars($user['address']) ?></p>
                    <p>Address Info: <?= htmlspecialchars($user['place_desc']) ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-7 col-md-12 col-sm-12">
            <!-- Cart Items Card -->
            <div class="card mb-3">
                <div class="card-header bg-white">
                    Cart Items
                </div>
                <div class="card-body">
                    <?php 
                    $totalPrice = 0;
                    foreach ($cartItems as $item): 
                        $totalPrice += $item['selling_price'] * $item['quantity'];
                    ?>
                        <div class="row mb-1    ">
                            <div class="col-12 p-3 border-bottom bg-white">
                                <div class="row align-items-center">
                                    <div class="col-md-5 d-flex flex-column flex-md-row align-items-center justify-content-between text-center text-md-start">
                                        <!-- Product Name -->
                                        <div class="w-100 mb-1 mb-md-0">
                                            <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['product_name']) ?>" class="img-fluid border rounded cart" style="width: 80px; height: 80px; object-fit: cover;">
                                        </div>
                                        <div class="w-100 mb-1 mb-md-0">
                                            <p class="m-0 small"><?= htmlspecialchars($item['product_name']) ?></p>
                                            <p class="m-0 small text-muted">Quantity: <?= htmlspecialchars($item['quantity']) ?></p>
                                        </div>
                                    </div>
                                    <!-- Quantity -->
                                    <div class="col-md-3 text-center">
                                        <p class="m-0">₱<?= number_format($item['selling_price'] * $item['quantity'], 2) ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="row align-items-center">
                        <p class="m-0 small text-muted">Total: ₱<?= number_format($totalPrice, 2) ?></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-12">
                <div class="container">
                    <!-- Payment Method Card -->
                    <div class="form-group">
                        <label for="paymentMethod">Choose Payment Method:</label>
                        <select class="form-select" id="paymentMethod" name="payment_id" required>
                        <?php foreach ($payment as $pay): ?>
                            <option value="<?= $pay['id'] ?>"><?= $pay['payment_method'] ?></option>
                        <?php endforeach; ?>
                        </select>
                        <button type="button" id="checkoutButton" class="btn btn-success mt-3">Order Selected</button>
                    </div>
                </div>
            </div>

        </div>
        
  
    </div>
</div>
<script>
$(document).ready(function() {
    $("#checkoutButton").on("click", function() { // Fixed this line
        console.log("Checkout button clicked!"); // Debugging log

        let selectedItems = <?= json_encode(array_column($cartItems, 'id')) ?>;
        let paymentId = $("#paymentMethod").val();

        if (selectedItems.length === 0) {
            alert("No items in the cart.");
            return;
        }

        console.log("Selected Items:", selectedItems); // Debugging
        console.log("Payment ID:", paymentId); // Debugging

        $.ajax({
            url: "/customer/cart/OrderSelected",
            type: "POST",
            data: { cartIds: selectedItems, payment_id: paymentId },
            dataType: "json",
            success: function(response) {
                console.log("Response:", response); // Debugging
                alert(response.message);
                if (response.status === "success") {
                    location.reload();
                }
            },
            error: function(xhr) {
                console.error("Error:", xhr.responseText);
                alert("An error occurred. Please try again.");
            }
        });
    });
});

</script>
