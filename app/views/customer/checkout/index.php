<?php foreach ($cartItems as $item): ?>
            <div class="row">
                <div class="p-3 border-bottom bg-white">
                    <div class="row align-items-center">
                        <div class="col-5 col-sm-5 col-md-5 d-flex flex-column flex-md-row align-items-center justify-content-between text-center text-sm-start">
                            <!-- Product Name -->
                            <div class="w-100 mb-1 mb-md-0">
                                <p class="m-0"><?= htmlspecialchars($item['product_name']) ?></p>
                            </div>

                        </div>
                        
                            <!-- Quantity -->


                        <!-- Remove Button -->
                        <div class="col-2 col-sm-2 col-md-2 text-center">
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
