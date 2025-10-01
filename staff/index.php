<?php
require_once __DIR__ . '/../includes/init.php';

$page->setTitle('AARC - Dashboard');
$page->setCurrentPage('dashboard');
$page->addBreadcrumb('Dashboard', 'index');
$page->addBreadcrumb('Dashboard');

loadCoreAssets($assets, 'dashboard');

$welcomeMessage = "";
if (isset($_SESSION['welcome_message'])) {
    $welcomeMessage = $_SESSION['welcome_message'];
    unset($_SESSION['welcome_message']);
}

include __DIR__ . '/../includes/header.php';
?>

<?php
include __DIR__ . '/../includes/navbar.php';
include __DIR__ . '/../includes/sidebar.php';
?>

<div class="main-container">
    <div class="xs-pd-20-10 pd-ltr-20">

        <div class="card-box pd-20 height-30-p mb-30">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <img src="../assets/images/banner-img.png" alt="" />
                </div>
                <div class="col-md-10">
                    <h4 class="font-20 weight-500 mb-10 text-capitalize" data-color="#265ED7">
                        Announcement <i class="fa fa-bullhorn"></i>
                    </h4>
                    <p class="font-18 text-break">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. UndeascccccccccccccccccccccccccascaCaCsa
                        hic non repellendus debitis iure, doloremque assumenda.ascasccccccccccccccccccccccccccccccc
                    </p>
                </div>
            </div>
        </div>



    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        <?php if (!empty($welcomeMessage)) : ?>
            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: "toast-bottom-right",
                timeOut: "8000"
            };

            toastr.success("<?php echo $welcomeMessage; ?>");
        <?php endif; ?>
    });
</script>