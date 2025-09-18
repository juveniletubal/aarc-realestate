<?php
require_once __DIR__ . '/../includes/init.php';

$page->setTitle('AARC - Properties');
$page->setCurrentPage('properties');

loadCoreAssets($assets, 'table');

include __DIR__ . '/../includes/header.php';
?>

<?php
include __DIR__ . '/../includes/navbar.php';
include __DIR__ . '/../includes/sidebar.php';
?>

<style>
    .dropzone {
        border: 2px dashed #007bff;
        border-radius: 8px;
    }
</style>

<div class="main-container">
    <div class="pd-ltr-20 xs-pd-20-10">
        <div class="min-height-200px">

            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>List of Property</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active text-info" aria-current="page">
                                    Properties
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
                                <th class="table-plus">Title</th>
                                <th>Lot Area</th>
                                <th>Price</th>
                                <th>Location</th>
                                <th>Type</th>
                                <th>Created</th>
                                <th class="datatable-nosort" style="width: 7%;">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>


    <!-- Add/Edit Property Modal -->
    <div class="modal fade" id="propertyModal" tabindex="-1" role="dialog" aria-labelledby="propertyModalLabel">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="propertyModalLabel">Add New Property</h5>
                    <button type="button" class="close" data-dismiss="modal"> × </button>
                </div>
                <div class="modal-body">
                    <form id="propertyForm">
                        <input type="hidden" name="id" id="id" value="">

                        <div class="form-group">
                            <label>Property Title</label>
                            <input class="form-control" type="text" name="title" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea class="form-control" style="height:100px;" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Lot Area (sqm)</label>
                            <input class="form-control" type="text" name="lot_area">
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input class="form-control" type="text" name="price" required>
                        </div>
                        <div class="form-group">
                            <label>Location (Barangay, City, Province)</label>
                            <input class="form-control" type="text" name="location">
                        </div>
                        <div class="form-group">
                            <label>Property Type</label>
                            <select class="custom-select" name="property_type" required>
                                <option value="">Choose...</option>
                                <option value="Residential">Residential</option>
                                <option value="Commercial">Commercial</option>
                                <option value="Agricultural">Agricultural</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Property Images</label>
                            <div class="dropzone rounded" id="propertyDropzone"></div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="savePropertyBtn">Save changes</button>
                </div>
            </div>
        </div>
    </div>

</div>


