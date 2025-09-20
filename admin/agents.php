<?php
require_once __DIR__ . '/../includes/init.php';

$page->setTitle('AARC - Agents');
$page->setCurrentPage('agents');

loadCoreAssets($assets, 'table');

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
                            <h4>List of Agents</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active text-info" aria-current="page">
                                    Agents
                                </li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-md-6 col-sm-12 text-right">
                        <button class="btn btn-info" id="addNewBtn">Add New</button>
                    </div>
                </div>
            </div>

            <div class="card-box">
                <div class="pb-20 pt-20">
                    <table class="data-table table stripe hover nowrap">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Status</th>
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


    <!-- Add/Edit agent Modal -->
    <div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Add New Agent</h5>
                    <button type="button" class="close" data-dismiss="modal"> × </button>
                </div>
                <div class="modal-body">
                    <form id="dataForm">
                        <input type="hidden" name="id" id="id" value="">

                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Firstname</label>
                                    <input class="form-control" type="text" name="firstname" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Lastname</label>
                                    <input class="form-control" type="text" name="lastname" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Email Address</label>
                                    <input class="form-control" type="email" name="email" required>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Contact Number</label>
                                    <input class="form-control" type="text" name="phone" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>Facebook Link</label>
                                    <input class="form-control" type="text" name="facebook_link">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label>License Number</label>
                                    <input class="form-control" type="text" name="license_number" placeholder="Optional">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Profile Image</label>
                            <input type="file" name="image" class="form-control-file form-control height-auto">
                            <img id="currentImage" src="" alt="Current Image" style="max-height:100px; display:none; margin-top:10px;">
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
                        url: "agent/agent_fetch.php",
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
                        [4, "desc"]
                    ],
                    columns: [{
                            data: "fullname"
                        },
                        {
                            data: "email"
                        },
                        {
                            data: "phone"
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
                $('#modalLabel').text('Add New Agent');
                $('#saveBtn').text('Save changes');
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
                formData.append('email', $('input[name="email"]').val());
                formData.append('phone', $('input[name="phone"]').val());
                formData.append('facebook_link', $('input[name="facebook_link"]').val());
                formData.append('license_number', $('input[name="license_number"]').val());

                if (isUpdate) {
                    formData.append('id', currentId);
                }

                // Add image file
                const imageFile = $('input[name="image"]')[0].files[0];
                if (imageFile) {
                    formData.append('image', imageFile);
                }

                $.ajax({
                    url: 'agent/agent_handler.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(
                                isUpdate ? "Agent updated successfully!" : "Agent added successfully!",
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
                const email = $('input[name="email"]').val().trim();
                const phone = $('input[name="phone"]').val().trim();

                if (!firstname) {
                    toastr.error("Agent firstname is required", "Validation Error");
                    return false;
                }
                if (!lastname) {
                    toastr.error("Agent lastname is required", "Validation Error");
                    return false;
                }
                if (!email) {
                    toastr.error("Agent email is required", "Validation Error");
                    return false;
                }
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(email)) {
                    toastr.error("Please enter a valid email address", "Validation Error");
                    return false;
                }
                if (!phone) {
                    toastr.error("Agent contact number is required", "Validation Error");
                    return false;
                }

                return true;
            }

            window.editData = function(id) {
                $.ajax({
                    url: 'agent/agent_handler.php',
                    type: 'GET',
                    data: {
                        action: 'get',
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            const record = response.data;
                            populateForm(record);
                            $('#modalLabel').text('Edit Agent');
                            $('#saveBtn').text('Save update');
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
                $('input[name="email"]').val(record.email);
                $('input[name="phone"]').val(record.phone);
                $('input[name="facebook_link"]').val(record.facebook_link);
                $('input[name="license_number"]').val(record.license_number);

                // image preview (optional)
                if (record.image) {
                    $('#currentImage').attr('src', '../uploads/agents' + record.image).show();
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
                            url: 'agent/agent_handler.php',
                            type: 'POST',
                            data: {
                                action: 'delete',
                                id: id
                            },
                            success: function(response) {
                                if (response.success) {
                                    toastr.success("Agent deleted successfully!", "Success");
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