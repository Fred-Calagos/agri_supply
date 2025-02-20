<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ?? 'Default Title'; ?></title>


</head>
<body>

    <?php include_once __DIR__ . '/header.php'; ?>
    <?php include_once __DIR__ . '/sidebar.php'; ?>

    <section class="home-section">
    <div class="home-content">
        <nav class="container-fluid d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <i class='bx bx-menu' id="sidebar-toggle"></i>
                <span class="text main-title ms-2"><?php echo $title ?? 'Dashboard'; ?></span>
            </div>
            <div class="dropdown">
                <a href="#" class="d-block link-dark text-decoration-none " id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="" alt="user" width="40" height="40" class="rounded-circle">
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownUser1">
                    <li><a class="dropdown-item" href="#"><i class='bx bxs-user-circle'></i> My Accounts</a></li>
                    <li><a class="dropdown-item" href="#"><i class='bx bx-history'></i> Logs</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="/logout"><i class='bx bx-log-out-circle'></i> Logout</a></li>
                </ul>
            </div>
        </nav>
</div>

        <div class="content">
            <?php echo $content ?? ''; ?>
        </div>
    </section>

    <?php include_once __DIR__ . '/footer.php'; ?>



</body>
</html>
