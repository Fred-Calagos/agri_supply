
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
<div class="container prod-details p-4">
    <img src="path_to_product_image.jpg" alt="Product Image" class="img-fluid rounded">
    <h2 class="mt-3">Product Tagline</h2>
    <p class="text">This is a short description about the product, highlighting its key features and benefits.</p>
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
