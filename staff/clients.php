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
                        <button class="btn btn-success" id="addNewBtn">Add New</button>
                    </div>
                </div>
            </div>

            <div class="card-box">
                <div class="pb-20 pt-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Property</th>
                                <th>Total Price</th>
                                <th>Balance</th>
                                <th>Terms</th>
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


    <!-- Add/Edit agent Modal -->
    <div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Add New Client</h5>
                    <button type="button" class="close" data-dismiss="modal"> × </button>
                </div>
                <div class="modal-body">
                    <form id="dataForm">
                        <input type="text" name="id" id="id" value="">

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Fistname<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="firstname" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Lastname<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="lastname" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Contact Number<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" name="contact" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Address</label>
                                    <input class="form-control" type="text" name="address">
                                </div>
                            </div>
                        </div>

                        <!-- <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Assigned Agent<span class="text-danger">*</span></label>
                                    <select class="custom-select" id="agentSelect" name="assigned_agent" required>
                                        <option value="">Choose...</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Upline or Downline</label>
                                    <input class="form-control" type="text" name="" disabled value="Manager name / Downline name">
                                </div>
                            </div>
                        </div> -->

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Property Title<span class="text-danger">*</span></label>
                                    <select class="custom-select2 form-control" id="propertySelect" name="property_id" required>
                                        <option value="">Choose...</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Payment Terms<span class="text-danger">*</span></label>
                                    <select class="custom-select" name="payment_terms" required>
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
                                    <label>Total Price</label>
                                    <input class="form-control" type="text" name="total_price" disabled>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Balance</label>
                                    <input class="form-control" type="text" name="balance" disabled>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Penalty</label>
                                    <input class="form-control" type="text" name="penalty" disabled>
                                </div>
                            </div>
                        </div>

                        <div style="text-align:center; border-bottom:1px solid #ccc; line-height:0.1em; margin:10px 0 20px;">
                            <span style="background:#fff; padding:0 10px; color: #DC3545;">Use for login credentials</span>
                        </div>


                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <label>Username<span class="text-danger">*</span></label>
                                <div class="input-group custom">
                                    <input class="form-control" type="text" name="username" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <label>Password<span class="text-danger">*</span></label>
                                <div class="input-group custom">
                                    <input class="form-control" type="password" name="password" placeholder="">
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
                                    <label>Director<span class="text-danger">*</span></label>
                                    <select class="custom-select2" name="director" id="director" required>
                                        <option value="">Choose...</option>
                                        <!-- PHP loop for users -->
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
                                    <label>Manager</label>
                                    <select class="custom-select2" name="manager" id="manager" required>
                                        <option value="">Choose...</option>
                                        <!-- PHP loop for users -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Percentage %</label>
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
                                    <label>Downline</label>
                                    <select class="custom-select2" name="downline" id="downline" required>
                                        <option value="">Choose...</option>
                                        <!-- PHP loop for users -->
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="form-group">
                                    <label>Percentage %</label>
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
                    <button type="button" class="btn btn-success" id="saveComBtn">Save changes</button>
                </div>
            </div>
        </div>
    </div>



</div>


<?php include __DIR__ . '/../includes/footer.php'; ?>

