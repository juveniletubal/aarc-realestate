<?php
require_once __DIR__ . '/../includes/init.php';

$page->setTitle('AARC - Commissions');
$page->setCurrentPage('commissions');

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
                            <h4>List of Commissions</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active text-success" aria-current="page">
                                    Commissions
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
                                <th>Names</th>
                                <th>Roles (Percent)</th>
                                <th>Term</th>
                                <th>Updated</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>


    <div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal"> × </button>
                </div>
                <div class="modal-body">
                    <form id="dataForm">
                        <input type="hidden" name="id" id="id" value="">

                        <div class="row">
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <label>Director<span class="text-danger">*</span></label>
                                    <select class="custom-select" name="director" required>
                                        <option value="">Choose...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Percentage %<span class="text-danger">*</span></label>
                                    <select class="custom-select" name="director_percent" required>
                                        <?php for ($i = 0; $i <= 100; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?>%</option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <label>Manager<span class="text-danger">*</span></label>
                                    <select class="custom-select" name="manager" required>
                                        <option value="">Choose...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Percentage %<span class="text-danger">*</span></label>
                                    <select class="custom-select" name="manager_percent" required>
                                        <?php for ($i = 0; $i <= 100; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?>%</option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <label>Downline<span class="text-danger">*</span></label>
                                    <select class="custom-select" name="downline" required>
                                        <option value="">Choose...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Percentage %<span class="text-danger">*</span></label>
                                    <select class="custom-select" name="downline_percent" required>
                                        <?php for ($i = 0; $i <= 100; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?>%</option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Term<span class="text-danger">*</span></label>
                            <select class="custom-select" name="term" required>
                                <option value="">Choose...</option>
                                <option value="spot">Spot Cash</option>
                                <option value="3">3 Months</option>
                                <option value="6">6 Months</option>
                                <option value="12">12 Months (1 Year)</option>
                                <option value="24">24 Months (2 Years)</option>
                                <option value="36">36 Months (3 Years)</option>
                                <option value="48">48 Months (4 Years)</option>
                                <option value="60">60 Months (5 Years)</option>
                            </select>
                        </div>


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="saveBtn">Save changes</button>
                </div>
            </div>
        </div>
    </div>

</div>


<?php include __DIR__ . '/../includes/footer.php'; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $(document).ready(function() {
            let dataTable;

            initializeDataTable();

            function initializeDataTable() {
                dataTable = $(".data-table").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "commission/commission_fetch.php",
                        type: "POST",
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
                        [3, "desc"]
                    ],
                    columns: [{
                            data: "names"
                        },
                        {
                            data: "roles"
                        },
                        {
                            data: "term"
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