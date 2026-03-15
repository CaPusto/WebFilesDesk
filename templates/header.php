<?php
// templates/header.php — page header
?>
<!DOCTYPE html>
<html lang="<?= htmlspecialchars($L['_meta']['lang'] ?? 'en') ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= htmlspecialchars($config['title'] ?? $L['app']['title']) ?> — <?= htmlspecialchars(basename($currentFull ?? '')) ?></title>
    <link rel="icon" type="image/png" href="includes/favicon.png">
    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles + dark theme CSS variables -->
    <link href="includes/styles.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="fontawesome/css/all.min.css" rel="stylesheet">
    <!-- Translations for JS -->
    <script>const Lang = <?= json_encode($L, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;</script>
    <!-- Apply theme BEFORE page render — prevents flash of unstyled content -->
    <script>
    (function() {
        var theme = localStorage.getItem('fm_theme');
        if (theme === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
        }
    })();
    </script>
</head>
<body class="bg-light" <?php if (!empty($config['background'])): ?>
    style="background: url('<?= htmlspecialchars($config['background']) ?>'); background-size: cover;"
<?php endif; ?>>
<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">
            <i class="fa-solid fa-folder-tree me-2 text-primary"></i>
            <?= htmlspecialchars($config['title'] ?? $L['app']['title_full']) ?>
        </h2>
        <!-- Light / dark theme toggle button -->
        <button id="btn-theme-toggle" title="<?= htmlspecialchars($L['theme']['dark']) ?>" aria-label="<?= htmlspecialchars($L['theme']['dark']) ?>">
            <i id="theme-icon" class="fa-solid fa-moon"></i>
        </button>
    </div>
<?php
/**
 * DISPLAY NOTIFICATIONS
 */
if (!empty($config['filter_error'])) {
    $msgText  = $config['filter_error'];
    $msgType  = 'warning';
    $msgTitle = $L['messages']['attention'];
    include __DIR__ . '/messages.php';
}
?>
<script>
(function() {
    var btn  = document.getElementById('btn-theme-toggle');
    var icon = document.getElementById('theme-icon');
    function applyTheme(theme) {
        if (theme === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
            icon.className = 'fa-solid fa-sun';
            btn.title = Lang.theme.light;
        } else {
            document.documentElement.removeAttribute('data-theme');
            icon.className = 'fa-solid fa-moon';
            btn.title = Lang.theme.dark;
        }
    }
    applyTheme(localStorage.getItem('fm_theme') || 'light');
    btn.addEventListener('click', function() {
        var current = localStorage.getItem('fm_theme') || 'light';
        var next = current === 'dark' ? 'light' : 'dark';
        localStorage.setItem('fm_theme', next);
        applyTheme(next);
    });
})();
</script>