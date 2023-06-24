@extends('admin.layouts.app')


@section('content')
    <div class="container-fluid">
        <!-- Add User -->
        <div class="modal fade bd-example-modal-lg" id="add-user-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add New Vaccine</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="basic-form">
                            <form id="add-user-form">
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label text-black font-w500">Vaccine Name</label>
                                        <input type="text" name="name" class="form-control">
                                        <span class="text-danger" id="nameError"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label text-black font-w500">Vaccine Details</label>
                                        <textarea class="form-control" rows="4" name="vaccine_details"></textarea>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label text-black font-w500">Vaccine Type</label>
                                        <select name="type" class="custom-select form-control wide">
                                            <option value="" selected hidden>Choose...</option>
                                            <option value="Covi shield">Covi shield</option>
                                            <option value="Pfizer">Pfizer</option>
                                            <option value="Sinopharm">Sinopharm</option>
                                            <option value="Moderna">Moderna</option>
                                        </select>
                                        <span class="text-danger" id="typeError"></span>
                                    </div>
                                </div>

                                <div class="form-group mt-2">
                                    <button type="button" class="btn btn-primary float-end btn-shadow"
                                        id="add-btn">CREATE</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- row -->

        {{-- Update Vaccine --}}

        <div class="modal fade bd-example-modal-lg" id="edit-user-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">


                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Update Vaccine</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="basic-form">
                            <form id="edit-user-form">
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label text-black font-w500">Vaccine Name</label>
                                        <input type="text" name="name" id="name" class="form-control">
                                        <input type="text" name="vaccine_id" id="vaccine_id" class="form-control" hidden>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label text-black font-w500">Vaccine Details</label>
                                        <textarea class="form-control" rows="4" name="vaccine_details" id="vaccine_details"></textarea>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label text-black font-w500">Vaccine Type</label>
                                        <input type="text" name="type" id="type" class="form-control">
                                    </div>
                                </div>

                            </form>
                        </div>

                        <div class="form-group">
                            <button type="button" class="btn btn-primary float-end btn-shadow"
                                id="btn-save">Update</button>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Vaccines</h4>
                        <button type="button" class="btn btn-rounded btn-outline-primary shadow btn-sm sharp "
                            id="show-add-model"><span class="btn-icon-start text-info"><i
                                    class="fa fa-plus color-info"></i>
                            </span>Add New</button>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="user-table" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Vaccine Name</th>
                                        <th>Vaccine Details </th>
                                        <th>Vaccine Type </th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>


            </div>

        </div>



    </div>





    </div>
@endsection

