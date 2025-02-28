<style>
    .category-filter {
        display: flex;
        flex-wrap: nowrap; /* Prevents wrapping */
        overflow-x: auto; /* Enables horizontal scrolling if needed */
        white-space: nowrap; /* Ensures text stays in one line */
        justify-content: center; /* Centers the items */
        gap: 10px; /* Adds spacing between items */
    }

    .filter-status {
        font-size: 14px; /* Default size */
        padding: 5px 10px;
        text-align: center;
        flex-shrink: 0; /* Prevents shrinking */
        cursor: pointer;
    }

    @media (max-width: 576px) {
        .filter-status {
            font-size: 10px; /* Smaller font for mobile */
            padding: 3px 6px; /* Adjust padding */
        }
    }
</style>

<div class="container mt-4">
    <div class="p-2 border rounded bg-white mt-4">
        <div class="row text-center category-filter d-flex flex-wrap">
            <div class="col-2 col-sm-2 col-md-2 d-flex justify-content-center">
                <a class="card-title filter-status" data-status="All">
                    All
                </a>
            </div>
            <?php foreach($orderStatus as $orderStat): ?>
                <div class="col-2 col-sm-2 col-md-2 d-flex justify-content-center">
                    <a class="card-title filter-status" 
                    data-status="<?= htmlspecialchars($orderStat['id']) ?>">
                    <?= htmlspecialchars($orderStat['order_status']) ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="p-3 border rounded bg-white mt-4">
        <div class="row">
            <div class="col-md-12">
                <?php foreach ($customerOrder as $item): ?>
                    <div class="row">
                        <div class="p-3 border-bottom bg-white">
                            <div class="row align-items-center">
                                <input type="hidden" class="cartId" value="<?= htmlspecialchars($item['id']) ?>">
                                <input type="hidden" class="order" id="orderStatus" value="<?= htmlspecialchars($item['order_status']) ?>">

                                <!-- Product Image & Details -->
                                <div class="col-12 col-sm-6 d-flex align-items-center">
                                    <!-- Product Image -->
                                    <div class="me-3">
                                        <img src="<?= htmlspecialchars($item['image_path']) ?>" 
                                            class="img-fluid border rounded"
                                            style="width: 60px; height: 60px; object-fit: cover;">
                                    </div> 
                                    <!-- Product Info -->
                                    <div>
                                        <h6 class="mb-0"><?= htmlspecialchars($item['product_name']) ?></h6>
                                        <small class="text-muted"><?= htmlspecialchars($item['product_category']) ?></small>
                                        <p class="mb-0">x<?= htmlspecialchars($item['product_quantity']) ?></p>
                                    </div>
                                </div>

                                <!-- Subtotal -->
                                <div class="col-12 col-sm-6 text-center text-sm-end text-success fw-bold mt-2 mt-sm-0"> 
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

<style>
/* Responsive Image Size */
@media (max-width: 576px) { 
    img.img-fluid {
        width: 80px !important;
        height: 80px !important;
    }
}
</style>

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
