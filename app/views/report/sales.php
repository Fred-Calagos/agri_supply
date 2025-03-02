<div class="p-3 border rounded bg-white mt-4">
<!-- Sales Report Table -->
<!-- Year Filter -->
<form method="GET" class="mb-3">
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <!-- Year Filter -->
        <label for="year" class="mb-0">Filter by Year:</label>
        <select name="year" id="year" class="form-control w-auto">
            <option value="">All Years</option>
            <?php
            $currentYear = date('Y');
            for ($year = $currentYear; $year >= $currentYear - 10; $year--) {
                $selected = (isset($_GET['year']) && $_GET['year'] == $year) ? 'selected' : '';
                echo "<option value=\"$year\" $selected>$year</option>";
            }
            ?>
        </select>

        <!-- Category Filter -->
        <label for="category" class="mb-0">Filter by Category:</label>
        <select name="category" id="category" class="form-control w-auto">
            <option value="">All Categories</option>
            <?php
            foreach ($productCategory as $category) {
                $selected = (isset($_GET['category']) && $_GET['category'] == $category['id']) ? 'selected' : '';
                echo "<option value=\"{$category['id']}\" $selected>{$category['product_category']}</option>";
            }
            ?>
        </select>

        <!-- Filter Button -->
        <button type="submit" class="btn btn-primary">Filter</button>

        <!-- Export to PDF -->
        <a href="/pdf/ProductSalesReport<?php echo '?' . http_build_query($_GET); ?>" target="_blank" class="btn btn-danger">
            Export PDF
        </a>

        <!-- Export to Excel -->
        <a href="/excel/ProductSalesReport<?php echo '?' . http_build_query($_GET); ?>" class="btn btn-success">
            Export Excel
        </a>
    </div>
</form>


<div id="salesReportTable">
<?php
$totalProducts = count($productSales);
$totalQuantity = 0;
$totalSales = 0;

foreach ($productSales as $item) {
    $totalQuantity += $item['total_quantity'];
    $totalSales += $item['total_sales'];
}
?>

<table class="table table-bordered">
    <thead class="thead-light">
        <tr>
            <th>No.</th>
            <th>Product Name</th>
            <th>Total Quantity Sold</th>
            <th>Total Sales</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($productSales as $index => $item): ?>
            <tr>
                <td><?= $index + 1 ?></td>
                <td><?= htmlspecialchars($item['product_name']) ?></td>
                <td><?= number_format($item['total_quantity']) ?></td>
                <td>₱<?= number_format($item['total_sales'], 2) ?></td>
            </tr>
        <?php endforeach; ?>
        <!-- Total row -->
        <tr class="font-weight-bold">
            <td colspan="1">TOTAL</td>
            <td><?= $totalProducts ?> Products</td>
            <td><?= number_format($totalQuantity) ?></td>
            <td>₱<?= number_format($totalSales, 2) ?></td>
        </tr>
    </tbody>
</table>

</div>
</div>

