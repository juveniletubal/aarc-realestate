<?php
define('BASE_URL', 'https://aarc-realestate.kesug.com/');
define('ASSETS_URL', BASE_URL . '/assets');

$assets = new AssetManager();
$page = new PageManager();

function loadCoreAssets($assets, $page_type = 'basic')
{
    // Load only when NOT landing_page
    if ($page_type !== 'landing_page') {
        $assets->addCSS('assets/css/fonts.min.css', 1);
        $assets->addCSS('assets/css/font-awesome.min.css', 2);
        $assets->addCSS('assets/css/core.min.css', 3);
        $assets->addCSS('assets/css/style.min.css', 4);

        $assets->addJS('assets/js/core.min.js', 1);
        $assets->addJS('assets/js/script.min.js', 2);
        $assets->addJS('assets/js/process.min.js', 3);
        $assets->addJS('assets/js/layout-settings.min.js', 4);
    }

    include 'custom_script/page_load_time.php';

    // Conditional loading based on page type
    switch ($page_type) {
        case 'dashboard':
            // dashboard assets
            break;

        case 'table':
            // table assets
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
            $assets->addCSS('assets/landing_page/css/app.min.css', 1);
            $assets->addJS('assets/landing_page/js/app.min.js', 1);
            break;
    }
}