<?php include __DIR__ . '/../includes/footer.php'; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        Dropzone.autoDiscover = false;

        $(document).ready(function() {
            let propertyDropzone;
            let currentPropertyId = null;
            let removedImages = [];
            let propertyTable;

            // Initialize DataTable
            initializeDataTable();

            // Initialize DataTable
            function initializeDataTable() {
                propertyTable = $(".data-table").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "property/property_fetch.php",
                        type: "POST",
                        error: function(xhr, error, code) {
                            console.log('DataTable Ajax Error:');
                            console.log('Status:', xhr.status);
                            console.log('Response:', xhr.responseText);
                            console.log('Error:', error);
                            console.log('Code:', code);

                            // Show user-friendly error
                            toastr.error('Failed to load property data. Please refresh the page.', 'Error');
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
                            data: "title"
                        },
                        {
                            data: "lot_area"
                        },
                        {
                            data: "price",
                            render: function(data) {
                                return '₱' + parseFloat(data).toLocaleString('en-US', {
                                    minimumFractionDigits: 2
                                });
                            }
                        },
                        {
                            data: "location"
                        },
                        {
                            data: "property_type"
                        },
                        {
                            data: "created",
                            render: function(data) {
                                return new Date(data).toLocaleDateString();
                            }
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
                    const propertyId = $(this).data('id');
                    editProperty(propertyId);
                });

                // Handle delete button clicks
                $('.data-table').on('click', '.delete-btn', function(e) {
                    e.preventDefault();
                    const propertyId = $(this).data('id');
                    deleteProperty(propertyId);
                });
            }

            // Initialize Dropzone
            initializeDropzone();

            // Add New Property Button
            $('#addNewBtn').on('click', function() {
                resetForm();
                $('#propertyModalLabel').text('Add New Property');
                $('#propertyModal').modal('show');
            });

            // Save Property Button
            $('#savePropertyBtn').on('click', function() {
                saveProperty();
            });

            // Initialize Dropzone
            function initializeDropzone() {
                // Check if Dropzone is already initialized and destroy it
                const dropzoneElement = document.querySelector("#propertyDropzone");

                if (dropzoneElement.dropzone) {
                    dropzoneElement.dropzone.destroy();
                }

                // Remove the dropzone class if it exists
                dropzoneElement.classList.remove('dz-clickable');

                // Clear any existing content
                dropzoneElement.innerHTML = '';

                try {
                    propertyDropzone = new Dropzone("#propertyDropzone", {
                        url: "property/property_handler.php",
                        paramName: "images",
                        maxFiles: 10,
                        acceptedFiles: "image/*",
                        addRemoveLinks: true,
                        autoProcessQueue: false,
                        parallelUploads: 10,
                        uploadMultiple: true,
                        dictDefaultMessage: "Drop images here or click to upload",
                        dictRemoveFile: "Remove",

                        init: function() {
                            this.on("addedfile", function(file) {
                                // Mark new files as completed immediately since we handle upload manually
                                if (!file.serverFileName) {
                                    // This is a new file, mark it as complete for UI purposes
                                    setTimeout(() => {
                                        file.status = Dropzone.SUCCESS;
                                        this.emit("success", file);
                                        this.emit("complete", file);
                                    }, 100);
                                }
                            });

                            this.on("removedfile", function(file) {
                                if (file.serverFileName) {
                                    removedImages.push(file.serverFileName);
                                }
                            });
                        }
                    });
                } catch (error) {
                    console.log("Dropzone initialization error:", error);
                    // Fallback: reinitialize after a short delay
                    setTimeout(() => {
                        propertyDropzone = new Dropzone("#propertyDropzone", {
                            url: "property/property_handler.php",
                            paramName: "images",
                            maxFiles: 10,
                            acceptedFiles: "image/*",
                            addRemoveLinks: true,
                            autoProcessQueue: false,
                            parallelUploads: 10,
                            uploadMultiple: true,
                            dictDefaultMessage: "Drop images here or click to upload",
                            dictRemoveFile: "Remove",

                            init: function() {
                                this.on("addedfile", function(file) {
                                    if (!file.serverFileName) {
                                        setTimeout(() => {
                                            file.status = Dropzone.SUCCESS;
                                            this.emit("success", file);
                                            this.emit("complete", file);
                                        }, 100);
                                    }
                                });

                                this.on("removedfile", function(file) {
                                    if (file.serverFileName) {
                                        removedImages.push(file.serverFileName);
                                    }
                                });
                            }
                        });
                    }, 100);
                }
            }

            function resetForm() {
                $('#propertyForm')[0].reset();
                $('#id').val('');
                currentPropertyId = null;
                removedImages = [];
                propertyDropzone.removeAllFiles(true);
            }

            function saveProperty() {
                if (!validateForm()) return;

                const isUpdate = currentPropertyId !== null;
                const formData = new FormData();

                // Add form data
                formData.append('action', isUpdate ? 'update' : 'insert');
                formData.append('title', $('input[name="title"]').val());
                formData.append('description', $('textarea[name="description"]').val());
                formData.append('lot_area', $('input[name="lot_area"]').val());
                formData.append('price', $('input[name="price"]').val());
                formData.append('location', $('input[name="location"]').val());
                formData.append('property_type', $('select[name="property_type"]').val());

                if (isUpdate) {
                    formData.append('id', currentPropertyId);
                    formData.append('removed_images', JSON.stringify(removedImages));
                }

                // Add new images
                const files = propertyDropzone.getAcceptedFiles();
                files.forEach(function(file) {
                    if (!file.serverFileName) { // Only add new files
                        formData.append('images[]', file);
                    }
                });

                $.ajax({
                    url: 'property/property_handler.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(
                                isUpdate ? "Property updated successfully!" : "Property added successfully!",
                                "Success"
                            );
                            $('#propertyModal').modal('hide');
                            loadProperties(); // Refresh your property list
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
                const title = $('input[name="title"]').val().trim();
                const description = $('textarea[name="description"]').val().trim();
                const price = $('input[name="price"]').val().trim();
                const propertyType = $('select[name="property_type"]').val();

                if (!title) {
                    toastr.error("Property title is required", "Validation Error");
                    return false;
                }

                if (!description) {
                    toastr.error("Description is required", "Validation Error");
                    return false;
                }

                if (!price) {
                    toastr.error("Price is required", "Validation Error");
                    return false;
                }

                if (!propertyType) {
                    toastr.error("Property type is required", "Validation Error");
                    return false;
                }

                return true;
            }

            // Function to edit property (call this from your edit button)
            window.editProperty = function(id) {
                $.ajax({
                    url: 'property/property_handler.php',
                    type: 'GET',
                    data: {
                        action: 'get',
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            const property = response.data;
                            populateForm(property);
                            $('#propertyModalLabel').text('Edit Property');
                            $('#propertyModal').modal('show');
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

            function populateForm(property) {
                currentPropertyId = property.id;
                removedImages = [];

                $('#id').val(property.id);
                $('input[name="title"]').val(property.title);
                $('textarea[name="description"]').val(property.description);
                $('input[name="lot_area"]').val(property.lot_area);
                $('input[name="price"]').val(property.price);
                $('input[name="location"]').val(property.location);
                $('select[name="property_type"]').val(property.property_type);

                // Clear dropzone and add existing images
                propertyDropzone.removeAllFiles(true);

                if (property.images && property.images.length > 0) {
                    property.images.forEach(function(imageName) {
                        const mockFile = {
                            name: imageName,
                            size: 12345,
                            serverFileName: imageName
                        };

                        propertyDropzone.emit("addedfile", mockFile);
                        propertyDropzone.emit("thumbnail", mockFile, "../uploads/" + imageName);
                        propertyDropzone.emit("complete", mockFile);
                    });
                }
            }

            // Function to delete property (call this from your delete button)
            window.deleteProperty = function(id) {
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
                            url: 'property/property_handler.php',
                            type: 'POST',
                            data: {
                                action: 'delete',
                                id: id
                            },
                            success: function(response) {
                                if (response.success) {
                                    toastr.success("Property deleted successfully!", "Success");
                                    loadProperties(); // Refresh your property list
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

            // Function to load properties list (implement according to your needs)
            function loadProperties() {
                if (propertyTable) {
                    propertyTable.ajax.reload(null, false); // Reload DataTable without resetting pagination
                }
            }
        });

        $('#propertyModal').on('hide.bs.modal', function() {
            document.activeElement.blur();
        });

    });
</script>