<?php
require_once __DIR__ . '/../../Core/Database.php';

use App\Core\Database;

// Connect to the database
$pdo = Database::connect();

// Fetch brands from the database
$stmt = $pdo->query("SELECT * FROM brands");
$brands = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/login.css" rel="stylesheet">
</head>
<body>
<div class="container prod-details p-2 text-center">
    <?php if (!empty($brands)): ?>
        <?php foreach ($brands as $brand): ?>
            <div class="row p-3 d-flex align-items-center">
                <!-- Logo Column -->
                <div class="col-md-6 d-flex justify-content-center">
                    <img src="<?= htmlspecialchars($brand['brand_logo']); ?>" 
                        alt="<?= htmlspecialchars($brand['brand_name']); ?>" 
                        class="img-fluid rounded login-logo" 
                        style="max-width: 200px; height: auto;">
                </div>

                <!-- Brand Info Column -->
                <div class="col-md-6 text-center text-md-start mt-5">
                    <div class="row">
                    <h2 class="mt-3 brand-name"><?= htmlspecialchars($brand['brand_name']) ?? 'Brand Name'; ?></h2>
                    </div>
                    <div class="row mt-5">
                        <p><i><q><?= htmlspecialchars($brand['tagline']) ?? 'Brand Tagline'; ?></q></i></p>
                    </div>
                    
                </div>
            </div>

            <div class="row p-3">
            <h3 style="text-align: left;">About</h3>
            <p class="text-about"><?= htmlspecialchars($brand['about']) ?? 'brand tagline'; ?></p>
            </div>
           
           
        <?php endforeach; ?>
    <?php else: ?>
        <p>No brands available.</p>
    <?php endif; ?>
</div>


    <div class="container login-container p-4">
        <div class="row g-0">
            <div class="col-md-12 p-4">
                <h3 class="text-center mb-3">Login</h3>
                <?php if (isset($_SESSION['error'])): ?>
                    <p class="text-danger text-center"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                <?php endif; ?>
                <form action="/login" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-success w-100 btn-login">Login</button>
                </form>
                <div class="text-center mt-3">
                    <small>Don't have an account? <a href="/register">Sign up</a></small>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
