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
          <i class='bx bx-grid-alt' ></i>
          <span class="link_name">Dashboard</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="/admin">Dashboard</a></li>
        </ul>
      </li>

      <!-- PRODUCTS -->
      <li>
        <a href="/products">
        <i class='bx bxs-leaf'></i>
          <span class="link_name">Products</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="/products">Products</a></li>
        </ul>
      </li>

          <!-- ORDERS -->
        <li>
            <a href="/orders">
              <i class='bx bx-cart'></i>
              <span class="link_name">Orders</span>
            </a>
            <ul class="sub-menu blank">
              <li><a class="link_name" href="/orders">Orders</a></li>
            </ul>
        </li>


      <!-- CATEGORY LIST -->
      <li>
          <a href="/categroy">
          <i class='bx bx-category-alt'></i>
              <span class="link_name">Category</span>
          </a>
          <ul class="sub-menu blank">
              <li><a class="link_name" href="/category">Category</a></li>
          </ul>
      </li>

        <!-- USER ACCOUNT -->
        <li>
      <a href="/user">
          <i class='bx bxs-user-account'></i>
          <span class="link_name">User Account</span>
      </a>
      <ul class="sub-menu blank">
          <li><a class="link_name" href="/user">User Account</a></li>
      </ul>
      </li>

       <!-- REPORTS  -->

      <li>
        <a href="#">
          <i class='bx bx-file'></i>
          <span class="link_name">Reports</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="#">Reports</a></li>
        </ul>
      </li>
      <li>
        <a href="#">
          <i class='bx bx-history'></i>
          <span class="link_name">History</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="#">History</a></li>
        </ul>
      </li>
      <li>
        <a href="/settings">
          <i class='bx bx-cog' ></i>
          <span class="link_name">Setting</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="/settings">Setting</a></li>
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
            <i class='bx bx-grid-alt' ></i>
            <span class="link_name">Dashboard</span>
          </a>
          <ul class="sub-menu blank">
            <li><a class="link_name" href="/customer/dashboard">Dashboard</a></li>
          </ul>
        </li>
        
        <li>
          <a href="/customer/cart">
            <i class='bx bx-cart'></i>
            <span class="link_name">Cart</span>
          </a>
          <ul class="sub-menu blank">
            <li><a class="link_name" href="/customer/cart">Cart</a></li>
          </ul>
        </li>
        
        <li>
          <a href="/customer/orders">
          <i class='bx bx-package'></i>

            <span class="link_name">Orders</span>
          </a>
          <ul class="sub-menu blank">
            <li><a class="link_name" href="/customer/orders">Orders</a></li>
          </ul>
        </li>

        <!-- USER ACCOUNT -->
        <li>
            <a href="customer/account">
                <i class='bx bxs-user-account'></i>
                <span class="link_name">User Account</span>
            </a>
            <ul class="sub-menu blank">
                <li><a class="link_name" href="customer/account">User Account</a></li>
            </ul>
        </li>
      </ul>


    <?php endif;?>
</div>

