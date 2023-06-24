@extends('admin.layouts.app')


@section('content')
    <div class="container-fluid">
        <!-- Add User -->
        <div class="modal fade bd-example-modal-lg" id="add-user-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add New User</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="basic-form">
                            <form id="add-user-form">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">User Level</label>
                                        <select name="user_level" class="custom-select form-control wide">
                                            <option value="" selected hidden>Choose...</option>
                                            @foreach ($user_types as $item)
                                                <option value="{{ $item->id }}">{{ $item->user_type }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger" id="user_levelError"></span>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Name</label>
                                        <input type="text" name="name" class="form-control">
                                        <span class="text-danger" id="first_nameError"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Address</label>
                                        <input type="text" name="address" class="form-control">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">NIC Number</label>
                                        <input type="text" name="nic" class="form-control">
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Date Of Birth</label>
                                        <input type="date" name="birthday" class="form-control">
                                        <span class="text-danger" id="contactError"></span>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Contact Number</label>
                                        <input type="text" name="contact_number" class="form-control">
                                        <span class="text-danger" id="contactError"></span>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Email</label>
                                        <input type="email" name="email" class="form-control">
                                        <span class="text-danger" id="emailError"></span>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Password</label>
                                        <div class="input-group transparent-append">
                                            <input type="password" class="form-control" id="add-password" name="password"
                                                required>
                                            <span class="input-group-text show-pass">
                                                <i class="fa fa-eye-slash"></i>
                                                <i class="fa fa-eye"></i>
                                            </span>

                                        </div>
                                        <span class="text-danger" id="passwordError"></span>
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

        {{-- Update User --}}

        <div class="modal fade bd-example-modal-lg" id="edit-user-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">


                <div class="modal-content">


                    <div class="modal-header">
                        <h5 class="modal-title">Update User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="basic-form">
                            <form id="edit-user-form">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">User Level</label>
                                        <select id="user_level" name="user_level" class="custom-select form-control wide">
                                            @foreach ($user_types as $item)
                                                <option value="{{ $item->id }}">{{ $item->user_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Name</label>
                                        <input type="text" name="name" id="name" class="form-control">
                                        <input type="text" name="user_id" class="form-control user_id" hidden>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Address</label>
                                        <input type="text" name="address" id="address" class="form-control">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">NIC Number</label>
                                        <input type="text" name="nic" id="nic" class="form-control">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Date Of Birth</label>
                                        <input type="date" name="birthday" id="birthday" class="form-control">

                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Contact Number</label>
                                        <input type="text" name="contact_number" id="contact_number"
                                            class="form-control">

                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Email</label>
                                        <input type="email" name="email" id="email" class="form-control">
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Password</label>
                                        <div class="input-group transparent-append">
                                            <input type="password" class="form-control" id="users-password"
                                                name="password" required>
                                            <span class="input-group-text show-users-password">
                                                <i class="fa fa-eye-slash"></i>
                                                <i class="fa fa-eye"></i>
                                            </span>
                                        </div>
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
                        <h4 class="card-title">All Users</h4>
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
                                        <th>User Level</th>
                                        <th>User Name</th>
                                        <th>Contact No </th>
                                        <th>Email </th>
                                        <th>NIC </th>
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

@push('css')
    <style>
        .show-users-password {
            cursor: pointer
        }

        .show-users-password .fa-eye {
            display: none
        }

        .show-users-password.active .fa-eye-slash {
            display: none
        }

        .show-users-password.active .fa-eye {
            display: inline-block
        }

        .show-old-password {
            cursor: pointer
        }

        .show-old-password .fa-eye {
            display: none
        }

        .show-old-password.active .fa-eye-slash {
            display: none
        }

        .show-old-password.active .fa-eye {
            display: inline-block
        }

        .show-new-password {
            cursor: pointer
        }

        .show-new-password .fa-eye {
            display: none
        }

        .show-new-password.active .fa-eye-slash {
            display: none
        }

        .show-new-password.active .fa-eye {
            display: inline-block
        }

        .show-new-confirm-password {
            cursor: pointer
        }

        .show-new-confirm-password .fa-eye {
            display: none
        }

        .show-new-confirm-password.active .fa-eye-slash {
            display: none
        }

        .show-new-confirm-password.active .fa-eye {
            display: inline-block
        }
    </style>
@endpush

@section('scripts')
    <!-- Jquery Validation -->
    <script src="./admin/vendor/jquery-validation/jquery.validate.min.js"></script>
    <!-- Form validate init -->
    <script src="./admin/js/plugins-init/jquery.validate-init.js"></script>
    <script src="./admin/js/custom.js"></script>
    <script src="./admin/js/deznav-init.js"></script>

    <script src="./admin/js/sweetalert2@11.js"></script>

    <script type="text/javascript">
        load_active_users();

        window.addEventListener("load", function() {
            setTimeout(function() {
                document.getElementById("add-password").value = "";
                document.getElementById("login_user_name").value = "";
            }, 500)
        });

        $('#myselect1').select2({
            dropdownParent: $('#add-user-modal')
        });


        $('.show-pass').on('click', function() {
            $(this).toggleClass('active');
            if ($('#add-password').attr('type') == 'password') {
                $('#add-password').attr('type', 'text');
            } else if (jQuery('#add-password').attr('type') == 'text') {
                $('#add-password').attr('type', 'password');
            }
        });

        $('.show-users-password').on('click', function() {
            $(this).toggleClass('active');
            if ($('#users-password').attr('type') == 'password') {
                $('#users-password').attr('type', 'text');
            } else if (jQuery('#users-password').attr('type') == 'text') {
                $('#users-password').attr('type', 'password');
            }
        });


        function load_active_users() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#page-loader').show();

            $.ajax({
                type: "POST",
                url: "{{ url('/users/show') }}",
                dataType: 'json',
                success: function(response) {
                    console.log("active users ..." + response);
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
                                    data: 'type',
                                    title: 'User Level'
                                },
                                {
                                    data: 'user_name',
                                    title: 'User Name'
                                },
                                {
                                    data: 'contact',
                                    title: 'Contact No'
                                },
                                {
                                    data: 'email',
                                    title: 'Email'
                                },
                                {
                                    data: 'nic',
                                    title: 'NIC'
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
                title: 'Are you sure to delete user?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete It!'
            }).then((result) => {
                if (result.isConfirmed) {

                    let url = '{{ route('delete_users', ':id') }}'
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
                            load_active_users();
                            Swal.fire(
                                'Deleted!',
                                'This user has been deleted.',
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
                    url: "{{ url('/user/edit') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        var user = response.user;
                        console.log(response.user_companies);
                        $("#btn-save").html('Update');
                        $('#edit-user-modal').modal('show');
                        $(".user_id").val(user.id);
                        $("#name").val(user.user_name);
                        $("#email").val(user.email);
                        $("#users-password").val(response.password);
                        $("#user_level").val(user.user_types_id);
                        $("#birthday").val(user.dob);
                        $('#contact_number').val(user.contact_no);
                        $('#nic').val(user.nic);
                        $("#address").val(user.address);

                        $('#page-loader').hide();
                    }
                });
            });

            $('body').on('click', '#show-add-model', function(event) {
                $("#add-btn").html('Create');

                $('#passwordError').text("");
                $('#nameError').text("");
                $('#emailError').text("");
                $('#user_levelError').text("");
                $('#add-user-form').trigger("reset");
                $('#add-user-modal').modal('show');
                $("#add-btn").attr("disabled", false);
            });

            $('body').on('click', '#add-btn', function(event) {
                let formData = new FormData($('#add-user-form')[0]);

                $('#page-loader').show();
                $("#add-btn").html('Please Wait...');
                $("#add-btn").attr("disabled", true);

                $('#passwordError').text("");
                $('#nameError').text("");
                $('#emailError').text("");
                $('#user_levelError').text("");

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('/user/store') }}",
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("#add-btn").html('User Created');
                        $("#add-btn").attr("disabled", false);
                        $('#add-user-modal').modal('hide');
                        toastr.success('Successfully Added User!', 'Success Alert', {
                            timeOut: 4000,
                            fadeOut: 1000
                        });
                        $('#page-loader').hide();
                        load_active_users();
                    },
                    error: function(response) {
                        $('#emailError').text(response.responseJSON.errors.email);
                        $('#passwordError').text(response.responseJSON.errors.password);
                        $('#user_levelError').text(response.responseJSON.errors.user_level);
                        $('#nameError').text(response.responseJSON.errors.name);

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
                    url: "{{ url('/user/update') }}",
                    data: EditformData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("#btn-save").html('Updated');
                        $("#btn-save").attr("disabled", false);
                        $('#edit-user-modal').modal('hide');
                        toastr.success('Successfully Updated User!', 'Success Alert', {
                            timeOut: 4000,
                            fadeOut: 1000
                        });
                        $('#page-loader').hide();
                        load_active_users();

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
