<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="modalProfileLabel">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalProfileLabel">Update Profile</h5>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>

            <div class="modal-body">
                <form id="profileForm" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" id="user_id">

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
                                <label>Email Address</label>
                                <input class="form-control" type="email" name="email">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>Address</label>
                                <input class="form-control" type="text" name="address">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>Facebook Link</label>
                                <input class="form-control" type="text" name="facebook_link">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Role</label>
                        <input class="form-control" type="text" name="role" readonly>
                    </div>

                    <div class="form-group" style="margin-bottom: 30px;">
                        <label>Profile Image</label>
                        <input type="file" name="image" class="form-control-file form-control height-auto">
                        <img id="imagePreview" src="" alt="Preview" style="width:110px; height: 120px; display:block; margin-top:10px; border-radius: 8px; object-fit: cover; border:1px solid #104F58;">
                    </div>

                    <div style="text-align:center; border-bottom:1px solid #ccc; line-height:0.1em; margin:10px 0 20px;">
                        <span style="background:#fff; padding:0 10px; color: #DC3545;">Use for login credentials</span>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>Username<span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="username">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label>Password</label>
                                <input class="form-control" type="text" name="password" placeholder="Leave blank to keep current">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="saveProfileBtn">Save changes</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $(document).on('click', '#openProfileModal', function(e) {
            e.preventDefault();

            $.ajax({
                url: '../includes/user_update/fetch_profile.php',
                type: 'GET',
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        const u = res.data;
                        $('#user_id').val(u.id);
                        $('[name="firstname"]').val(u.firstname);
                        $('[name="lastname"]').val(u.lastname);
                        $('[name="contact"]').val(u.contact);
                        $('[name="email"]').val(u.email);
                        $('[name="address"]').val(u.address);
                        $('[name="facebook_link"]').val(u.facebook_link);
                        $('[name="role"]').val(u.role);
                        $('[name="username"]').val(u.username);
                        $('[name="password"]').val('');

                        if (u.image) {
                            $('#imagePreview').attr('src', '../uploads/users/' + u.image).show();
                        } else {
                            $('#imagePreview').hide();
                        }

                        $('#profileModal').modal('show');
                    } else {
                        toastr.error(res.message, "Error");
                    }
                },
                error: () => Swal.fire('Error', 'Failed to fetch data.', 'error')
            });
        });

        // 🔹 Save changes
        $('#saveProfileBtn').on('click', function() {
            const formData = new FormData($('#profileForm')[0]);

            $.ajax({
                url: '../includes/user_update/update_profile.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        toastr.success("Profile updated successfully!", "Success");
                        $('#profileModal').modal('hide');
                    } else {
                        toastr.error(res.message, "Error");
                    }
                },
                error: () => toastr.error('Something went wrong.', 'Error')
            });
        });

        $('#profileModal').on('hide.bs.modal', function() {
            document.activeElement.blur();
        });
    });
</script>