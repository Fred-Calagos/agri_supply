
    <style>
        body { font-family: Arial, sans-serif; }
        .custom-card-link { text-decoration: none; color: inherit; display: block; }
        .custom-card {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            transition: 0.3s;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            cursor: pointer;
        }
        .custom-card:hover { background: #f4f4f4; transform: translateY(-3px); }
        .icon-box { font-size: 40px; color: #007bff; }
        .card-number { font-size: 24px; font-weight: bold; }
        .label { font-size: 16px; color: #6c757d; }
    </style>
<div class="container mt-4">
    <div class="row text-center">
        <div class="col-md-4">
            <div class="custom-card">
                <i class="bx bx-dollar-circle icon-box"></i>
                <span class="card-number">₱ <?= number_format($monthSales) ?> </span>
                <span class="label">Sales Month</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="custom-card">
                <i class="bx bx-line-chart icon-box"></i>
                <span class="card-number">₱ <?= number_format($monthSales) ?></span>
                <span class="label">Yearly Revenue</span>
            </div>
        </div>
        <div class="col-md-4">
            <div class="custom-card">
                <i class="bx bx-cart icon-box"></i>
                <span class="card-number"><?= $pendingOrders ?></span>
                <span class="label">Orders</span>
            </div>
        </div>

    </div>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card p-3 shadow">
                <h5>Orders Overview</h5>
                <div id="ordersChart"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 shadow">
                <h5>Revenue Trend</h5>
                <div id="revenueChart"></div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card p-3 shadow">
                <h5>Best-Selling Products</h5>
                <div id="bestSellingChart"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card p-3 shadow">
                <h5>Low Stock Alerts</h5>
                <table class="table table-bordered">
                    <thead><tr><th>Product</th><th>Stock Left</th></tr></thead>
                    <tbody>
                        <?php foreach ($lowStockProducts as $product): ?>
                            <tr><td><?= $product['name'] ?></td><td class="text-danger"><?= $product['stock'] ?></td></tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    var ordersChart = new ApexCharts(document.querySelector("#ordersChart"), {
        chart: { type: 'donut' },
        series: [<?= $pendingOrders ?>, <?= $completedOrders ?>],
        labels: ['Pending', 'Completed'],
        colors: ['#ff9800', '#4caf50']
    });
    ordersChart.render();
    
    var revenueChart = new ApexCharts(document.querySelector("#revenueChart"), {
        chart: { type: 'line' },
        series: [{ name: 'Revenue', data: <?= json_encode($revenueData) ?> }],
        xaxis: { categories: <?= json_encode($months) ?> }
    });
    revenueChart.render();
    
    var bestSellingChart = new ApexCharts(document.querySelector("#bestSellingChart"), {
        chart: { type: 'bar' },
        series: [{ name: 'Sales', data: <?= json_encode($bestSellingData) ?> }],
        xaxis: { categories: <?= json_encode($bestSellingProducts) ?> }
    });
    bestSellingChart.render();
</script>