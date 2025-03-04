<div class="sidebar close">
  <?php if (isAdmin()): ?>
    <div class="logo-details">
      <i class='bx bxl-c-plus-plus'></i>
      <span class="logo_name">ADMIN</span>
    </div>
    <ul class="nav-links">

      <!-- DASHBOARD -->
      <li>
        <a href="/admin">
          <i class='bx bx-grid-alt'></i>
          <span class="link_name">Dashboard</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="/admin">Dashboard</a></li>
        </ul>
      </li>

      <!-- PRODUCTS -->
      <li>
        <div class="iocn-link">
          <a href="#">
            <i class='bx bx-box'></i>
            <span class="link_name">Products</span>
          </a>
          <i class='bx bxs-chevron-down arrow'></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="#">Products</a></li>
          <li><a href="/products/create">Add New Product</a></li>
          <li><a href="/product/category">Product Categories</a></li>
          <li><a href="/product/varieties">Varieties</a></li>
          <li><a href="/product/stock-units">Stock Units</a></li>
          <li><a href="/product/batches">Batches</a></li>
          <li><a href="/product/inventory-adjustments">Inventory Adjustment</a></li>
          <li><a href="/product/discounts">Discounts</a></li>
          <li><a href="/product/brands">Brands</a></li>
        </ul>
      </li>

      <!-- ORDERS -->
      <li>
        <div class="iocn-link">
          <a href="/orders">
            <i class='bx bx-cart'></i>
            <span class="link_name">Orders</span>
          </a>
          <i class='bx bxs-chevron-down arrow'></i>
        </div>
        <ul class="sub-menu">
          <li><a href="/orders">All Orders</a></li>
          <li><a href="/orders/pending">Pending Orders</a></li>
          <li><a href="/orders/completed">Completed Orders</a></li>
          <li><a href="/orders/cancelled">Cancelled Orders</a></li>
        </ul>
      </li>

      <!-- CUSTOMERS -->
      <li>
        <a href="/customers">
          <i class='bx bx-user'></i>
          <span class="link_name">Customers</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="/customers">Customer List</a></li>
        </ul>
      </li>

      <!-- PAYMENTS -->
      <li>
        <a href="/payments">
          <i class='bx bx-credit-card'></i>
          <span class="link_name">Payments</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="/payments">Payment Records</a></li>
        </ul>
      </li>

      <!-- SHIPPING -->
      <li>
        <a href="/shipping">
        <i class='bx bx-package'></i>
          <span class="link_name">Shipping</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="/shipping">Shipping Methods</a></li>
        </ul>
      </li>

      <!-- REVIEWS -->
      <li>
        <a href="/reviews">
          <i class='bx bx-star'></i>
          <span class="link_name">Reviews</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="/reviews">Product Reviews</a></li>
        </ul>
      </li>

        <!-- REPORTS -->
        <li>
        <div class="iocn-link">
            <a href="#">
            <i class='bx bx-file'></i>
            <span class="link_name">Reports</span>
            </a>
            <i class='bx bxs-chevron-down arrow'></i>
        </div>
        <ul class="sub-menu">
            <li><a class="link_name" href="#">Reports</a></li>
            <li><a href="/report/sales">Sales Report</a></li>
            <li><a href="/report/inventory">Inventory Report</a></li>
            <li><a href="/report/customers">Customer Report</a></li>
        </ul>
        </li>

      <!-- SETTINGS -->
      <li>
        <a href="/settings">
          <i class='bx bx-cog'></i>
          <span class="link_name">Settings</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="/settings">General Settings</a></li>
        </ul>
      </li>

      <!-- MARKETING -->
      <li>
        <div class="iocn-link">
          <a href="#">
            <i class='bx bx-bullhorn'></i>
            <span class="link_name">Marketing</span>
          </a>
          <i class='bx bxs-chevron-down arrow'></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="#">Marketing</a></li>
          <li><a href="/marketing/coupons">Discount Coupons</a></li>
          <li><a href="/marketing/announcements">Announcements</a></li>
          <li><a href="/marketing/newsletter">Newsletter Subscribers</a></li>
        </ul>
      </li>

      <!-- NOTIFICATIONS -->
      <li>
        <a href="/notifications">
          <i class='bx bx-bell'></i>
          <span class="link_name">Notifications</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="/notifications">Notification Center</a></li>
        </ul>
      </li>

      <!-- LOGS -->
      <li>
        <a href="/logs">
          <i class='bx bx-history'></i>
          <span class="link_name">Logs</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="/logs">Activity Logs</a></li>
        </ul>
      </li>

      <!-- MESSAGES -->
      <li>
        <a href="/messages">
          <i class='bx bx-message'></i>
          <span class="link_name">Messages</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="/messages">Customer Messages</a></li>
        </ul>
      </li>


    </ul>
  <?php endif; ?>

  <?php if (isUser()): ?>
    <div class="logo-details">
      <i class='bx bxl-c-plus-plus'></i>
      <span class="logo_name">USER</span>
    </div>

    <ul class="nav-links">

      <li>
        <a href="/customer/dashboard">
          <i class='bx bx-home-alt'></i>
          <span class="link_name">Dashboard</span>
        </a>
      </li>

      <li>
        <a href="/customer/viewCategory">
          <i class="bx bx-category"></i>
          <span class="link_name">Category</span>
        </a>
      </li>

      <li>
        <a href="/customer/products">
          <i class='bx bx-store'></i>
          <span class="link_name">Products</span>
        </a>
      </li>

      <li>
        <a href="/customer/cart">
          <i class='bx bx-cart'></i>
          <span class="link_name">Cart</span>
        </a>
      </li>

      <li>
        <a href="/customer/orders">
          <i class='bx bx-package'></i>
          <span class="link_name">Orders</span>
        </a>
      </li>

      <li>
        <a href="/customer/reviews">
          <i class='bx bx-star'></i>
          <span class="link_name">Reviews</span>
        </a>
      </li>

      <li>
        <a href="/customer/profile">
          <i class='bx bx-user-circle'></i>
          <span class="link_name">Profile</span>
        </a>
      </li>

    </ul>

  <?php endif; ?>
</div>
