<div class="container mt-4 position-relative">
    <!-- Left Arrow -->
    <button class="scroll-btn left-btn d-none d-md-block" onclick="autoScroll(-1)">&#10094;</button>

    <div class="scroll-container">
        <?php foreach($categories as $category): ?>
            <div class="scroll-item">
                <div class="card shadow-sm card-category">
                    <div class="card-body d-flex align-items-center justify-content-center ">
                        <h5 class="card-title text-center m-0"><?= htmlspecialchars($category['product_category']) ?></h5>
                        <a href="/customer/category?category=<?= htmlspecialchars($category['id']) ?>" class="stretched-link"></a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Right Arrow -->
    <button class="scroll-btn right-btn d-none d-md-block" onclick="autoScroll(1)">&#10095;</button>
</div>

<style>
/* Scrollable container */
.scroll-container {
    display: flex;
    overflow-x: auto;
    gap: 10px;
    padding: 10px 0;
    scrollbar-width: none; /* Hide scrollbar for Firefox */
    -ms-overflow-style: none; /* Hide scrollbar for IE */
    scroll-behavior: smooth; /* Smooth scrolling */
    user-select: none;
    cursor: grab;
}

/* Hide scrollbar in WebKit browsers */
.scroll-container::-webkit-scrollbar {
    display: none;
}

/* Individual card item */
.scroll-item {
    flex: 0 0 auto;
    width: 200px; /* Adjust width as needed */
    transition: transform 0.3s ease-in-out;
}
.card-category{
    color: white;
    background-color: green;
    text-align: center;
    padding: 10px;
    height: 100px;
    border-radius: 10px;
    border: none;
    box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
    position: relative;
}

.card-body {
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Hover effect */
.scroll-item:hover {
    transform: scale(1.05);
}

/* Scroll buttons (arrows) */
.scroll-btn {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(0, 0, 0, 0.5);
    color: white;
    border: none;
    padding: 10px 15px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 24px;
    transition: background 0.3s ease-in-out;
}

.scroll-btn:hover {
    background: rgba(0, 0, 0, 0.8);
}

.left-btn {
    left: -30px;
}

.right-btn {
    right: -30px;
}

/* Hide arrows on small screens */
@media (max-width: 768px) {
    .scroll-btn {
        display: none !important;
    }
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const slider = document.querySelector(".scroll-container");
    let isDragging = false;
    let startX, scrollLeft;

    slider.addEventListener("mousedown", (e) => {
        isDragging = true;
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
        slider.style.cursor = "grabbing";
    });

    document.addEventListener("mouseup", () => {
        isDragging = false;
        slider.style.cursor = "grab";
    });

    slider.addEventListener("mousemove", (e) => {
        if (!isDragging) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        const walk = (x - startX) * 2; // Adjust scroll speed
        slider.scrollLeft = scrollLeft - walk;
    });

    // Smooth scroll using buttons
    window.autoScroll = function(direction) {
        slider.scrollBy({ left: direction * 200, behavior: "smooth" });
    };
});
</script>


<!-- Search Box -->
<div class="container">
<div class="p-3 border rounded bg-white mt-4">
<!-- Header Section with Search Bar -->
<div class="row g-3 border-bottom bottom-primary mb-3">
        <div class="col-md-6 mb-2">
            <!-- Title on the Left -->
            <h4 class="section-title mb-0">Agri-Supply Products</h4>
        </div>
        <div class="col-md-6">
        <!-- Search Bar with Icon -->
        <div class="mb-2 position-relative" style="right:0; width: 100%;">
            <!-- Search Icon -->
            <i class='bx bx-search-alt-2 position-absolute' style="left: 20px; top: 50%; transform: translateY(-50%); font-size: 1.2rem; color: gray;"></i>
            <!-- Search Input -->
            <input type="text" id="searchInput" class="form-control ps-5" placeholder="Search for products...">


            <!-- Search Results (With High Z-Index) -->
            <div id="searchResults" class="position-absolute d-flex flex-column"></div>
        </div>
</div>

    

</div>


<!-- Product Cards -->
<div class="row g-3">
    <?php foreach ($products as $product): ?> 
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="card product-card h-100 shadow-sm add-to-cart-card" 
                data-id="<?= htmlspecialchars($product['id']) ?>" 
                onclick="window.location.href='/customer/product_detail?id=<?= htmlspecialchars($product['id']) ?>'">
                
                <img src="<?= htmlspecialchars($product['image_path']) ?>" class="card-img-top product-img" alt="Product Image">
                <div class="card-body text-center border border-top">
                    <h5 class="card-title"><?= htmlspecialchars($product['product_name']) ?></h5>
                    <p class="card-text text-success fw-bold">₱ <?= number_format($product['selling_price'], 2) ?> per kilo</p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</div>
</div>

<script>
$(document).ready(function () {
    $("#searchInput").on("keyup", function () {
        let query = $(this).val().trim();

        if (query.length > 0) {
            $.ajax({
                type: "POST",
                url: "/customer/search", // Fixed endpoint
                data: { query: query },
                success: function (response) {
                    try {
                        let result = JSON.parse(response);
                        if (result.status === "success") {
                            let resultHTML = '<ul class="list-group mb-3">';
                            result.products.forEach(product => {
                                resultHTML += `<li class="list-group-item">
                                    <a href="/customer/product_detail?id=${product.id}" class="text-decoration-none">
                                        ${product.product_name} - ${product.product_category}
                                    </a>
                                </li>`;
                            });
                            resultHTML += '</ul>';
                            $("#searchResults").html(resultHTML);
                        } else {
                            $("#searchResults").html('<p class="text-danger">No products found</p>');
                        }
                    } catch (error) {
                        console.error("Error parsing JSON:", error);
                        $("#searchResults").html('<p class="text-danger">Error loading search results</p>');
                    }
                },
                error: function () {
                    $("#searchResults").html('<p class="text-danger">Server error. Try again later.</p>');
                }
            });
        } else {
            $("#searchResults").html("");
        }
    });

    $(".add-to-cart-card").click(function () {
        const productId = $(this).data("id");
        window.location.href = `/customer/product_detail?id=${productId}`;
    });
});


</script>
