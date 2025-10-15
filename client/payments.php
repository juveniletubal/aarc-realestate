<?php
require_once __DIR__ . '/../includes/init.php';

$page->setTitle('AARC - Payments');
$page->setCurrentPage('payments');

loadCoreAssets($assets, 'table_form');

include __DIR__ . '/../includes/header.php';
?>

<?php
include __DIR__ . '/../includes/navbar.php';
include __DIR__ . '/../includes/sidebar.php';
?>

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">

            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>List of Payments</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active text-success" aria-current="page">
                                    Payments
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="card-box">
                <div class="pb-20 pt-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>Amount Paid</th>
                                <th>Payment Date</th>
                                <th>Updated</th>
                                <th>Assigned Staff</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<!-- <script>
    const userId = "<?php //echo htmlspecialchars($_SESSION['user_id'] ?? '', ENT_QUOTES, 'UTF-8'); 
                    ?>";
    console.log("User ID: ", userId);
</script> -->


<script>
    document.addEventListener("DOMContentLoaded", function() {
        $(document).ready(function() {
            const userId = "<?php echo htmlspecialchars($_SESSION['user_id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>";
            let dataTable;

            initializeDataTable();

            function initializeDataTable() {
                dataTable = $(".data-table").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "payment/payment_fetch.php",
                        type: "POST",
                        data: function(d) {
                            d.user_id = userId;
                        },
                        error: function(xhr, error, code) {
                            toastr.error('Failed to load record data. Please refresh the page.', 'Error');
                        }
                    },
                    scrollCollapse: true,
                    autoWidth: false,
                    responsive: true,
                    columnDefs: [{
                        targets: "datatable-nosort",
                        orderable: false
                    }],
                    order: [
                        [2, "desc"]
                    ],
                    columns: [{
                            data: "amount_paid"
                        },
                        {
                            data: "payment_date"
                        },
                        {
                            data: "updated_at"
                        },
                        {
                            data: "staff_name"
                        }
                    ],
                    language: {
                        info: "_START_-_END_ of _TOTAL_ entries",
                        searchPlaceholder: "Search here",
                        paginate: {
                            next: '<i class="fa fa-angle-right"></i>',
                            previous: '<i class="fa fa-angle-left"></i>'
                        }
                    }
                });
            }
        });
    });
</script>