<?php
require_once __DIR__ . '/../includes/init.php';

$page->setTitle('AARC - Payments');
$page->setCurrentPage('payments');

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
                            <h4>List of Payments</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="index">Dashboard</a>
                                </li>
                                <li class="breadcrumb-item active text-success" aria-current="page">
                                    Payments
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
                                <th>Client Name</th>
                                <th>Property</th>
                                <th>Location</th>
                                <th>Amount Paid</th>
                                <th>Payment Date</th>
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

    <div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Add New Payment</h5>
                    <button type="button" class="close" data-dismiss="modal"> × </button>
                </div>
                <div class="modal-body">
                    <form id="dataForm">
                        <input type="hidden" name="id" id="id" value="">

                        <div class="form-group">
                            <label for="clientSelect">Client Name<span class="text-danger">*</span></label>
                            <select class="custom-select2 form-control" id="clientSelect" name="client_id" required>
                            </select>
                        </div>

                        <div class="form-group" style="display: none;">
                            <label for="propertySelect">Property</label>
                            <select class="custom-select" id="propertySelect" name="property_id">
                                <option value="">Choose...</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="amount_paid">Amount Paid<span class="text-danger">*</span></label>
                            <input class="form-control" type="text" name="amount" id="amount_paid" required>
                        </div>

                        <div class="form-group">
                            <label for="date_paid">Payment Date<span class="text-danger">*</span></label>
                            <input class="form-control" placeholder="Select Date" name="date_paid" id="date_paid" type="date">
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

            initializeDataTable();

            function initializeDataTable() {
                dataTable = $(".data-table").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "payment/payment_fetch.php",
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
                        [5, "desc"]
                    ],
                    columns: [{
                            data: "fullname"
                        },
                        {
                            data: "property_title"
                        },
                        {
                            data: "location"
                        },
                        {
                            data: "amount_paid"
                        },
                        {
                            data: "payment_date"
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

                $('.data-table').on('click', '.edit-btn', function(e) {
                    e.preventDefault();
                    const dataId = $(this).data('id');
                    editData(dataId);
                });
            }

            $('#addNewBtn').on('click', function() {
                resetForm();
                $('#modalLabel').text('Add New Payment');
                $('#saveBtn').text('Save changes').attr('class', 'btn btn-success');
                $('#dataModal').modal('show');
                loadClients();
            });

            $('#saveBtn').on('click', function() {
                if (!validateForm()) return;

                const clientName = $('#clientSelect option:selected').text();
                const amount = $('input[name="amount"]').val();
                const datePaid = $('input[name="date_paid"]').val();

                Swal.fire({
                    title: 'Confirm Save',
                    html: `
                        <div style="text-align: left; font-size: 16px; padding-top: 8px;">
                            <p><strong>Client:</strong> ${clientName}</p>
                            <p><strong>Amount Paid:</strong> ₱${amount}</p>
                            <p><strong>Date Paid:</strong> ${datePaid}</p>
                        </div>
                    `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#086C55',
                    cancelButtonColor: '#A4A4A4',
                    confirmButtonText: 'Yes, save it',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        saveData();
                    }
                });
            });

            function resetForm() {
                $('#dataForm')[0].reset();
                $('#id').val('');
                currentId = null;
            }

            function saveData() {
                const isUpdate = currentId !== null;
                const formData = new FormData();

                formData.append('action', isUpdate ? 'update' : 'insert');
                formData.append('client_id', $('select[name="client_id"]').val());
                formData.append('property_id', $('select[name="property_id"]').val());
                formData.append('amount', $('input[name="amount"]').val());
                formData.append('date_paid', $('input[name="date_paid"]').val());

                if (isUpdate) {
                    formData.append('id', currentId);
                }

                $.ajax({
                    url: 'payment/payment_handler.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.success) {
                            toastr.success(
                                isUpdate ? "Payment updated successfully!" : "Payment added successfully!",
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
                const client_id = $('select[name="client_id"]').val();
                const amount = $('input[name="amount"]').val().trim();
                const date_paid = $('input[name="date_paid"]').val().trim();

                if (!client_id) {
                    toastr.error("Client Name is required", "Validation Error");
                    return false;
                }
                if (!amount) {
                    toastr.error("Amount paid is required", "Validation Error");
                    return false;
                }
                if (!date_paid) {
                    toastr.error("Date paid is required", "Validation Error");
                    return false;
                }

                return true;
            }

            window.editData = function(id) {
                $.ajax({
                    url: 'payment/payment_handler.php',
                    type: 'GET',
                    data: {
                        action: 'get',
                        id: id
                    },
                    success: function(response) {
                        if (response.success) {
                            const record = response.data;
                            populateForm(record);
                            $('#modalLabel').text('Edit Payment');
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
                $('input[name="amount"]').val(record.amount_paid);
                $('input[name="date_paid"]').val(record.payment_date);
                loadClients(record.client_id, record.property_id);
            }

            function loadProperties() {
                if (dataTable) {
                    dataTable.ajax.reload(null, false);
                }
            }
        });

        $('#dataModal').on('hide.bs.modal', function() {
            document.activeElement.blur();
        });

        function loadClients(selectedClientId = null, selectedPropertyId = null) {
            $.ajax({
                url: "payment/client_fetch.php",
                method: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        const $clientSelect = $("#clientSelect");
                        $clientSelect.empty().append('<option value="">Choose...</option>');

                        response.data.forEach(item => {
                            $clientSelect.append(
                                `<option value="${item.client_id}">${item.client_name} (${item.property_title})</option>`
                            );
                        });

                        if (selectedClientId) {
                            $clientSelect.val(selectedClientId).trigger("change");
                            loadProperties(selectedClientId, selectedPropertyId);
                        }
                    } else {
                        toastr.error("Failed to load clients");
                    }
                },
                error: function() {
                    toastr.error("Error fetching clients");
                }
            });
        }

        $(document).on("change", "#clientSelect", function() {
            const clientId = $(this).val();
            loadProperties(clientId);
        });


        function loadProperties(clientId, selectedPropertyId = null) {
            const $propertySelect = $("#propertySelect");
            $propertySelect.empty().append('<option value="">Choose...</option>');

            $propertySelect.off('change');

            if (!clientId) return;

            $.ajax({
                url: "payment/property_fetch.php",
                method: "GET",
                data: {
                    client_id: clientId
                },
                dataType: "json",
                success: function(response) {
                    if (response.success && response.data.length > 0) {
                        response.data.forEach(item => {
                            $propertySelect.append(
                                `<option value="${item.id}">${item.property_title}</option>`
                            );
                        });

                        if (response.data.length === 1) {
                            $propertySelect
                                .val(response.data[0].id)
                                .trigger('change');
                            $propertySelect.find('option[value=""]').remove();
                        } else if (selectedPropertyId) {
                            $propertySelect.val(selectedPropertyId).trigger('change');
                        }

                    } else {
                        toastr.warning("No property found for this client.");
                    }
                },
                error: function() {
                    toastr.error("Error fetching properties");
                }
            });
        }

    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        $(document).ready(function() {
            $('#clientSelect').select2({
                placeholder: "",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#dataModal')
            });

            $('#clientSelect').select2({
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
    });
</script>

<script>
    document.getElementById('amount_paid').addEventListener('input', function() {
        this.value = this.value
            .replace(/[^0-9.]/g, '')
            .replace(/(\..*?)\..*/g, '$1')
            .replace(/^(\d+)(\.\d{0,2}).*$/, '$1$2');
    });
</script>