@section('scripts')
    <!-- Jquery Validation -->
    <script src="./admin/vendor/jquery-validation/jquery.validate.min.js"></script>
    <!-- Form validate init -->
    <script src="./admin/js/plugins-init/jquery.validate-init.js"></script>
    <script src="./admin/js/custom.js"></script>
    <script src="./admin/js/deznav-init.js"></script>

    <script src="./admin/js/sweetalert2@11.js"></script>

    <script type="text/javascript">
        load_active_vaccines();

        window.addEventListener("load", function() {
            setTimeout(function() {
                document.getElementById("add-password").value = "";
                document.getElementById("login_user_name").value = "";
            }, 500)
        });

        $('#myselect1').select2({
            dropdownParent: $('#add-user-modal')
        });

        function load_active_vaccines() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#page-loader').show();

            $.ajax({
                type: "POST",
                url: "{{ url('/vaccines/show') }}",
                dataType: 'json',
                success: function(response) {
                    console.log("active vaccines ..." + response);
                    if (response !== "No-data") {

                        var table = $('#user-table').DataTable({
                            createdRow: function(row, data, index) {
                                $(row).addClass('selected')
                            },
                            language: {
                                paginate: {
                                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                                }
                            },
                            dom: 'Blfrtip',
                            buttons: [],
                            pageLength: 25,
                            lengthChange: true,
                            "order": [],
                            destroy: true,
                            tooltip: true,
                            data: response,
                            columns: [{
                                    data: 'count',
                                    title: '#'
                                },
                                {
                                    data: 'name',
                                    title: 'Vaccine Name'
                                },
                                {
                                    data: 'details',
                                    title: 'Vaccine Details'
                                },
                                {
                                    data: 'type',
                                    title: 'Vaccine Type'
                                },
                                {
                                    data: 'edit_button',
                                    title: 'Action'
                                },
                            ]

                        });

                    } else {

                        var table =
                            "<tr class=\"odd\"><td valign=\"top\" colspan=\"6\" class=\"dataTables_empty\">No active users available in table</td></tr>";

                        document.getElementById("user-table").innerHTML = table;

                    }

                    table.on('click', 'tbody tr', function() {
                        var $row = table.row(this).nodes().to$();
                        var hasClass = $row.hasClass('selected');
                        if (hasClass) {
                            $row.removeClass('selected')
                        } else {
                            $row.addClass('selected')
                        }
                    })

                    table.rows().every(function() {
                        this.nodes().to$().removeClass('selected')
                    });

                    $('#page-loader').hide();

                }
            });
        }

        function deleteData(data) {
            Swal.fire({
                title: 'Are you sure to delete vaccine?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete It!'
            }).then((result) => {
                if (result.isConfirmed) {

                    let url = '{{ route('delete_vaccines', ':id') }}'
                    url = url.replace(':id', data)

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        type: 'POST',
                        url: url,
                        success: function() {
                            load_active_vaccines();
                            Swal.fire(
                                'Deleted!',
                                'This vaccine has been deleted.',
                                'success'
                            );

                        }
                    })

                }
            })
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('body').on('click', '.edit', function() {
                var id = $(this).data('id');

                $('#edit-user-modal').modal('show');

                $('#page-loader').show();

                // ajax
                $.ajax({
                    type: "GET",
                    url: "{{ url('/vaccine/edit') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        var vaccine = response.vaccine;
                        $("#btn-save").html('Update');
                        $('#edit-user-modal').modal('show');
                        $("#vaccine_id").val(vaccine.id);
                        $("#name").val(vaccine.name);
                        $("#vaccine_details").val(vaccine.vaccine_details);
                        $("#type").val(vaccine.type);

                        $('#page-loader').hide();
                    }
                });
            });

            $('body').on('click', '#show-add-model', function(event) {
                $("#add-btn").html('Create');

                $('#nameError').text("");
                $('#typeError').text("");
                $('#add-user-form').trigger("reset");
                $('#add-user-modal').modal('show');
                $("#add-btn").attr("disabled", false);
            });

            $('body').on('click', '#add-btn', function(event) {
                let formData = new FormData($('#add-user-form')[0]);

                $('#page-loader').show();
                $("#add-btn").html('Please Wait...');
                $("#add-btn").attr("disabled", true);

                $('#nameError').text("");
                $('#typeError').text("");

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('/vaccine/store') }}",
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("#add-btn").html('Vaccine Created');
                        $("#add-btn").attr("disabled", false);
                        $('#add-user-modal').modal('hide');
                        toastr.success('Successfully Added Vaccine!', 'Success Alert', {
                            timeOut: 4000,
                            fadeOut: 1000
                        });
                        $('#page-loader').hide();
                        load_active_vaccines();
                    },
                    error: function(response) {
                        $('#nameError').text(response.responseJSON.errors.name);
                        $('#typeError').text(response.responseJSON.errors.type);

                        $("#add-btn").html('Try Again');
                        $("#add-btn").attr("disabled", false);
                        $('#page-loader').hide();
                    }
                });
            });

            $('body').on('click', '#btn-save', function(event) {
                let EditformData = new FormData($('#edit-user-form')[0]);
                $("#btn-save").html('Please Wait...');
                $("#btn-save").attr("disabled", true);
                $('#page-loader').show();

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('/vaccine/update') }}",
                    data: EditformData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("#btn-save").html('Updated');
                        $("#btn-save").attr("disabled", false);
                        $('#edit-user-modal').modal('hide');
                        toastr.success('Successfully Updated Vaccine!', 'Success Alert', {
                            timeOut: 4000,
                            fadeOut: 1000
                        });
                        $('#page-loader').hide();
                        load_active_vaccines();

                    },
                    error: function(response) {
                        console.log(response);
                        toastr.error(response.responseJSON.errors, 'Error Alert', {
                            timeOut: 4000,
                            fadeOut: 1000
                        });
                        $("#btn-save").html('Try Again');
                        $("#btn-save").attr("disabled", false);
                        $('#page-loader').hide();
                    }
                });
            });
        });
    </script>
@endsection
