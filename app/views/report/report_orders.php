<?php

use App\Core\Database;
// Fetch categories for dropdown
$pdo = Database::connect();
$categories = $pdo->query("SELECT id, product_category FROM product_category")->fetchAll(PDO::FETCH_ASSOC);

// Get filter values from the request
$selectedCategory = $_GET['category'] ?? '';
$selectedDate = $_GET['date'] ?? '';

// Modify the query based on filters
$sql = "SELECT po.*, 
                p.product_name, p.image_path, p.shipping_fee, p.stocks, p.product_description, p.selling_price, p.cost_price, p.profit_margin,
                pc.product_category,
                os.order_status
                FROM product_ordered po
                JOIN products p ON po.product_id = p.id
                JOIN product_category pc ON p.product_category_id = pc.id
                JOIN order_status os ON po.order_status = os.id
        WHERE 1 = 1"; // Always true condition for dynamic filtering

// Apply filters
$params = [];
if ($selectedCategory) {
    $sql .= " AND pc.id = ?";
    $params[] = $selectedCategory;
}

if ($selectedDate) {
    $sql .= " AND YEAR(po.ordered_date) = ? AND MONTH(po.ordered_date) = ?";
    [$year, $month] = explode('-', $selectedDate); // Extract year and month
    $params[] = $year;
    $params[] = $month;
}


$sql .= " ORDER BY po.ordered_date ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$orderReport = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container-fluid bg-dark-50 mt-3 p-3">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/report"><i class='bx bx-store-alt bread-icon'></i> Report</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Update Orders</li>
            </ol>
        </nav>
    </div>
</div>

<div class="p-3 border rounded bg-white mt-4">
    <!-- Filters -->
    <form method="GET" class="d-flex gap-2 mb-3">
        <select name="category" class="form-select form-select-sm" style="max-width: 200px;">
            <option value="">All Categories</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>" <?= ($selectedCategory == $category['id']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category['product_category']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <input type="month" name="date" class="form-control form-control-sm" style="max-width: 200px;" value="<?= $selectedDate ?>">

        <button type="submit" class="btn btn-primary btn-sm">Filter</button>
        <a href="/report-orders" class="btn btn-secondary btn-sm">Reset</a>
    </form>

    <!-- Export Buttons -->
    <div class="d-flex gap-2 mb-2"> 
        <button class="btn btn-danger btn-sm" onclick="window.location.href='/pdf/generateOrderPdf?track='">
            <i class='bx bxs-file-pdf'></i> DOWNLOAD PDF
        </button>
        <button class="btn btn-danger btn-sm" onclick="window.location.href='/pdf/viewPdfReport?track='">
            <i class='bx bxs-file-pdf'></i> Print
        </button>
        <button class="btn btn-success btn-sm" onclick="exportExcel()">
    <i class='bx bxs-file-export'></i> EXCEL
</button>

<script>
function exportExcel() {
    let category = document.querySelector('[name="category"]').value;
    let date = document.querySelector('[name="date"]').value;
    window.location.href = `/pdf/generateExcel?category=${category}&date=${date}`;
}
</script>

    </div>

    <!-- Order Table -->
    <div id="orderTable">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>No.</th>
                    <th>Track Number</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Cost Price</th>
                    <th>Profit Margin</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Profit</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
            <tbody>
                <?php foreach ($orderReport as $index => $item): 
                    $profit = ($item['selling_price'] - $item['cost_price']) * $item['product_quantity'];
                ?>
                    <tr>
                        <td> <?= $index + 1 ?></td>
                        <td> <?= htmlspecialchars($item['order_track']) ?></td>
                        <td> <?= htmlspecialchars($item['product_name']) ?></td>    
                        <td> <?= htmlspecialchars($item['product_category']) ?></td>
                        <td> ₱<?= number_format($item['cost_price'], 2) ?></td>
                        <td><?= number_format($item['profit_margin']) ?>%</td>
                        <td> ₱<?= number_format($item['selling_price'], 2) ?></td>
                        <td> <?= htmlspecialchars($item['product_quantity']) ?></td>
                        <td> ₱<?= number_format($item['selling_price'] * $item['product_quantity'], 2) ?></td>
                        <td> ₱<?= number_format($profit, 2) ?></td> <!-- Display Profit -->
                        <td> <?= htmlspecialchars($item['order_status']) ?></td>
                        <td> <?= date('F j, Y', strtotime($item['ordered_date'])) ?></td>
                    </tr>
                <?php endforeach; ?>
</tbody>

            </tbody>
        </table>
    </div>
</div>
