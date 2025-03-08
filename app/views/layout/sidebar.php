<div class="sidebar close">
  <?php if (isAdmin()): ?>
    <div class="logo-details">
      <img src="/uploads/store_logo.png" alt="Store Logo" style="height: 40px; margin-right: 10px;">
      <span class="logo_name">Your Store Name</span>
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
        <div class="iocn-link">
          <a href="#">
            <i class='bx bx-box'></i>
            <span class="link_name">Products</span>
          </a>
          <i class='bx bxs-chevron-down arrow'></i>
        </div>
        <ul class="sub-menu">
          <li><a class="link_name" href="/products">Products</a></li>
          <li><a href="/products/create">Add New Product</a></li>
          <li><a href="/product_category">Product Category</a></li>
          <li><a href="/product/varieties">Varieties</a></li>
          <li><a href="/product/specifications">Specifications</a></li> 
          <li><a href="/product/stock-units">Stock Units</a></li>
          <li><a href="/product/batches">Batches</a></li>
          <li><a href="/product/inventory-adjustments">Inventory Adjustment</a></li>
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
          <a href="/category">
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
        <a href="/report">
          <i class='bx bx-file'></i>
          <span class="link_name">Reports</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="/report">Reports</a></li>
        </ul>
      </li>
      <!-- <li>
        <a href="#">
          <i class='bx bx-history'></i>
          <span class="link_name">History</span>
        </a>
        <ul class="sub-menu blank">
          <li><a class="link_name" href="#">History</a></li>
        </ul>
      </li> -->
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
          <i class='bx bx-home-alt'></i>
            <span class="link_name">Dashboard</span>
          </a>
          <ul class="sub-menu blank">
            <li><a class="link_name" href="/customer/dashboard">Dashboard</a></li>
          </ul>
        </li>
        
        <li>
          <a href="/customer/viewCategory">
          <i class="bx bx-category"></i>
            <span class="link_name">Category</span>
          </a>
          <ul class="sub-menu blank">
            <li><a class="link_name" href="/customer/viewCategory">Category</a></li>
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

      </ul>


    <?php endif;?>
</div>

