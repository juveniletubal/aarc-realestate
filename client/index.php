<?php
require_once __DIR__ . '/../includes/init.php';

$page->setTitle('AARC - Dashboard');
$page->setCurrentPage('dashboard');

loadCoreAssets($assets, 'client_dashboard');

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

        <div class="row pb-10">
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark" id="totalPropertiesPrice">0</div>
                            <div class="font-14 text-secondary weight-500">Total Properties Price</div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#00eccf">
                                <i class="fa fa-home"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark" id="totalPaid">0</div>
                            <div class="font-14 text-secondary weight-500">Total Paid</div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#09cc06">
                                <span class="fa fa-money"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark" id="totalPenalty">0</div>
                            <div class="font-14 text-secondary weight-500">Total Penalty</div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon text-warning">
                                <span class="fa fa-warning"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-box mb-30">
            <div class="pd-20">
                <h5>Property Details</h5>
            </div>
            <div class="pb-20">
                <table class="prop-details table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>Property</th>
                            <th>Location</th>
                            <th>Lot Area</th>
                            <th>Type</th>
                            <th>Price</th>
                            <th>Balance</th>
                            <th>Terms</th>
                            <th>Monthly</th>
                            <th>Due Date</th>
                            <th>Penalty</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <div class="card-box">
            <div class="pd-20">
                <h5>Payment History</h5>
            </div>
            <div class="pb-20">
                <table class="data-table table stripe hover nowrap">
                    <thead>
                        <tr>
                            <th>Property</th>
                            <th>Amount Paid</th>
                            <th>Payment Date</th>
                            <th>Recorded By</th>
                            <th>Updated</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $(document).ready(function() {
            const userId = "<?php echo htmlspecialchars($_SESSION['user_id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>";
            let dataTable;

            initializeDataTable();

            function initializeDataTable() {
                dataTable = $(".prop-details").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "payment/property_fetch.php",
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
                        [0, "desc"]
                    ],
                    columns: [{
                            data: "property_title"
                        },
                        {
                            data: "location"
                        },
                        {
                            data: "lot_area"
                        },
                        {
                            data: "property_type"
                        },
                        {
                            data: "price"
                        },
                        {
                            data: "balance"
                        },
                        {
                            data: "payment_terms"
                        },
                        {
                            data: "monthly_payment"
                        },
                        {
                            data: "first_payment_date"
                        },
                        {
                            data: "id"
                        },
                        {
                            data: "payment_status"
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
                        [4, "desc"]
                    ],
                    columns: [{
                            data: "property_title"
                        },
                        {
                            data: "amount_paid"
                        },
                        {
                            data: "payment_date"
                        },
                        {
                            data: "staff_name"
                        },
                        {
                            data: "updated_at"
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $(document).ready(function() {
            const userId = "<?php echo htmlspecialchars($_SESSION['user_id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>";

            $.ajax({
                url: 'dashboard/fetch_dashboard_stats.php',
                type: 'GET',
                data: {
                    user_id: userId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#totalPropertiesPrice').text(
                            '₱' + Number(response.totals.total_properties_price ?? 0).toLocaleString('en-PH', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })
                        );

                        $('#totalPaid').text(
                            '₱' + Number(response.payments.total_payment_paid ?? 0).toLocaleString('en-PH', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            })
                        );


                        // $('#totalPaid').text(response.totals.total_paid ?? 0);
                        $('#totalPenalty').text(response.totals.total_penalty ?? 0);
                    } else {
                        console.error(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error:", error);
                }
            });
        });
    });
</script>

<script>
    // document.addEventListener("DOMContentLoaded", function() {
    //     $(document).ready(function() {
    //         // Fetch announcement on page load
    //         $.get('dashboard/fetch_announcement.php', function(response) {
    //             if (response.success) {
    //                 $('#announcementTitle').text(response.title);
    //                 $('#announcementText').text(response.content);

    //                 $('#announcementTitleInput').val(response.title);
    //                 $('#announcementContentInput').val(response.content);
    //             }
    //         }, 'json');

    //         // Toggle edit/save
    //         $('#editToggleBtn').on('click', function() {
    //             let isEditing = $('#announcementContentInput').is(':visible');

    //             if (isEditing) {
    //                 // Save mode
    //                 $.post('dashboard/update_announcement.php', {
    //                     title: $('#announcementTitleInput').val(),
    //                     content: $('#announcementContentInput').val()
    //                 }, function(response) {
    //                     if (response.success) {
    //                         // Update UI
    //                         $('#announcementTitle').text($('#announcementTitleInput').val());
    //                         $('#announcementText').text($('#announcementContentInput').val());

    //                         // Switch back to view mode
    //                         $('#announcementTitle').removeClass('d-none');
    //                         $('#announcementText').removeClass('d-none');
    //                         $('#announcementTitleInput').addClass('d-none');
    //                         $('#announcementContentInput').addClass('d-none');

    //                         // Change icon back to edit
    //                         $('#editToggleBtn i').removeClass('fa-save').addClass('fa-edit');
    //                         $('#editToggleBtn').removeClass('btn-success').addClass('btn-info');
    //                     } else {
    //                         alert(response.message);
    //                     }
    //                 }, 'json');
    //             } else {
    //                 // Edit mode
    //                 $('#announcementTitle').addClass('d-none');
    //                 $('#announcementText').addClass('d-none');

    //                 $('#announcementTitleInput').removeClass('d-none').focus();
    //                 $('#announcementContentInput').removeClass('d-none');

    //                 // Change icon to save
    //                 $('#editToggleBtn i').removeClass('fa-edit').addClass('fa-save');
    //                 $('#editToggleBtn').removeClass('btn-info').addClass('btn-success');
    //             }
    //         });
    //     });
    // });
</script>

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