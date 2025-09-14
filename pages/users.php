<?php
require_once __DIR__ . '/../includes/init.php';

// Page setup
$page->setTitle('Users - Admin Panel');
$page->setCurrentPage('users');
$page->addBreadcrumb('Home', '../index.php');
$page->addBreadcrumb('Users');

// Load assets
loadCoreAssets($assets, 'table');

// Layout includes
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';
?>

<div class="main-panel">
    <?php include __DIR__ . '/../includes/navbar.php'; ?>

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Users Management</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="index.php">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Users</a>
                    </li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Users List</h4>
                                <button class="btn btn-primary btn-round ms-auto" id="addUserBtn">
                                    <i class="fa fa-plus"></i>
                                    Add User
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="usersTable" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Status</th>
                                            <th>Created</th>
                                            <th style="width: 10%">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include __DIR__ . '/../includes/footer.php'; ?>
</div>

<!-- Add User Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="userModalTitle">Add New User</h5>
                <button type="button" class="close" data-bs-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="userForm">
                    <input type="hidden" id="userId" value="">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="userName">Name</label>
                                <input type="text" class="form-control" id="userName" placeholder="Enter name" required>
                            </div>
                        </div>
                        <div class="col-md-6 pe-0">
                            <div class="form-group">
                                <label for="userEmail">Email</label>
                                <input type="email" class="form-control" id="userEmail" placeholder="Enter email" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="userRole">Role</label>
                                <select class="form-control" id="userRole">
                                    <option value="Admin">Admin</option>
                                    <option value="User">User</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-0">
                <button type="button" class="btn btn-primary" id="saveUserBtn">Save</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        var table = $('#usersTable').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?= BASE_URL ?>actions/fetch_users.php",
                "type": "POST"
            },
            "pageLength": 10,
            "responsive": true,
            "order": [
                [0, "desc"]
            ],
            "columns": [{
                    "data": "id"
                },
                {
                    "data": "name"
                },
                {
                    "data": "email"
                },
                {
                    "data": "role"
                },
                {
                    "data": "status"
                },
                {
                    "data": "created"
                },
                {
                    "data": "action",
                    "orderable": false,
                    "searchable": false
                }
            ],
            "language": {
                "lengthMenu": "Show _MENU_ entries",
                "search": "Search:",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                }
            }
        });

        // ✅ Reset modal on hide
        $('#userModal').on('hide.bs.modal', function() {
            document.activeElement.blur();
        });

        // ✅ Open Add User modal
        $("#addUserBtn").on("click", function() {
            $("#userForm")[0].reset();
            $("#userId").val("");
            $("#userModalTitle").text("Add New User");
            $("#saveUserBtn").text("Add");
            $("#userModal").modal("show");
        });

        // ✅ Open Edit User modal
        $(document).on("click", ".editBtn", function() {
            let id = $(this).data("id");
            $.ajax({
                url: "actions/get_users.php",
                type: "POST",
                data: {
                    id: id
                },
                dataType: "json",
                success: function(user) {
                    if (user.error) {
                        alert(user.error);
                        return;
                    }

                    $("#userId").val(user.id);
                    $("#userName").val(user.name);
                    $("#userEmail").val(user.email);
                    $("#userRole").val(user.role);

                    $("#userModalTitle").text("Edit User");
                    $("#saveUserBtn").text("Update");
                    $("#userModal").modal("show");
                },
                error: function(xhr) {
                    console.error("❌ Error fetching user:", xhr.responseText);
                }
            });
        });

        // ✅ Save (Insert/Update)
        $("#saveUserBtn").on("click", function() {
            let id = $("#userId").val();
            let name = $("#userName").val().trim();
            let email = $("#userEmail").val().trim();
            let role = $("#userRole").val();

            if (name === "" || email === "") {
                swal("Error", "Name and Email are required", "error");
                return;
            }

            let action = id ? "update" : "insert";

            $.post("actions/users_crud.php", {
                action: action,
                id: id,
                name: name,
                email: email,
                role: role
            }, function(res) { // 👈 res is already parsed if PHP sends JSON
                if (res.status === "success") {
                    swal({
                        icon: "success",
                        title: id ? "Updated!" : "Added!",
                        text: "User has been " + (id ? "updated." : "added."),
                        timer: 1500,
                        buttons: false
                    });
                    $("#userModal").modal("hide");
                    table.ajax.reload(null, false);
                } else {
                    swal("Error", res.message || "Something went wrong!", "error");
                }
            }, "json");
        });

        // ✅ Delete with SweetAlert
        $(document).on("click", ".deleteBtn", function() {
            var id = $(this).data("id");

            swal({
                title: "Are you sure?",
                text: "This record will be deleted permanently.",
                icon: "warning",
                buttons: true,
                dangerMode: true
            }).then((willDelete) => {
                if (willDelete) {
                    $.post("actions/users_crud.php", {
                        action: "delete",
                        id: id
                    }, function(response) {
                        try {
                            let res = JSON.parse(response);
                            if (res.status === "success") {
                                swal("Deleted!", "Record has been deleted.", "success");
                                table.ajax.reload(null, false);
                            } else {
                                swal("Error!", res.message || "Unable to delete record.", "error");
                            }
                        } catch (e) {
                            console.error("Invalid response:", response);
                            swal("Error", "Invalid response from server", "error");
                        }
                    });
                }
            });
        });
    });
</script>