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
                    <div class="col-md-6 col-sm-12 text-right">
                        <button class="btn btn-success" id="addNewBtn">Add New</button>
                    </div>
                </div>
            </div>

            <div class="card-box">
                <div class="pb-20 pt-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <!-- <tr>
                                <th>Name</th>
                                <th>Contact</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Updated</th>
                                <th class="datatable-nosort" style="width: 7%;">Action</th>
                            </tr> -->
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>


    <!-- Add/Edit agent Modal -->
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
                                    <label>Manager<span class="text-danger">*</span></label>
                                    <select class="custom-select" name="manager" required>
                                        <option value="">Choose...</option>
                                        <!-- PHP loop for users -->
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
                                        <!-- PHP loop for users -->
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
            let currentId = null;
            let dataTable;

            // Initialize DataTable
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
                        [5, "desc"]
                    ],
                    columns: [{
                            data: "fullname"
                        },
                        {
                            data: "contact"
                        },
                        {
                            data: "email"
                        },
                        {
                            data: "role"
                        },
                        {
                            data: "status"
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
                                    <a href="#" class="delete-btn" data-id="${data}">
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

                // Handle edit button clicks
                $('.data-table').on('click', '.edit-btn', function(e) {
                    e.preventDefault();
                    const dataId = $(this).data('id');
                    editData(dataId);
                });

                // Handle delete button clicks
                $('.data-table').on('click', '.delete-btn', function(e) {
                    e.preventDefault();
                    const dataId = $(this).data('id');
                    deleteData(dataId);
                });
            }

            // Add New Agent Button
            $('#addNewBtn').on('click', function() {
                resetForm();
                $('#modalLabel').text('Add New Commission');
                $('#saveBtn').text('Save changes');
                $('#saveBtn').attr('class', 'btn btn-success')
                $('input[name="password"]').attr("placeholder", "•••••••••");
                $('#dataModal').modal('show');
            });

            // Save Agent Button
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
                formData.append('email', $('input[name="email"]').val());
                formData.append('address', $('input[name="address"]').val());
                formData.append('facebook_link', $('input[name="facebook_link"]').val());
                formData.append('role', $('select[name="role"]').val());

                const imageFile = $('input[name="image"]')[0].files[0];
                if (imageFile) {
                    formData.append('image', imageFile);
                }

                formData.append('username', $('input[name="username"]').val());
                formData.append('password', $('input[name="password"]').val());

                if (isUpdate) {
                    formData.append('id', currentId);
                }

                $.ajax({
                    url: 'user/user_handler.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(
                                isUpdate ? "User updated successfully!" : "User added successfully!",
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
                const role = $('select[name="role"]').val();
                const username = $('input[name="username"]').val().trim();

                if (!firstname) {
                    toastr.error("User firstname is required", "Validation Error");
                    return false;
                }
                if (!lastname) {
                    toastr.error("User lastname is required", "Validation Error");
                    return false;
                }
                if (!contact) {
                    toastr.error("User contact is required", "Validation Error");
                    return false;
                }
                if (!role) {
                    toastr.error("User role is required", "Validation Error");
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
                    url: 'user/user_handler.php',
                    type: 'GET',
                    data: {
                        action: 'get',
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            const record = response.data;
                            populateForm(record);
                            $('#modalLabel').text('Edit User');
                            $('#saveBtn').text('Save update');
                            $('#saveBtn').attr('class', 'btn btn-update')
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
                $('input[name="email"]').val(record.email);
                $('input[name="address"]').val(record.address);
                $('input[name="facebook_link"]').val(record.facebook_link);
                $('select[name="role"]').val(record.role);
                $('input[name="username"]').val(record.username || "");
                $('input[name="password"]').val("").attr("placeholder", "Leave blank to keep the current password");

                if (record.image) {
                    $('#imagePreview').attr("src", "../uploads/users/" + record.image).show();
                } else {
                    $('#imagePreview').hide();
                }
            }

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

        $('#dataModal').on('hide.bs.modal', function() {
            document.activeElement.blur();
        });
    });
</script>


<script>
    document.addEventListener("DOMContentLoaded", function() {
        $(document).ready(function() {
            $("#positionSelect").on("change", function() {
                const selected = $(this).val();

                if (selected === "manager" || selected === "downline") {
                    $("#uplineWrapper").show();

                    $.ajax({
                        url: "agent/fetch_directors.php",
                        method: "GET",
                        dataType: "json",
                        success: function(response) {
                            if (response.success) {
                                $("#uplineSelect").empty().append('<option value="">Choose...</option>');

                                response.data.forEach(director => {
                                    $("#uplineSelect").append(
                                        `<option value="${director.id}">${director.name}</option>`
                                    );
                                });
                            } else {
                                toastr.error("Failed to load directors");
                            }
                        },
                        error: function() {
                            toastr.error("Error fetching directors");
                        }
                    });

                } else {
                    $("#uplineWrapper").hide();
                    $("#uplineSelect").val("");
                }
            });
        });
    });
</script>