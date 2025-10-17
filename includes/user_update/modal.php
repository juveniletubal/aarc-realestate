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
                                <label for="f_name">Fistname<span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="firstname2" id="f_name" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="l_name">Lastname<span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="lastname2" id="l_name" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="cont_act">Contact Number<span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="contact2" id="cont_act" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="mail">Email Address</label>
                                <input class="form-control" type="email" name="email2" id="mail">
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="a_ddress">Address</label>
                                <input class="form-control" type="text" name="address2" id="a_ddress">
                            </div>
                        </div>
                        <?php if ($_SESSION['role'] !== 'client'): ?>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="fbLink">Facebook Link</label>
                                    <input class="form-control" type="text" name="facebook_link2" id="fbLink">
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12" style="display: none;">
                            <div class="form-group">
                                <label for="role2">Role</label>
                                <input class="form-control" type="text" id="role2" disabled>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="registered">Date Registered</label>
                                <input class="form-control" type="text" id="registered" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="form-group" style="margin-bottom: 30px;">
                        <label for="imageInput">Profile Image</label>
                        <input type="file" name="image" id="imageInput" class="form-control-file form-control height-auto">
                        <img id="imagePreview" src="" alt="Preview" style="width:110px; height: 120px; display:block; margin-top:10px; border-radius: 8px; object-fit: cover; border:1px solid #104F58;">
                    </div>

                    <div style="text-align:center; border-bottom:1px solid #ccc; line-height:0.1em; margin:10px 0 20px;">
                        <span style="background:#fff; padding:0 10px; color: #DC3545;">Use for login credentials</span>
                    </div>

                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="usernameProfile">Username<span class="text-danger">*</span></label>
                                <input class="form-control" type="text" name="username2" id="usernameProfile">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group">
                                <label for="passwordProfile">Password</label>
                                <input class="form-control" type="text" name="password2" id="passwordProfile" placeholder="Leave blank to keep current">
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
                        $('[name="firstname2"]').val(u.firstname);
                        $('[name="lastname2"]').val(u.lastname);
                        $('[name="contact2"]').val(u.contact);
                        $('[name="email2"]').val(u.email);
                        $('[name="address2"]').val(u.address);
                        $('[name="facebook_link2"]').val(u.facebook_link);
                        $('#role2').val(u.role.charAt(0).toUpperCase() + u.role.slice(1));
                        $('[name="username2"]').val(u.username);
                        $('[name="password2"]').val('');

                        const date = new Date(u.created_at.replace(' ', 'T'));
                        const formatted = date.toLocaleString('en-PH', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                        $('#registered').val(formatted);

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