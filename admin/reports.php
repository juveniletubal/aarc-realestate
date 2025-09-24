<?php
require_once __DIR__ . '/../includes/init.php';

$page->setTitle('AARC - Reports');
$page->setCurrentPage('reports');

loadCoreAssets($assets, 'dashboard');

include __DIR__ . '/../includes/header.php';
?>

<?php
include __DIR__ . '/../includes/navbar.php';
include __DIR__ . '/../includes/sidebar.php';
?>

<div class="main-container">
    <div class="xs-pd-20-10 pd-ltr-20">
        <div class="title pb-20">
            <h2 class="h3 mb-0">Under Develop</h2>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>