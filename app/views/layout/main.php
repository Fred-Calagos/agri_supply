<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ?? 'Default Title'; ?></title>


</head>
<body>

    <?php include_once __DIR__ . '/header.php'; ?>
    <?php include_once __DIR__ . '/sidebar.php'; ?>

    <section class="home-section">
    <?php if (isAdmin()): ?>
        <div class="home-content">
            <nav class="container-fluid d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class='bx bx-menu' id="sidebar-toggle"></i>
                    <span class="text main-title ms-2"><?php echo $title ?? 'Dashboard'; ?></span>
                </div>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center justify-content-center border rounded-circle bg-light p-2"
                    style="height: 40px; width: 40px;" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-user fs-4 text-dark"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm mt-2" aria-labelledby="dropdownUser1">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="#">
                                <i class='bx bxs-user-circle fs-5 text-primary'></i> My Account
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="#">
                                <i class='bx bx-history fs-5 text-secondary'></i> Logs
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="/settings">
                                <i class='bx bx-cog fs-5 text-secondary'></i> Settings
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="/logout">
                                <i class='bx bx-log-out-circle fs-5'></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>

            </nav>
        </div>
    <?php endif;?>
    <?php if (isUser()): ?>
        <div class="home-content">
            <nav class="container-fluid d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <i class='bx bx-menu' id="sidebar-toggle"></i>
                    <span class="text main-title ms-2"><?php echo $title ?? 'Dashboard'; ?></span>
                </div>
                <div class="dropdown">
                    <a href="" class="d-flex align-items-center justify-content-center border rounded-circle bg-light p-2"
                    style="height: 40px; width: 40px;" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bx bx-user fs-4 text-dark"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm mt-2" aria-labelledby="dropdownUser1">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="/customer/account">
                                <i class='bx bxs-user-circle fs-5 text-primary'></i> My Account
                            </a>
                        </li>
                        <!-- <li>
                            <a class="dropdown-item d-flex align-items-center gap-2" href="#">
                                <i class='bx bx-history fs-5 text-secondary'></i> Logs
                            </a>
                        </li> -->
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 text-danger" href="/logout">
                                <i class='bx bx-log-out-circle fs-5'></i> Logout
                            </a>
                        </li>
                    </ul>
                </div>

            </nav>
        </div>
    <?php endif;?>

        <div class="content main-content">
            <?php echo $content ?? ''; ?>
        </div>
    </section>

    <?php include_once __DIR__ . '/footer.php'; ?>



</body>
</html>
