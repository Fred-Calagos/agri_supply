<div class="container mt-4">
    <div class="p-3 border rounded bg-white mt-4">
        <div class="row g-3">
                <div class="col-md-2">
                    <a class="card-title text-center filter-status"
                        data-status="All"
                        style="cursor: pointer;">All
                    </a>
                </div>
            <?php foreach($orderStatus as $orderStat): ?>
                <div class="col-md-2">
                    <a class="card-title text-center filter-status"
                        data-status="<?= htmlspecialchars($orderStat['id']) ?>"
                        style="cursor: pointer;">
                        <?= htmlspecialchars($orderStat['order_status']) ?>
                    </a>
                </div>
            <?php endforeach;?>
        </div>
    </div>

    <div class="p-3 border rounded bg-white mt-4">
        <div class="row">
            <div class="col-md-12">
            <?php foreach ($customerOrder as $item): ?>
                <div class="row">
                <div class="p-3 border-bottom bg-white">
                    <div class="row align-items-center">
                        <input type="hidden" class="cartId" value="<?= htmlspecialchars($item['id']) ?>">
                        <input type="hidden" class="order" id="orderStatus" value="<?= htmlspecialchars($item['order_status']) ?>">

                        <div class="col-md-3 d-flex align-items-center justify-content-center text-center">
                            <div class="row w-100">
                                <!-- Product Image -->
                                <div class="col-md-6 d-flex justify-content-center">
                                    <img src="<?= htmlspecialchars($item['image_path']) ?>" class="img-fluid border rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                </div>
                                <!-- Product Name -->
                                <div class="col-md-4 justify-content-center">
                                    <div class="row">
                                        <div class="col-md-4">
                                        <h5><?= htmlspecialchars($item['product_name']) ?></h5>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                        <p><?= htmlspecialchars($item['product_category']) ?></p>
                                        </div>
                                    </div>                                
                                    <div class="row">
                                        <div class="col-md-4">
                                        <p>x<?= htmlspecialchars($item['product_quantity']) ?></p>
                                        </div>
                                    </div>                                
                                </div>
                            </div>
                        </div>

                        <!-- Subtotal -->
                        <div class="col-md-6 text-center text-success justify-content-end"> 
                            ₱ <?= number_format($item['selling_price'] * $item['product_quantity'], 2) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const filterLinks = document.querySelectorAll(".filter-status");

    filterLinks.forEach(link => {
        link.addEventListener("click", function () {
            // Remove 'active' class from all buttons
            filterLinks.forEach(l => l.classList.remove("active"));

            // Add 'active' class to the clicked button
            this.classList.add("active");
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const filterLinks = document.querySelectorAll(".filter-status");
    const orders = document.querySelectorAll(".p-3.border-bottom.bg-white");

    filterLinks.forEach(link => {
        link.addEventListener("click", function () {
            const selectedStatus = this.getAttribute("data-status");

            orders.forEach(order => {
                const orderStatusInput = order.querySelector("#orderStatus"); // Get hidden input
                const orderStatus = orderStatusInput ? orderStatusInput.value : null;

                if (selectedStatus === "All" || orderStatus === selectedStatus) {
                    order.style.display = "block";
                } else {
                    order.style.display = "none";
                }
            });
        });
    });
});

</script>
