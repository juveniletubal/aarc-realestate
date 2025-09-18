<?php
define('BASE_URL', 'https://aarc-realestate.kesug.com/'); //online: https://aarc-realestate.kesug.com/       local: http://localhost/aarc-realestate/
define('ASSETS_URL', BASE_URL . 'assets');
define('ASSETS_PATH', rtrim($_SERVER['DOCUMENT_ROOT'], '/') . parse_url(BASE_URL, PHP_URL_PATH) . 'assets');

$assets = new AssetManager();
$page = new PageManager();

function loadCoreAssets($assets, $page_type = 'basic')
{
    if ($page_type !== 'landing_page') {
        // === GLOBAL CSS ===
        $assets->addCSS('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap', 1, ['preload' => true]);
        $assets->addCSS('css/app.min.css', 2);
        $assets->addCSS('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css', 3);

        // === GLOBAL JS ===
        $assets->addJS('js/app.min.js', 1, ['defer' => true]);
        $assets->addJS('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js', 2, ['defer' => true]);
    }

    include 'custom_script/page_load_time.php';

    switch ($page_type) {
        case 'dashboard':
            $assets->addCSS('css/datatables.bundle.min.css', 4);

            $assets->addJS('js/apexcharts.min.js', 3, ['defer' => true]);
            $assets->addJS('js/jquery.dataTables.bundle.min.js', 4, ['defer' => true]);
            $assets->addJS('js/dashboard3.js', 5, ['defer' => true]);
            break;

        case 'table':
            $assets->addCSS('css/datatables.bundle.min.css', 4);
            $assets->addCSS('https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css', 5);
            $assets->addCSS('https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css', 6);

            $assets->addJS('js/jquery.dataTables.bundle.min.js', 3, ['defer' => true]);
            $assets->addJS('https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js', 4, ['defer' => true]);
            $assets->addJS('https://cdn.jsdelivr.net/npm/sweetalert2@11', 5, ['defer' => true]);
            break;

        case 'form':
            break;

        case 'notifications':
            break;

        case 'login':
            break;

        case 'landing_page':
            $assets->addCSS('landing_page/css/app.min.css', 1);
            $assets->addJS('landing_page/js/app.min.js', 1);
            break;
    }
}