<script>
    const loggedInStaffId = "<?php echo $_SESSION['user_id'] ?? ''; ?>";
    console.log("Login ID:", loggedInStaffId);
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $(document).ready(function() {
            let currentId = null;
            let dataTable;

            // Initialize DataTable
            initializeDataTable();

            function initializeDataTable() {
                dataTable = $(".data-table").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "client/client_fetch.php",
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
                        [7, "desc"]
                    ],
                    columns: [{
                            data: "fullname"
                        },
                        {
                            data: "contact"
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
                            data: "agent_name"
                        },
                        {
                            data: "updated_at"
                        },
                        {
                            data: "id",
                            render: function(data) {
                                return `<div class="table-actions">
                                    <a href="#" class="edit-btn" data-id="${data}">
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

                // Handle edit button clicks
                $('.data-table').on('click', '.edit-btn', function(e) {
                    e.preventDefault();
                    const dataId = $(this).data('id');
                    editData(dataId);
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
                    resetComForm();
                    $('#clientId').val(clientId);
                    $('#com_ref').val(comRef || '');
                    $('#modalComLabel').text('Add New Commissions');
                    $('#saveComBtn').text('Save changes').attr('class', 'btn btn-success');
                    $('#comModal').modal('show');
                });

                $('.data-table').on('click', '.delete-btn', function(e) {
                    e.preventDefault();
                    const dataId = $(this).data('id');
                    deleteData(dataId);
                });
            }

            // Add New Button
            $('#addNewBtn').on('click', function() {
                resetForm();
                $('#modalLabel').text('Add New Client');
                $('#saveBtn').text('Save changes');
                $('#saveBtn').attr('class', 'btn btn-success')
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

                // Add form data
                formData.append('action', isUpdate ? 'update' : 'insert');
                formData.append('firstname', $('input[name="firstname"]').val());
                formData.append('lastname', $('input[name="lastname"]').val());
                formData.append('contact', $('input[name="contact"]').val());
                formData.append('address', $('input[name="address"]').val());
                // formData.append('assigned_agent', $('select[name="assigned_agent"]').val());
                formData.append('property_id', $('select[name="property_id"]').val());
                formData.append('payment_terms', $('select[name="payment_terms"]').val());
                formData.append('total_price', $('input[name="total_price"]').val());
                formData.append('balance', $('input[name="balance"]').val());
                formData.append('penalty', $('input[name="penalty"]').val());
                formData.append('username', $('input[name="username"]').val());
                formData.append('password', $('input[name="password"]').val());

                formData.append('assigned_staff', loggedInStaffId);

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
                            loadProperties();
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
                // const assigned_agent = $('select[name="assigned_agent"]').val();
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
                // if (!assigned_agent) {
                //     toastr.error("Assigned agent is required", "Validation Error");
                //     return false;
                // }
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

            window.editData = function(id) {
                $.ajax({
                    url: 'client/client_handler.php',
                    type: 'GET',
                    data: {
                        action: 'get',
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            const record = response.data;
                            populateForm(record);
                            $('#modalLabel').text('Edit Client');
                            $('#saveBtn').text('Save update');
                            $('#saveBtn').attr('class', 'btn btn-info')
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

                // $('select[name="property_id"]').val(record.property_id);
                loadProperty(record.property_id);

                $('select[name="payment_terms"]').val(record.payment_terms);

                $('input[name="total_price"]').val(record.total_price);
                $('input[name="balance"]').val(record.balance);
                $('input[name="penalty"]').val(record.penalty);

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

                const isUpdate = currentId !== null;
                const formData = new FormData();

                formData.append('action', isUpdate ? 'update' : 'insert');
                formData.append('clientId', $('#clientId').val());
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
                        if (response.success) {
                            toastr.success(
                                isUpdate ? "Assigned updated successfully!" : "Assigned added successfully!",
                                "Success"
                            );
                            $('#comModal').modal('hide');
                            loadProperties();
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
                return true;
            }

            window.editComData = function(clientId, comRef) {
                $.ajax({
                    url: 'client/assigned_handler.php',
                    type: 'GET',
                    data: {
                        action: 'get',
                        id: clientId
                    },
                    success: function(response) {
                        if (response.success) {
                            const record = response.data;
                            // populateComForm(record);

                            $('#clientId').val(clientId);
                            $('#com_ref').val(comRef || '');
                            $('#modalComLabel').text('Edit Commissions');
                            $('#saveComBtn').text('Save update').attr('class', 'btn btn-info');
                            $('#comModal').modal('show');
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

            // function populateComForm(record) {
            //     currentId = record.id;

            //     $('#com_ref').val(record.com_ref);
            //     $('select[name="director"]').val(record.director);
            //     $('select[name="director_percent"]').val(record.director_percent);
            //     $('select[name="manager"]').val(record.manager);
            //     $('select[name="manager_percent"]').val(record.manager_percent);
            //     $('select[name="downline"]').val(record.downline);
            //     $('select[name="downline_percent"]').val(record.downline_percent);
            //     $('select[name="term"]').val(record.term);
            // }

            window.deleteData = function(id) {
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
                            url: 'user/user_handler.php',
                            type: 'POST',
                            data: {
                                action: 'delete',
                                id: id
                            },
                            success: function(response) {
                                if (response.success) {
                                    toastr.success("User deleted successfully!", "Success");
                                    loadProperties();
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

            function loadProperties() {
                if (dataTable) {
                    dataTable.ajax.reload(null, false);
                }
            }
        });

        $('#dataModal, #comModal').on('hide.bs.modal', function() {
            document.activeElement.blur();
        });

        function loadProperty(selectedId = null) {
            $.ajax({
                url: "client/property_fetch.php",
                method: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        const $propertySelect = $("#propertySelect");
                        $propertySelect.empty().append('<option value="">Choose...</option>');

                        response.data.forEach(item => {
                            $propertySelect.append(
                                `<option value="${item.id}">${item.label}</option>`
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

                let selected = property.find(p => p.id == selectedId);

                if (selected) {
                    $("input[name='total_price']").val(selected.price);
                    $("input[name='balance']").val(selected.price);
                    $("input[name='penalty']").val("0");
                } else {
                    $("input[name='total_price']").val("");
                    $("input[name='balance']").val("");
                    $("input[name='penalty']").val("");
                }
            });
        }

    });
</script>

<script>
    // document.addEventListener("DOMContentLoaded", function() {
    //     let property = [];

    //     $.ajax({
    //         url: "client/property_fetch.php",
    //         method: "GET",
    //         dataType: "json",
    //         success: function(response) {
    //             if (response.success) {
    //                 property = response.data
    //                 $("#propertySelect").empty().append('<option value="">Choose...</option>');

    //                 response.data.forEach(item => {
    //                     $("#propertySelect").append(
    //                         `<option value="${item.id}">${item.label}  (${item.location})</option>`
    //                     );
    //                 });
    //             } else {
    //                 toastr.error("Failed to load property");
    //             }
    //         },
    //         error: function() {
    //             toastr.error("Error fetching property");
    //         }
    //     });

    //     // When user selects a property
    //     $("#propertySelect").on("change", function() {
    //         let selectedId = $(this).val();

    //         let selected = property.find(p => p.id == selectedId);

    //         if (selected) {
    //             $("input[name='total_price']").val(selected.price);
    //             $("input[name='balance']").val(selected.price);
    //             $("input[name='penalty']").val("0");
    //         } else {
    //             $("input[name='total_price']").val("");
    //             $("input[name='balance']").val("");
    //             $("input[name='penalty']").val("");
    //         }
    //     });
    // });
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
            $('#propertySelect').select2({
                placeholder: "",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#dataModal')
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




<!-- sa edit Agent Assigned nako -->