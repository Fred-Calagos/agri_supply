<div class="p-3 border rounded bg-white mt-4">
    <table class="table table-bordered">
        <thead class="thead-light">
            <tr>
                <th>Order Track</th>
                <th>User</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $item): ?>
                <tr>
                
                    <td><?= htmlspecialchars($item['order_track']) ?></td>
                    <td><?= htmlspecialchars($item['full_name']) ?></td>
                    <td><?= htmlspecialchars($item['order_statuses']) ?></td>
                    <td>
                            <!-- View Button -->
                            <a href="/orders/order_details?track_order=<?= urlencode($item['order_track']); ?>" class="btn btn-success" title="View">  
                                <i class='bx bx-show'></i>
                            </a>

                    <!-- Delete Button -->
                    <a href="delete_order.php?id=<?= $item['order_track']; ?>" class="btn btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this order?');">
                        <i class='bx bx-trash'></i>
                    </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
