    <style>
/* Bottom Navigation */
.bottom-nav {
    position: fixed;
    bottom: 0;
    width: 100%;
    background: #fff;
    justify-content: space-around;
    align-items: center;
    padding: 10px 0;
    border-top: 2px solid #ddd;
    box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.1);
    display: none; /* Hides on desktop */
    z-index: 1000;
}

.bottom-nav a {
    text-decoration: none;
    color: #333;
    font-size: 14px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 3px;
    transition: 0.3s;
}

.bottom-nav a i {
    font-size: 20px;
}

.bottom-nav a:hover {
    color: #007bff;
}

    /* Show bottom nav only on mobile */
    @media (max-width: 600px) {
        .bottom-nav {
            display: flex;
        }

        /* Prevent content from being hidden under the bottom nav */
        .content  {
            padding-bottom: 60px; /* Adjust this based on the nav height */
        }
        .container{
            margin-bottom: 60px;
        }
    }


    </style>
    <?php if (isAdmin()): ?>
    <!-- Bottom Navigation (Hidden on Desktop, Visible on Mobile) -->
    <div class="bottom-nav">
        <a href="/admin"><i class="bx bx-home"></i> Home</a>
        <a href="/products"><i class="bx bx-box"></i> Products</a>
        <a href="/orders"><i class="bx bx-shopping-bag"></i> Orders</a>
        <a href="/account"><i class="bx bx-user"></i> Account</a>
    </div>
    <?php endif;?>
    <?php if (isUser()): ?>
    <!-- Bottom Navigation (Hidden on Desktop, Visible on Mobile) -->
    <div class="bottom-nav">
        <a href="/customer/dashboard"><i class="bx bx-home"></i> Home</a>
        <a href="/customer/viewCategory"><i class="bx bx-category"></i> Category</a>
        <a href="/customer/cart"><i class="bx bx-cart"></i> Cart</a>
        <a href="/customer/orders"><i class="bx bx-shopping-bag"></i> Orders</a>
    </div>
    <?php endif;?>


</body>

<script src="/js/ajaxFormHandler.js"></script>
<script type="module" src="/js/main.js"></script>
<script src="/js/sidebar.js" defer></script>
<script src="/js/dependent.js" defer></script>
<!-- Local Bootstrap JS -->
<script src="/js/bootstrap.bundle.min.js"></script>
</html>

