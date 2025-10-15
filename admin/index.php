<?php
require_once __DIR__ . '/../includes/init.php';

$page->setTitle('AARC - Dashboard');
$page->setCurrentPage('dashboard');

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

        <div class="card-box pd-20 height-30-p mb-30 position-relative">
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <button id="editToggleBtn"
                    class="btn btn-sm btn-info position-absolute"
                    style="top: 10px; right: 10px; z-index: 1;"
                    title="Edit Announcement">
                    <i class="fa fa-edit"></i>
                </button>
            <?php endif; ?>

            <div class="row align-items-center">
                <div class="col-md-2">
                    <img src="../assets/images/banner-img.png" alt="" />
                </div>
                <div class="col-md-10">
                    <h4 class="font-20 weight-500 mb-10 text-capitalize">
                        📢 <span id="announcementTitle"></span>
                    </h4>

                    <p class="font-18 text-break" id="announcementText"></p>

                    <input type="text" id="announcementTitleInput" class="form-control mb-2 d-none">
                    <textarea id="announcementContentInput" class="form-control d-none"></textarea>
                </div>
            </div>
        </div>



        <div class="row pb-10">
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark" id="totalProperties">0</div>
                            <div class="font-14 text-secondary weight-500">Total Properties</div>
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
                            <div class="weight-700 font-24 text-dark" id="totalAvailable">0</div>
                            <div class="font-14 text-secondary weight-500">Available</div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon text-warning">
                                <span class="fa fa-check-square-o"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark" id="totalReserved">0</div>
                            <div class="font-14 text-secondary weight-500">Reserved</div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon">
                                <i class="fa fa-bookmark-o"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark" id="totalSold">0</div>
                            <div class="font-14 text-secondary weight-500">Sold</div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#09cc06">
                                <i class="fa fa-lock"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="row pb-10">
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark" id="totalUsers">0</div>
                            <div class="font-14 text-secondary weight-500">Total Users</div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#E34861">
                                <i class="fa fa-users"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark" id="totalStaff">0</div>
                            <div class="font-14 text-secondary weight-500">
                                Staff
                            </div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon">
                                <span class="fa fa-black-tie"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark" id="totalAgent">0</div>
                            <div class="font-14 text-secondary weight-500">
                                Agent
                            </div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon" data-color="#6F5CC0">
                                <i class="fa fa-user-secret"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
                <div class="card-box height-100-p widget-style3">
                    <div class="d-flex flex-wrap">
                        <div class="widget-data">
                            <div class="weight-700 font-24 text-dark" id="totalClient">0</div>
                            <div class="font-14 text-secondary weight-500">Client</div>
                        </div>
                        <div class="widget-icon">
                            <div class="icon text-info">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- <div class="row pb-10">
            <div class="col-md-8 mb-20">
                <div class="card-box height-100-p pd-20">
                    <div
                        class="d-flex flex-wrap justify-content-between align-items-center pb-0 pb-md-3">
                        <div class="h5 mb-md-0">Hospital Activities</div>
                        <div class="form-group mb-md-0">
                            <select class="form-control form-control-sm selectpicker">
                                <option value="">Last Week</option>
                                <option value="">Last Month</option>
                                <option value="">Last 6 Month</option>
                                <option value="">Last 1 year</option>
                            </select>
                        </div>
                    </div>
                    <div id="activities-chart"></div>
                </div>
            </div>
            <div class="col-md-4 mb-20">
                <div
                    class="card-box min-height-200px pd-20 mb-20"
                    data-bgcolor="#455a64">
                    <div class="d-flex justify-content-between pb-20 text-white">
                        <div class="icon h1 text-white">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                        </div>
                        <div class="font-14 text-right">
                            <div><i class="icon-copy ion-arrow-up-c"></i> 2.69%</div>
                            <div class="font-12">Since last month</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="text-white">
                            <div class="font-14">Appointment</div>
                            <div class="font-24 weight-500">1865</div>
                        </div>
                        <div class="max-width-150">
                            <div id="appointment-chart"></div>
                        </div>
                    </div>
                </div>
                <div class="card-box min-height-200px pd-20" data-bgcolor="#265ed7">
                    <div class="d-flex justify-content-between pb-20 text-white">
                        <div class="icon h1 text-white">
                            <i class="fa fa-stethoscope" aria-hidden="true"></i>
                        </div>
                        <div class="font-14 text-right">
                            <div><i class="icon-copy ion-arrow-down-c"></i> 3.69%</div>
                            <div class="font-12">Since last month</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="text-white">
                            <div class="font-14">Surgery</div>
                            <div class="font-24 weight-500">250</div>
                        </div>
                        <div class="max-width-150">
                            <div id="surgery-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div> -->

    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $(document).ready(function() {
            $.ajax({
                url: 'dashboard/fetch_dashboard_stats.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Users
                        $('#totalUsers').text(response.users.total_users ?? 0);
                        $('#totalStaff').text(response.users.total_staff ?? 0);
                        $('#totalAgent').text(response.users.total_agent ?? 0);
                        $('#totalClient').text(response.users.total_client ?? 0);

                        // Properties
                        $('#totalProperties').text(response.properties.total_properties ?? 0);
                        $('#totalAvailable').text(response.properties.total_available ?? 0);
                        $('#totalReserved').text(response.properties.total_reserved ?? 0);
                        $('#totalSold').text(response.properties.total_sold ?? 0);
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
    document.addEventListener("DOMContentLoaded", function() {
        $(document).ready(function() {
            // Fetch announcement on page load
            $.get('dashboard/fetch_announcement.php', function(response) {
                if (response.success) {
                    $('#announcementTitle').text(response.title);
                    $('#announcementText').text(response.content);

                    $('#announcementTitleInput').val(response.title);
                    $('#announcementContentInput').val(response.content);
                }
            }, 'json');

            // Toggle edit/save
            $('#editToggleBtn').on('click', function() {
                let isEditing = $('#announcementContentInput').is(':visible');

                if (isEditing) {
                    // Save mode
                    $.post('dashboard/update_announcement.php', {
                        title: $('#announcementTitleInput').val(),
                        content: $('#announcementContentInput').val()
                    }, function(response) {
                        if (response.success) {
                            // Update UI
                            $('#announcementTitle').text($('#announcementTitleInput').val());
                            $('#announcementText').text($('#announcementContentInput').val());

                            // Switch back to view mode
                            $('#announcementTitle').removeClass('d-none');
                            $('#announcementText').removeClass('d-none');
                            $('#announcementTitleInput').addClass('d-none');
                            $('#announcementContentInput').addClass('d-none');

                            // Change icon back to edit
                            $('#editToggleBtn i').removeClass('fa-save').addClass('fa-edit');
                            $('#editToggleBtn').removeClass('btn-success').addClass('btn-info');
                        } else {
                            alert(response.message);
                        }
                    }, 'json');
                } else {
                    // Edit mode
                    $('#announcementTitle').addClass('d-none');
                    $('#announcementText').addClass('d-none');

                    $('#announcementTitleInput').removeClass('d-none').focus();
                    $('#announcementContentInput').removeClass('d-none');

                    // Change icon to save
                    $('#editToggleBtn i').removeClass('fa-edit').addClass('fa-save');
                    $('#editToggleBtn').removeClass('btn-info').addClass('btn-success');
                }
            });
        });
    });
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