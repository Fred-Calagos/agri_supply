<div class="container mt-4">
    <h3>Shopping Cart</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($cartItems)): ?>
                    <?php foreach ($cartItems as $item): ?>
                        <tr>
                            <td><img src="<?= htmlspecialchars($item['image']) ?>" style="width: 50px;"></td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>₱ <?= number_format($item['price'], 2) ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>₱ <?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                            <td>
                                <button class="btn btn-danger btn-sm removeFromCartBtn" data-id="<?= $item['id'] ?>">Remove</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Your cart is empty</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <button class="btn btn-danger" id="clearCartBtn">Clear Cart</button>
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
</script>
