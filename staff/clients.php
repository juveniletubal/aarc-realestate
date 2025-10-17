<?php
require_once __DIR__ . '/../includes/init.php';

$page->setTitle('AARC - Clients');
$page->setCurrentPage('clients');

loadCoreAssets($assets, 'client_table_form');

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
                            <h4>List of Clients</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active text-success" aria-current="page">
                                    Clients
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        <button class="btn btn-success mr-1" id="addNewBtn">Add New</button>
                        <button class="btn btn-info" id="addExistBtn">Add Existing</button>
                    </div>
                </div>
            </div>

            <div class="card-box">
                <div class="pb-20 pt-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Property</th>
                                <th>Total Price</th>
                                <th>Balance</th>
                                <th>Terms</th>
                                <th>Due Date</th>
                                <th>Agent Assigned</th>
                                <th>Updated</th>
                                <th class="datatable-nosort" style="width: 6%;">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>


    <!-- Add/Edit client Modal -->
    <div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Add New Client</h5>
                    <button type="button" class="close" data-dismiss="modal"> × </button>
                </div>
                <div class="modal-body">
                    <form id="dataForm">
                        <input type="hidden" name="id" id="id" value="">

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="firstname">Fistname<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="firstname" id="firstname" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="lastname">Lastname<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="lastname" id="lastname" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="contact">Contact Number<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="contact" id="contact" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input class="form-control" type="text" name="address" id="address">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="propertySelect">Property Title<span class="text-danger">*</span></label>
                                    <select class="custom-select2 form-control" id="propertySelect" name="property_id" required>
                                        <option value="">Choose...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label id="paymentTerm">Payment Terms<span class="text-danger">*</span></label>
                                    <select class="custom-select" name="payment_terms" id="paymentTerm" required>
                                        <option value="spot_cash">Spot Cash</option>
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
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="totalPrice">Total Price</label>
                                    <input class="form-control" type="text" id="totalPrice" name="total_price" disabled>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="balance">Balance</label>
                                    <input class="form-control" type="text" id="balance" name="balance" disabled>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="penalty">Penalty</label>
                                    <input class="form-control" type="text" id="penalty" name="penalty" disabled>
                                </div>
                            </div>
                        </div>

                        <div style="text-align:center; border-bottom:1px solid #ccc; line-height:0.1em; margin:10px 0 20px;">
                            <span style="background:#fff; padding:0 10px; color: #DC3545;">Use for login credentials</span>
                        </div>


                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <label for="usernameField">Username<span class="text-danger">*</span></label>
                                <div class="input-group custom">
                                    <input class="form-control" type="text" name="username" id="usernameField" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <label for="passwordField">Password<span class="text-danger">*</span></label>
                                <div class="input-group custom">
                                    <input class="form-control" type="password" name="password" id="passwordField" placeholder="">
                                </div>
                            </div>
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

    <!-- Add Existing client Modal -->
    <div class="modal fade" id="dataExistModal" tabindex="-1" role="dialog" aria-labelledby="modalExistLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalExistLabel">Add Existing Client</h5>
                    <button type="button" class="close" data-dismiss="modal"> × </button>
                </div>
                <div class="modal-body">
                    <form id="dataExistForm">
                        <!-- <input type="hidden" name="id" id="id" value=""> -->

                        <div class="form-group">
                            <label for="clientSelect">Client Name<span class="text-danger">*</span></label>
                            <select class="custom-select2 form-control" id="clientSelect" name="client_id" required>
                                <option value="">Choose...</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="propertySelect2">Property Title<span class="text-danger">*</span></label>
                                    <select class="custom-select2 form-control" id="propertySelect2" name="property_id2" required>
                                        <option value="">Choose...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label id="paymentTerm2">Payment Terms<span class="text-danger">*</span></label>
                                    <select class="custom-select" name="payment_terms2" id="paymentTerm2" required>
                                        <option value="spot_cash">Spot Cash</option>
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
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="totalPrice2">Total Price</label>
                                    <input class="form-control" type="text" id="totalPrice2" name="total_price2" disabled>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="balance2">Balance</label>
                                    <input class="form-control" type="text" id="balance2" name="balance2" disabled>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label for="penalty2">Penalty</label>
                                    <input class="form-control" type="text" id="penalty2" name="penalty2" disabled>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="saveExistBtn">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit commissions Modal -->
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
            let currentId = null;
            window.dataTable = null;

            initializeDataTable();

            function initializeDataTable() {
                window.dataTable = $(".data-table").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "client/client_fetch.php",
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
                        [7, "desc"]
                    ],
                    columns: [{
                            data: "fullname"
                        },
                        {
                            data: "property_title"
                        },
                        {
                            data: "total_price"
                        },
                        {
                            data: "balance"
                        },
                        {
                            data: "payment_terms"
                        },
                        {
                            data: "due_date"
                        },
                        {
                            data: "agent_name"
                        },
                        {
                            data: "updated_at"
                        },
                        {
                            data: "id",
                            render: function(data, type, row) {
                                return `<div class="table-actions">
                                    <a href="#" class="edit-btn" data-id="${data}" data-prop_id="${row.property_id}">
                                        <i class="fa fa-pencil" style="color:#17A2B8;"></i>
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
                    const dataId = $(this).data('id');
                    const propId = $(this).data('prop_id');
                    editData(dataId, propId);
                });

                $('.data-table').on('click', '.reassign-agent', function(e) {
                    e.preventDefault();
                    const clientId = $(this).data('id');
                    const comRef = $(this).data('comref');
                    editComData(clientId, comRef);
                });

                $('.data-table').on('click', '.assign-agent', function(e) {
                    e.preventDefault();
                    const clientId = $(this).data('id');
                    const comRef = $(this).data('comref');
                    reset2ComForm();
                    $('#clientId').val(clientId);
                    $('#com_ref').val(comRef || '');
                    $('#modalComLabel').text('Add New Commissions');
                    $('#saveComBtn').text('Save changes').attr('class', 'btn btn-success');
                    $('#comModal').modal('show');
                });
            }

            $('#addNewBtn').on('click', function() {
                resetForm();
                $('#modalLabel').text('Add New Client');
                $('#saveBtn').text('Save changes').attr('class', 'btn btn-success');
                $('input[name="password"]').attr("placeholder", "•••••••••");
                loadProperty();
                $('#dataModal').modal('show');
            });

            $('#saveBtn').on('click', function() {
                saveData();
            });

            function resetForm() {
                $('#dataForm')[0].reset();
                $('#id').val('');
                currentId = null;
            }

            function saveData() {
                if (!validateForm()) return;

                const isUpdate = currentId !== null;
                const formData = new FormData();

                let penaltyDisplay = $('input[name="penalty"]').val();
                let penaltyValue = penaltyDisplay.replace(/[^0-9.]/g, '');

                formData.append('action', isUpdate ? 'update' : 'insert');
                formData.append('firstname', $('input[name="firstname"]').val());
                formData.append('lastname', $('input[name="lastname"]').val());
                formData.append('contact', $('input[name="contact"]').val());
                formData.append('address', $('input[name="address"]').val());
                formData.append('property_id', $('select[name="property_id"]').val());
                formData.append('payment_terms', $('select[name="payment_terms"]').val());
                formData.append('total_price', $('input[name="total_price"]').val());
                formData.append('balance', $('input[name="balance"]').val());
                formData.append('penalty', penaltyValue);
                formData.append('username', $('input[name="username"]').val());
                formData.append('password', $('input[name="password"]').val());

                formData.append('assigned_staff', "<?php echo htmlspecialchars($_SESSION['user_id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>");

                if (isUpdate) {
                    formData.append('id', currentId);
                }

                $.ajax({
                    url: 'client/client_handler.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(
                                isUpdate ? "Client updated successfully!" : "Client added successfully!",
                                "Success"
                            );
                            $('#dataModal').modal('hide');
                            loadRecords();
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

            function validateForm() {
                const firstname = $('input[name="firstname"]').val().trim();
                const lastname = $('input[name="lastname"]').val().trim();
                const contact = $('input[name="contact"]').val().trim();
                const property_id = $('select[name="property_id"]').val();
                const payment_terms = $('select[name="payment_terms"]').val();
                const username = $('input[name="username"]').val().trim();

                if (!firstname) {
                    toastr.error("Firstname is required", "Validation Error");
                    return false;
                }
                if (!lastname) {
                    toastr.error("Lastname is required", "Validation Error");
                    return false;
                }
                if (!contact) {
                    toastr.error("Contact is required", "Validation Error");
                    return false;
                }
                if (!property_id) {
                    toastr.error("Property is required", "Validation Error");
                    return false;
                }
                if (!payment_terms) {
                    toastr.error("Payment terms is required", "Validation Error");
                    return false;
                }
                if (!username) {
                    toastr.error("User username is required", "Validation Error");
                    return false;
                }

                return true;
            }

            window.editData = function(dataId, propId) {
                $.ajax({
                    url: 'client/client_handler.php',
                    type: 'GET',
                    data: {
                        action: 'get',
                        id: dataId,
                        prop_id: propId
                    },
                    success: function(response) {
                        if (response.success) {
                            const record = response.data;
                            populateForm(record);
                            $('#modalLabel').text('Edit Client');
                            $('#saveBtn').text('Save update').attr('class', 'btn btn-info');
                            $('#dataModal').modal('show');
                        } else {
                            toastr.error(response.message, "Error");
                        }
                    },
                    error: function(xhr) {
                        const response = JSON.parse(xhr.responseText);
                        toastr.error(response.message || "An error occurred", "Error");
                    }
                });
            };

            function populateForm(record) {
                currentId = record.id;

                $('#id').val(record.id);
                $('input[name="firstname"]').val(record.firstname);
                $('input[name="lastname"]').val(record.lastname);
                $('input[name="contact"]').val(record.contact);
                $('input[name="address"]').val(record.address);

                loadProperty(record.property_id);

                $('select[name="payment_terms"]').val(record.payment_terms);

                $('input[name="total_price"]').val(record.total_price);
                $('input[name="balance"]').val(record.balance);

                if (record.penalty) {
                    $('input[name="penalty"]').val(record.penalty + '% Monthly');
                } else {
                    $('input[name="penalty"]').val('');
                }

                $('input[name="username"]').val(record.username || "");
                $('input[name="password"]').val("").attr("placeholder", "Leave blank to keep the current password");
            }

            // Commissions
            $('#saveComBtn').on('click', function() {
                saveComData();
            });

            function resetComForm() {
                $('#comForm')[0].reset();
                $('#com_ref').val('');
                currentId = null;
            }

            function saveComData() {
                if (!validateComForm()) return;

                const isUpdate = $('#com_ref').val().trim() !== '';
                const formData = new FormData();

                formData.append('action', isUpdate ? 'update' : 'insert');
                formData.append('clientId', $('#clientId').val());
                formData.append('com_ref', $('#com_ref').val());
                formData.append('director', $('select[name="director"]').val());
                formData.append('director_percent', $('select[name="director_percent"]').val());
                formData.append('manager', $('select[name="manager"]').val());
                formData.append('manager_percent', $('select[name="manager_percent"]').val());
                formData.append('downline', $('select[name="downline"]').val());
                formData.append('downline_percent', $('select[name="downline_percent"]').val());
                formData.append('term', $('select[name="term"]').val());

                $.ajax({
                    url: 'client/assigned_handler.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        console.log("Action:", isUpdate ? "update" : "insert");
                        if (response.success) {
                            toastr.success(
                                isUpdate ? "Assigned updated successfully!" : "Assigned added successfully!",
                                "Success"
                            );
                            $('#comModal').modal('hide');
                            loadRecords();
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
                    url: 'client/fetch_commission.php',
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

            function loadRecords() {
                if (window.dataTable) {
                    window.dataTable.ajax.reload(null, false);
                }
            }
        });

        $('#dataModal, #comModal').on('hide.bs.modal', function() {
            document.activeElement.blur();
        });

        // function loadProperty(selectedId = null) {
        //     $.ajax({
        //         url: "client/property_fetch.php",
        //         method: "GET",
        //         dataType: "json",
        //         success: function(response) {
        //             if (response.success) {
        //                 const $propertySelect = $("#propertySelect");
        //                 $propertySelect.empty().append('<option value="">Choose...</option>');

        //                 propertyList = response.data;
        //                 let selectedProperty = propertyList.find(p => p.id == selectedId);

        //                 if (selectedProperty) {
        //                     $propertySelect.append(
        //                         `<option value="${selectedProperty.id}" disabled selected>
        //                     ${selectedProperty.label} (${selectedProperty.status})
        //                 </option>`
        //                     );
        //                 }

        //                 response.data.forEach(item => {
        //                     if (item.status === "available") {
        //                         $propertySelect.append(
        //                             `<option value="${item.id}">${item.label}</option>`
        //                         );
        //                     }
        //                 });

        //                 if (selectedProperty) {
        //                     $("input[name='total_price']").val(selectedProperty.price);
        //                     $("input[name='balance']").val(selectedProperty.price);
        //                     $("input[name='penalty']").val("5% Monthly");
        //                 }
        //             } else {
        //                 toastr.error("Failed to load property");
        //             }
        //         },
        //         error: function() {
        //             toastr.error("Error fetching property");
        //         }
        //     });

        //     $("#propertySelect").off("change").on("change", function() {
        //         let selectedId = $(this).val();
        //         let selected = propertyList.find(p => p.id == selectedId);

        //         if (selected) {
        //             $("input[name='total_price']").val(selected.price);
        //             $("input[name='balance']").val(selected.price);
        //             $("input[name='penalty']").val("5% Monthly");
        //         } else {
        //             $("input[name='total_price']").val("");
        //             $("input[name='balance']").val("");
        //             $("input[name='penalty']").val("");
        //         }
        //     });
        // }

        // OLD
        function loadProperty(selectedId = null) {
            $.ajax({
                url: "client/property_fetch.php",
                method: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        const $propertySelect = $("#propertySelect");
                        $propertySelect.empty().append('<option value="">Choose...</option>');

                        propertyList = response.data;

                        response.data.forEach(item => {
                            $propertySelect.append(
                                `<option value="${item.id}">${item.title} ${item.label}</option>`
                            );
                        });

                        if (selectedId) {
                            $propertySelect.val(selectedId).trigger('change');
                        }
                    } else {
                        toastr.error("Failed to load property");
                    }
                },
                error: function() {
                    toastr.error("Error fetching property");
                }
            });

            $("#propertySelect").on("change", function() {
                let selectedId = $(this).val();

                let selected = propertyList.find(p => p.id == selectedId);

                if (selected) {
                    $("input[name='total_price']").val(selected.price);
                    $("input[name='balance']").val(selected.price);
                    $("input[name='penalty']").val("5% Monthly");
                } else {
                    $("input[name='total_price']").val("");
                    $("input[name='balance']").val("");
                    $("input[name='penalty']").val("");
                }
            });
        }
    });
