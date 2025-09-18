<?php
define('BASE_URL', 'https://aarc-realestate.kesug.com/');
define('ASSETS_URL', BASE_URL . 'assets');
define('ASSETS_PATH', rtrim($_SERVER['DOCUMENT_ROOT'], '/') . parse_url(BASE_URL, PHP_URL_PATH) . 'assets');

$assets = new AssetManager();
$page = new PageManager();

function loadCoreAssets($assets, $page_type = 'basic')
{
    // Load only when NOT landing_page
    if ($page_type !== 'landing_page') {
        // === GLOBAL CSS ===
        $assets->addCSS('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap', 1);
        $assets->addCSS('css/core.min.css', 2);
        $assets->addCSS('css/icon-font.min.css', 3);
        $assets->addCSS('css/style.min.css', 4);
        $assets->addCSS('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css', 5);

        // === GLOBAL JS ===
        // Core scripts needed for template
        $assets->addJS('js/core.min.js', 1);
        $assets->addJS('js/script.min.js', 2);
        $assets->addJS('js/process.min.js', 3);
        $assets->addJS('js/layout-settings.min.js', 4);

        // Toastr JS for notifications (non-blocking)
        $assets->addJS('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js', 5, ['defer' => true]);
    }

    include 'custom_script/page_load_time.php';

    // Conditional loading based on page type
    switch ($page_type) {
        case 'dashboard':
            // DataTables CSS (only if dashboard uses tables)
            $assets->addCSS('css/dataTables.bootstrap4.min.css', 6);
            $assets->addCSS('css/responsive.bootstrap4.min.css', 7);

            // Charts library
            $assets->addJS('js/apexcharts.min.js', 6, ['defer' => true]);

            // DataTables JS
            $assets->addJS('js/jquery.dataTables.min.js', 7, ['defer' => true]);
            $assets->addJS('js/dataTables.bootstrap4.min.js', 8, ['defer' => true]);
            $assets->addJS('js/dataTables.responsive.min.js', 9, ['defer' => true]);
            $assets->addJS('js/responsive.bootstrap4.min.js', 10, ['defer' => true]);

            // Dashboard initialization scripts
            $assets->addJS('js/dashboard3.js', 11, ['defer' => true]);
            break;

        case 'table':
            // DataTables CSS
            $assets->addCSS('css/dataTables.bootstrap4.min.css', 6);
            $assets->addCSS('css/responsive.bootstrap4.min.css', 7);

            // Dropzone CSS for image uploads
            $assets->addCSS('https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css', 8);
            $assets->addCSS('https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css', 9);

            // DataTables JS
            $assets->addJS('js/jquery.dataTables.min.js', 6, ['defer' => true]);
            $assets->addJS('js/dataTables.bootstrap4.min.js', 7, ['defer' => true]);
            $assets->addJS('js/dataTables.responsive.min.js', 8, ['defer' => true]);
            $assets->addJS('js/responsive.bootstrap4.min.js', 9, ['defer' => true]);

            // Dropzone JS (non-blocking)
            $assets->addJS('https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js', 10, ['defer' => true]);
            $assets->addJS('https://cdn.jsdelivr.net/npm/sweetalert2@11', 11, ['defer' => true]);
            break;

        case 'form':
            // form assets
            break;

        case 'notifications':
            // notifications assets
            break;

        case 'login':
            break;

        case 'landing_page':
            $assets->addCSS('landing_page/css/app.min.css', 1);
            $assets->addJS('landing_page/js/app.min.js', 1);
            break;
    }
}









// define('BASE_URL', 'http://localhost/aarc-realestate/');
// define('ASSETS_URL', BASE_URL . 'assets');
// define('ASSETS_PATH', rtrim($_SERVER['DOCUMENT_ROOT'], '/') . parse_url(BASE_URL, PHP_URL_PATH) . 'assets');

// $assets = new AssetManager();
// $page = new PageManager();

// function loadCoreAssets($assets, $page_type = 'basic')
// {
//     // Load only when NOT landing_page
//     if ($page_type !== 'landing_page') {
//         // Fonts
//         $assets->addCSS('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap', 1);

//         // Core template CSS
//         $assets->addCSS('css/core.min.css', 2);
//         $assets->addCSS('css/icon-font.min.css', 3);
//         $assets->addCSS('css/style.min.css', 4);

//         // Toastr for notifications
//         $assets->addCSS('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css', 5);

//         // Core JS
//         $assets->addJS('js/core.min.js', 1);
//         $assets->addJS('js/script.min.js', 2);
//         $assets->addJS('js/process.min.js', 3);
//         $assets->addJS('js/layout-settings.min.js', 4);

//         // Toastr JS
//         $assets->addJS('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js', 5);
//     }

//     include 'custom_script/page_load_time.php';

//     // Conditional loading based on page type
//     switch ($page_type) {
//         case 'dashboard':
//             // DataTables CSS (optional if dashboard tables exist)
//             $assets->addCSS('css/dataTables.bootstrap4.min.css', 6);
//             $assets->addCSS('css/responsive.bootstrap4.min.css', 7);

//             // Charts
//             $assets->addJS('js/apexcharts.min.js', 6);

//             // DataTables JS (if you have tables in dashboard)
//             $assets->addJS('js/jquery.dataTables.min.js', 7);
//             $assets->addJS('js/dataTables.bootstrap4.min.js', 8);
//             $assets->addJS('js/dataTables.responsive.min.js', 9);
//             $assets->addJS('js/responsive.bootstrap4.min.js', 10);

//             // Dashboard-specific scripts
//             $assets->addJS('js/dashboard3.js', 11);
//             break;

//         case 'table':
//             // DataTables CSS
//             $assets->addCSS('css/dataTables.bootstrap4.min.css', 6);
//             $assets->addCSS('css/responsive.bootstrap4.min.css', 7);

//             // Dropzone CSS
//             $assets->addCSS('https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.css', 8);

//             // DataTables JS
//             $assets->addJS('js/jquery.dataTables.min.js', 6);
//             $assets->addJS('js/dataTables.bootstrap4.min.js', 7);
//             $assets->addJS('js/dataTables.responsive.min.js', 8);
//             $assets->addJS('js/responsive.bootstrap4.min.js', 9);

//             // Dropzone JS
//             $assets->addJS('https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js', 10);
//             break;

//         case 'form':
//             // form assets
//             break;

//         case 'notifications':
//             // notifications assets
//             break;

//         case 'login':
//             break;

//         case 'landing_page':
//             $assets->addCSS('landing_page/css/app.min.css', 1);
//             $assets->addJS('landing_page/js/app.min.js', 1);
//             break;
//     }
// }
