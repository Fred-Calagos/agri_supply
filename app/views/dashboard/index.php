
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .custom-card-link {
            text-decoration: none; /* Removes default link underline */
            color: inherit; /* Keeps text color unchanged */
            display: block; /* Makes the whole card clickable */
        }
        .custom-card {
            background:rgb(255, 255, 255);
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: 0.3s ease-in-out;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.5);
            cursor: pointer;
        }
        .custom-card:hover {
            background:rgb(244, 244, 244);
            transform: translateY(-3px);
        }
        .icon-box {
            font-size: 40px;
            color: #007bff;
        }
        .card-number {
            font-size: 24px;
            font-weight: bold;
        }
        .label {
            font-size: 16px;
            color: #6c757d;
        }
    </style>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-3 col-sm-12 mt-3">
            <a href="/products" class="custom-card-link">
                <div class="custom-card">
                    <i class="bx bx-box icon-box"></i>
                    <div class="text-box">
                        <?php if (isset($products) && $products > 0): ?>
                        <span class="card-number"><?= $products ?></span>
                        <?php else: ?>
                            <span class="card-number">0</span>
                        <?php endif; ?>
                        <span class="label">Total Products</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-md-3 col-sm-12 mt-3">
            <a href="/user" class="custom-card-link">
                <div class="custom-card">
                    <i class="bx bx-user icon-box"></i>
                    <div class="text-box">
                    <?php if (isset($user) && $user > 0): ?>
                        <span class="card-number"> <?= $user ?></span>
                        <?php else: ?>
                            <span class="card-number">0</span>
                        <?php endif; ?>
                        <span class="label">User</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-md-3 col-sm-12 mt-3">
            <a href="/orders" class="custom-card-link">
                <div class="custom-card">
                    <i class="bx bx-cart icon-box"></i>
                    <div class="text-box">
                        <?php if (isset($orders) && $orders > 0): ?>
                        <span class="card-number"><?= $orders ?></span>
                        <?php else: ?>
                            <span class="card-number">0</span>
                        <?php endif; ?>
                        <span class="label">Orders</span>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-12 col-md-3 col-sm-12 mt-3">
            <a href="/report" class="custom-card-link">
                <div class="custom-card">
                    <i class="bx bx-file icon-box"></i>
                    <div class="text-box">
                        <span class="label">Report</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<div class="container mt-4">
<div id="salesChart"></div>
<script>
    var options = {
        chart: {
            type: 'bar',
            height: 350
        },
        series: [{
            name: 'Sales',
            data: [15000, 20000, 18000, 22000]
        }],
        xaxis: {
            categories: ['January', 'February', 'March', 'April']
        }
    };

    var chart = new ApexCharts(document.querySelector("#salesChart"), options);
    chart.render();
</script>
</div>