</script>

<!-- Existing Client -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        $(document).ready(function() {
            $('#addExistBtn').on('click', function() {
                $('#dataExistForm')[0].reset();
                $('#modalExistLabel').text('Add Existing Client');
                $('#saveExistBtn').text('Save changes').attr('class', 'btn btn-success');
                loadExistClient();
                loadProperty2();
                $('#dataExistModal').modal('show');
            });

            $('#saveExistBtn').on('click', function() {
                saveExistData();
            });

            function saveExistData() {
                if (!validateExistForm()) return;

                const formData = new FormData();

                let penaltyDisplay = $('input[name="penalty2"]').val();
                let penaltyValue = penaltyDisplay.replace(/[^0-9.]/g, '');

                formData.append('action', 'insert');
                formData.append('client_id', $('select[name="client_id"]').val());
                formData.append('property_id', $('select[name="property_id2"]').val());
                formData.append('payment_terms', $('select[name="payment_terms2"]').val());
                formData.append('total_price', $('input[name="total_price2"]').val());
                formData.append('balance', $('input[name="balance2"]').val());
                formData.append('penalty', penaltyValue);

                formData.append('assigned_staff', "<?php echo htmlspecialchars($_SESSION['user_id'] ?? '', ENT_QUOTES, 'UTF-8'); ?>");

                $.ajax({
                    url: 'client/client_exist_handler.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success("Client added successfully!", "Success");
                            $('#dataExistModal').modal('hide');
                            loadExistRecords();
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

            function validateExistForm() {
                const client_id = $('select[name="client_id"]').val();
                const property_id = $('select[name="property_id2"]').val();
                const payment_terms = $('select[name="payment_terms2"]').val();

                if (!client_id) {
                    toastr.error("Client is required", "Validation Error");
                    return false;
                }
                if (!property_id) {
                    toastr.error("Property is required", "Validation Error");
                    return false;
                }
                if (!payment_terms) {
                    toastr.error("Payment terms is required", "Validation Error");
                    return false;
                }

                return true;
            }

            function loadExistRecords() {
                if (window.dataTable) {
                    window.dataTable.ajax.reload(null, false);
                }
            }

            function loadExistClient() {
                $.ajax({
                    url: "client/client_name_fetch.php",
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            client = response.data;
                            $("#clientSelect").empty().append('<option value=""></option>');

                            response.data.forEach(item => {
                                $("#clientSelect").append(
                                    `<option value="${item.id}">${item.client_name}</option>`
                                );
                            });
                        } else {
                            toastr.error("Failed to load client");
                        }
                    },
                    error: function() {
                        toastr.error("Error fetching client");
                    }
                });
            };

            function loadProperty2(selectedId = null) {
                $.ajax({
                    url: "client/property_fetch.php",
                    method: "GET",
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            const $propertySelect2 = $("#propertySelect2");
                            $propertySelect2.empty().append('<option value="">Choose...</option>');

                            propertyList2 = response.data;

                            response.data.forEach(item => {
                                $propertySelect2.append(
                                    `<option value="${item.id}">${item.title} ${item.label}</option>`
                                );
                            });

                            if (selectedId) {
                                $propertySelect2.val(selectedId).trigger('change');
                            }
                        } else {
                            toastr.error("Failed to load property");
                        }
                    },
                    error: function() {
                        toastr.error("Error fetching property");
                    }
                });

                $("#propertySelect2").on("change", function() {
                    let selectedId = $(this).val();

                    let selected = propertyList2.find(p => p.id == selectedId);

                    if (selected) {
                        $("input[name='total_price2']").val(selected.price);
                        $("input[name='balance2']").val(selected.price);
                        $("input[name='penalty2']").val("5% Monthly");
                    } else {
                        $("input[name='total_price2']").val("");
                        $("input[name='balance2']").val("");
                        $("input[name='penalty2']").val("");
                    }
                });
            }

            $('#dataExistModal').on('hide.bs.modal', function() {
                document.activeElement.blur();
            });
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let agent = [];

        $.ajax({
            url: "client/agent_fetch.php",
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
            // $('#propertySelect').select2({
            //     placeholder: "",
            //     allowClear: true,
            //     width: '100%',
            //     dropdownParent: $('#dataModal')
            // });

            $('#propertySelect').select2({
                placeholder: "",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#dataModal'),
                escapeMarkup: function(markup) {
                    return markup;
                },
                templateResult: function(data) {
                    if (!data.id) return data.text;

                    const match = data.text.match(/^(.*?)\s*\((.*?)\)$/);
                    if (match) {
                        return `
                <span>
                    <span style="font-weight:500;font-size: 0.95rem;">${match[1]}</span>
                    <span style="font-size: 0.80em;"> &nbsp;(${match[2]})</span>
                </span>`;
                    }
                    return data.text;
                },
                templateSelection: function(data) {
                    if (!data.id) return data.text;

                    const match = data.text.match(/^(.*?)\s*\((.*?)\)$/);
                    if (match) {
                        return `
                        <span style="font-weight:500;font-size: 0.95rem;">${match[1]}</span>
                        <span style="font-size: 0.80em;"> &nbsp;(${match[2]})</span>`;
                    }
                    return data.text;
                }
            });
        });

        $(document).ready(function() {
            $('#clientSelect').select2({
                placeholder: "",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#dataExistModal')
            });

            $('#propertySelect2').select2({
                placeholder: "",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#dataExistModal'),
                escapeMarkup: function(markup) {
                    return markup;
                },
                templateResult: function(data) {
                    if (!data.id) return data.text;

                    const match = data.text.match(/^(.*?)\s*\((.*?)\)$/);
                    if (match) {
                        return `
                <span>
                    <span style="font-weight:500;font-size: 0.95rem;">${match[1]}</span>
                    <span style="font-size: 0.80em;"> &nbsp;(${match[2]})</span>
                </span>`;
                    }
                    return data.text;
                },
                templateSelection: function(data) {
                    if (!data.id) return data.text;

                    const match = data.text.match(/^(.*?)\s*\((.*?)\)$/);
                    if (match) {
                        return `
                        <span style="font-weight:500;font-size: 0.95rem;">${match[1]}</span>
                        <span style="font-size: 0.80em;"> &nbsp;(${match[2]})</span>`;
                    }
                    return data.text;
                }
            });
        });

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