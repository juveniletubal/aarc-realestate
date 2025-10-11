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
                                <th class="datatable-nosort" style="width: 7%;">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="comModal" tabindex="-1" role="dialog" aria-labelledby="modalComLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalComLabel">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal"> × </button>
                </div>
                <div class="modal-body">
                    <form id="comForm">
                        <input type="hidden" name="com_ref" id="com_ref" value="">
                        <input type="hidden" name="clientId" id="clientId" value="">

                        <div class="row">
                            <div class="col-md-8 col-sm-12">
                                <div class="form-group">
                                    <label for="director">Director<span class="text-danger">*</span></label>
                                    <select class="custom-select2" name="director" id="director" required>
                                        <option value="">Choose...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="dirPercent">Percentage %<span class="text-danger">*</span></label>
                                    <select class="custom-select" name="director_percent" id="dirPercent" required>
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
                                    <label for="manager">Manager</label>
                                    <select class="custom-select2" name="manager" id="manager" required>
                                        <option value="">Choose...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="manPercent">Percentage %</label>
                                    <select class="custom-select" name="manager_percent" id="manPercent" required>
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
                                    <label for="downline">Downline</label>
                                    <select class="custom-select2" name="downline" id="downline" required>
                                        <option value="">Choose...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="downPercent">Percentage %</label>
                                    <select class="custom-select" name="downline_percent" id="downPercent" required>
                                        <?php for ($i = 0; $i <= 100; $i++): ?>
                                            <option value="<?= $i ?>"><?= $i ?>%</option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="comTerm">Term<span class="text-danger">*</span></label>
                            <select class="custom-select" name="term" id="comTerm" required>
                                <option value="">Choose...</option>
                                <option value="spot">Spot Cash</option>
                                <option value="3">3 Months</option>
                                <option value="6">6 Months</option>
                                <option value="12">12 Months (1 Year)</option>
                                <option value="24">24 Months (2 Years)</option>
                                <option value="36">36 Months (3 Years)</option>
                                <option value="48">48 Months (4 Years)</option>
                                <option value="60">60 Months (5 Years)</option>
                                <option value="72">72 Months (6 Years)</option>
                            </select>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="saveComBtn">Save changes</button>
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
                            console.log('DataTable Ajax Error:');
                            console.log('Status:', xhr.status);
                            console.log('Response:', xhr.responseText);
                            console.log('Error:', error);
                            console.log('Code:', code);

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
                        },
                        {
                            data: "id",
                            render: function(data, type, row) {
                                return `<div class="table-actions">
                                    <a href="#" class="edit-btn" data-id="${data}" data-comref="${row.com_ref}">
                                        <i class="fa fa-pencil" style="color:#17A2B8;"></i>
                                    </a>
                                    <a href="#" class="delete-btn" data-id="${data}" data-comref="${row.com_ref}">
                                        <i class="fa fa-trash-o" style="color:red;"></i>
                                    </a>
                                </div>`;
                            }
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

                $('.data-table').on('click', '.edit-btn', function(e) {
                    e.preventDefault();
                    const clientId = $(this).data('id');
                    const comRef = $(this).data('comref');
                    editComData(clientId, comRef);
                });

                $('.data-table').on('click', '.delete-btn', function(e) {
                    e.preventDefault();
                    const clientId = $(this).data('id');
                    const comRef = $(this).data('comref');
                    deleteData(clientId, comRef);
                });
            }

            $('#saveComBtn').on('click', function() {
                saveComData();
            });

            function saveComData() {
                if (!validateComForm()) return;

                const formData = new FormData();

                formData.append('action', 'update');
                formData.append('clientId', $('input[name="clientId"]').val());
                formData.append('com_ref', $('input[name="com_ref"]').val());
                formData.append('director', $('select[name="director"]').val());
                formData.append('director_percent', $('select[name="director_percent"]').val());
                formData.append('manager', $('select[name="manager"]').val());
                formData.append('manager_percent', $('select[name="manager_percent"]').val());
                formData.append('downline', $('select[name="downline"]').val());
                formData.append('downline_percent', $('select[name="downline_percent"]').val());
                formData.append('term', $('select[name="term"]').val());

                $.ajax({
                    url: 'commission/assigned_handler.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success("Assigned updated successfully!", "Success");
                            $('#comModal').modal('hide');
                            loadCommissions();
                        } else {
                            toastr.error(response.message, "Error");
                        }
                    },
                    error: function(xhr) {
                        const response = JSON.parse(xhr.responseText);
                        toastr.error(response.message || "An error occurred", "Error");
                    }
                });
            }

            function validateComForm() {
                const director = $('select[name="director"]').val();
                const manager = $('select[name="manager"]').val();
                const downline = $('select[name="downline"]').val();

                const director_percent = $('select[name="director_percent"]').val();
                const term = $('select[name="term"]').val();

                if (!director) {
                    toastr.error("Director is required", "Validation Error");
                    return false;
                }
                if (!director_percent) {
                    toastr.error("Director percent is required", "Validation Error");
                    return false;
                }
                if (!term) {
                    toastr.error("Term is required", "Validation Error");
                    return false;
                }

                if (manager && director === manager) {
                    toastr.error("Manager cannot be the same as Director", "Validation Error");
                    return false;
                }
                if (downline && director === downline) {
                    toastr.error("Downline cannot be the same as Director", "Validation Error");
                    return false;
                }
                if (manager && downline && manager === downline) {
                    toastr.error("Downline cannot be the same as Manager", "Validation Error");
                    return false;
                }

                return true;
            }

            window.editComData = function(clientId, comRef) {
                reset2ComForm();
                $('#clientId').val(clientId);
                $('#com_ref').val(comRef);

                $('#modalComLabel').text('Edit Commissions');
                $('#saveComBtn').text('Save update').attr('class', 'btn btn-info');

                if (!comRef) {
                    $('#comModal').modal('show');
                    return;
                }

                $.ajax({
                    url: 'commission/fetch_commission.php',
                    type: 'GET',
                    data: {
                        com_ref: comRef
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success && response.data) {
                            const data = response.data;

                            if (data.director) {
                                $('#director').val(data.director.user_id).trigger('change');
                                $('select[name="director_percent"]').val(data.director.percent);
                            }

                            if (data.manager) {
                                $('#manager').val(data.manager.user_id).trigger('change');
                                $('select[name="manager_percent"]').val(data.manager.percent);
                            }

                            if (data.downline) {
                                $('#downline').val(data.downline.user_id).trigger('change');
                                $('select[name="downline_percent"]').val(data.downline.percent);
                            }

                            if (data.term) {
                                $('select[name="term"]').val(data.term);
                            }

                            $('#comModal').modal('show');
                        } else {
                            toastr.warning('No commission data found for this record.');
                            $('#comModal').modal('show');
                        }
                    },
                    error: function() {
                        toastr.error('Error fetching commission data.');
                    }
                });
            };

            function reset2ComForm() {
                $('#comForm')[0].reset();
                $('#director, #manager, #downline').val('').trigger('change');
            }

            window.deleteData = function(clientId, comRef) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'commission/assigned_handler.php',
                            type: 'POST',
                            data: {
                                action: 'delete',
                                clientId: clientId,
                                com_ref: comRef
                            },
                            success: function(response) {
                                if (response.success) {
                                    toastr.success("Commission deleted successfully!", "Success");
                                    loadCommissions();
                                } else {
                                    toastr.error(response.message, "Error");
                                }
                            },
                            error: function(xhr) {
                                const response = JSON.parse(xhr.responseText);
                                toastr.error(response.message || "An error occurred", "Error");
                            }
                        });
                    }
                });
            };

            function loadCommissions() {
                if (dataTable) {
                    dataTable.ajax.reload(null, false);
                }
            }
        });

        $('#comModal').on('hide.bs.modal', function() {
            document.activeElement.blur();
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let agent = [];

        $.ajax({
            url: "commission/agent_fetch.php",
            method: "GET",
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    agent = response.data;
                    $("#manager").empty().append('<option value=""></option>');
                    $("#director").empty().append('<option value=""></option>');
                    $("#downline").empty().append('<option value=""></option>');

                    response.data.forEach(item => {
                        $("#manager").append(
                            `<option value="${item.id}">${item.agent_name}</option>`
                        );
                        $("#director").append(
                            `<option value="${item.id}">${item.agent_name}</option>`
                        );
                        $("#downline").append(
                            `<option value="${item.id}">${item.agent_name}</option>`
                        );
                    });
                } else {
                    toastr.error("Failed to load agent");
                }
            },
            error: function() {
                toastr.error("Error fetching agent");
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $(document).ready(function() {
            $('#director, #manager, #downline').select2({
                placeholder: "",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#comModal')
            });
        });
    });
</script>