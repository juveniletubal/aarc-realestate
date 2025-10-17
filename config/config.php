<?php
define('BASE_URL', 'http://localhost/aarc-realestate/'); //online: https://aarc-realestate.kesug.com/       local: http://localhost/aarc-realestate/
define('ASSETS_URL', BASE_URL . 'assets');
define('ASSETS_PATH', rtrim($_SERVER['DOCUMENT_ROOT'], '/') . parse_url(BASE_URL, PHP_URL_PATH) . 'assets');

function loadCoreAssets($assets, $page_type = 'basic')
{
    if ($page_type !== 'landing_page') {
        // === GLOBAL CSS ===
        $assets->addCSS('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap', 1, ['preload' => true]);
        $assets->addCSS('css/app.min.css', 2);

        // === GLOBAL JS ===
        $assets->addJS('js/app.min.js', 1, ['defer' => true]);
    }

    include 'custom_script/page_load_time.php';

    switch ($page_type) {
        case 'dashboard':
            $assets->addCSS('css/datatables.bundle.min.css', 3);

            // $assets->addJS('js/apexcharts.min.js', 2, ['defer' => true]);
            $assets->addJS('js/jquery.dataTables.bundle.min.js', 2, ['defer' => true]);
            // $assets->addJS('js/dashboard3.js', 3, ['defer' => true]);
            break;
        case 'client_dashboard':
            $assets->addCSS('css/datatables.bundle.min.css', 3);

            $assets->addJS('js/jquery.dataTables.bundle.min.js', 2, ['defer' => true]);
            // $assets->addJS('js/apexcharts.min.js', 3, ['defer' => true]);
            // $assets->addJS('js/dashboard.js', 4, ['defer' => true]);
            break;

        case 'table_form_dropzone':
            $assets->addCSS('css/datatables.bundle.min.css', 3);
            $assets->addCSS('https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css', 4);

            $assets->addJS('js/jquery.dataTables.bundle.min.js', 2, ['defer' => true]);
            $assets->addJS('https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js', 3, ['defer' => true]);
            // $assets->addJS('https://cdn.jsdelivr.net/npm/cleave.js@1/dist/cleave.min.js', 4, ['defer' => true]);
            break;

        case 'table_form':
            $assets->addCSS('css/datatables.bundle.min.css', 3);

            $assets->addJS('js/jquery.dataTables.bundle.min.js', 2, ['defer' => true]);
            break;

        case 'client_table_form':
            $assets->addCSS('css/datatables.bundle.min.css', 3);

            $assets->addJS('js/jquery.dataTables.bundle.min.js', 2, ['defer' => true]);
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
