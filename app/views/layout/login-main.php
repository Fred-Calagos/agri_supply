<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'My App' ?></title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/login.css" rel="stylesheet">
    <link href="/css/boxicons.min.css" rel="stylesheet">
    <link href="/css/register.css" rel="stylesheet">
    <script src="/js/jquery-3.6.0.min.js"></script>
</head>
<body>
        <?= $content ?? '' ?>

        <script src="/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script type="module" src="/js/main.js"></script>
</body>
</html>
