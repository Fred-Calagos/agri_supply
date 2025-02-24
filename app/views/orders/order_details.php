
<div class="container-fluid bg-dark-50 mt-3 p-3">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item">
                    <a href="/orders"><i class='bx bx-store-alt bread-icon'></i> Orders</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Update Orders</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container-fluid bg-white mt-2 p-3 shadow rounded">
    <div class="row g-3 align-items-center">
        <!-- Order Track Number -->
        <div class="col-lg-6 col-md-4 fw-bold text-primary">
            Order Track #: <?= htmlspecialchars($orderTrackNumber) ?>
        </div>

        <!-- Form Section -->
        <div class="col-lg-6 col-md-8">
            <form action="/orders/updateOrderStatus" method="POST">
                <input type="hidden" name="order_track" value="<?= htmlspecialchars($orderTrackNumber) ?>">

                <div class="input-group">
                    <select name="order_status" class="form-control">
                        <?php 
                            $firstOrder = !empty($orderTracks) ? $orderTracks[0] : null; 
                        ?>
                        <?php foreach ($orderStatus as $orderStat): ?>
                            <option value="<?= htmlspecialchars($orderStat['id']) ?>" 
                                <?= ($firstOrder && $orderStat['id'] == $firstOrder['poStat']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($orderStat['order_status']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-plus-circle me-1"></i> Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="p-3 border rounded bg-white mt-4">
    <div class="d-flex gap-2 mb-2">
        <button class="btn btn-secondary" onclick="printTable()">
            <i class='bx bxs-printer'></i> Print
        </button>
        <button class="btn btn-danger" 
                onclick="window.location.href='/pdf/generateOrderPdf?track=<?= urlencode($orderTrackNumber) ?>'">
            <i class='bx bxs-file-pdf'></i> DOWNLOAD PDF
        </button>
        <button class="btn btn-danger" 
                onclick="window.location.href='/pdf/viewPdfReport?track=<?= urlencode($orderTrackNumber) ?>'">
            <i class='bx bxs-file-pdf'></i> VIEW PDF
        </button>

        <button class="btn btn-success" onclick="window.location.href='/excel/generateOrderExcel'">
            <i class='bx bxs-file-export'></i> EXCEL
        </button>
    </div>

    <div id="orderTable">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Product Name</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orderTracks as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['product_name']) ?></td>
                        <td>₱ <?= number_format($item['selling_price'], 2) ?></td>
                        <td><?= htmlspecialchars($item['product_quantity']) ?></td>
                        <td>₱ <?= number_format($item['selling_price'] * $item['product_quantity'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
function printTable() {
    var printContents = document.getElementById("orderTable").innerHTML;
    var originalContents = document.body.innerHTML;

    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>
