<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo $page->getTitle(); ?></title>

    <link href="../assets/img/favicon.webp" rel="icon" />

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />

    <?php $assets->renderCSS(); ?>

</head>

<body>

    <?php include_once 'user_update/modal.php'; ?>