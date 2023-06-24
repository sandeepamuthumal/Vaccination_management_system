@extends('user.layouts.app')


@section('content')
    <div class="container-fluid">


        <div class="modal fade bd-example-modal-lg" id="add-reservation-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Add Reservation</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="basic-form">
                            <form id="add-reservation-form">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Center Name</label>
                                        <input type="text" id="center_name" name="center_name" class="form-control" readonly>
                                        <input type="text" name="schedule_id" id="schedule_id" class="form-control"
                                            hidden>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Center Address</label>
                                        <input type="text" name="address" id="address" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Vaccine Name</label>
                                        <input type="text" id="vaccine_name" class="form-control" readonly>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Vaccine Type</label>
                                        <input type="text" id="vaccine_type" class="form-control" readonly>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Date</label>
                                        <input type="text" name="date" id="date" class="form-control" readonly>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Dose</label>
                                        <select name="dose" class="custom-select form-control wide">
                                            <option value="" selected hidden>Choose Dose...</option>
                                            <option value="1">1 st dose</option>
                                            <option value="2">2 nd dose</option>
                                        </select>
                                        <span class="text-danger" id="doseError"></span>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Time</label>
                                        <input type="text" name="time" id="time" class="form-control">
                                        <span class="text-danger" id="timeError"></span>
                                    </div>
                                </div>

                                <div class="form-group mt-2">
                                    <button type="button" class="btn btn-primary float-end btn-shadow"
                                        id="add-btn">CONFIRM</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Center Schedules</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Center</th>
                                        <th>Vaccine</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Available Count</th>
                                        <th>Contact No</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1; ?>
                                    @foreach ($schedules as $item)
                                        <tr>
                                            <td>{{ $count++ }}</td>
                                            <td>{{ $item->center_name }}</td>
                                            <td>{{ $item->vaccine_name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td>{{ $item->time }}</td>
                                            <td>{{ $item->count }}</td>
                                            <td>{{ $item->contact_no }}</td>
                                            <td><button type="button" class="btn btn-warning btn-xs"
                                                    onclick="center_book({{ $item->id }})">
                                                    Book</button>
                                            </td>
                                        </tr>
                                    @endforeach
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
        function load_active_schedules() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#page-loader').show();

            $.ajax({
                type: "POST",
                url: "{{ url('/centers/vaccines/show') }}",
                dataType: 'json',
                success: function(response) {
                    console.log("active schedules ..." + response);
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
                                    data: 'center_name',
                                    title: 'Center'
                                },
                                {
                                    data: 'vaccine_name',
                                    title: 'Vaccine'
                                },
                                {
                                    data: 'date',
                                    title: 'Date'
                                },
                                {
                                    data: 'time',
                                    title: 'Time'
                                },
                                {
                                    data: 'ava_count',
                                    title: 'Available Count'
                                },
                                {
                                    data: 'contact_no',
                                    title: 'Contact No'
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
                title: 'Are you sure to delete schedule?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete It!'
            }).then((result) => {
                if (result.isConfirmed) {

                    let url = '{{ route('delete_center_vaccine', ':id') }}'
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
                            load_active_schedules();
                            Swal.fire(
                                'Deleted!',
                                'This schedule has been deleted.',
                                'success'
                            );

                        }
                    })

                }
            })
        }

        function center_book(schedule_id) {
            $('#page-loader').show();
            $('#doseError').text("");
            $('#timeError').text("");

            // ajax
            $.ajax({
                type: "GET",
                url: "{{ url('/reservation/add') }}",
                data: {
                    id: schedule_id
                },
                dataType: 'json',
                success: function(response) {
                    var schedule = response.schedule;

                    $('#add-reservation-modal').modal('show');
                    $("#schedule_id").val(schedule.id);
                    $("#center_name").val(schedule.center_name);
                    $("#vaccine_name").val(schedule.vaccine_name);
                    $("#date").val(schedule.date);
                    $("#vaccine_type").val(schedule.type);
                    $('#address').val(schedule.address);

                    $('#page-loader').hide();
                }
            });
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('body').on('click', '#add-btn', function(event) {
                let formData = new FormData($('#add-reservation-form')[0]);

                $('#page-loader').show();
                $("#add-btn").html('Please Wait...');
                $("#add-btn").attr("disabled", true);

                $('#doseError').text("");
                $('#timeError').text("");

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('/reservation/store') }}",
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        Swal.fire('Check your mails and verify your reservation');
                        $("#add-btn").attr("disabled", false);
                        $("#add-btn").html('CONFIRM');
                        $('#add-reservation-modal').modal('hide');
                        toastr.success('Successfully Added Reservation!', 'Success Alert', {
                            timeOut: 4000,
                            fadeOut: 1000
                        });
                        $('#page-loader').hide();

                        let url = '{{ route('reservations') }}';
                        window.location.href = url;
                    },
                    error: function(response) {
                        $('#doseError').text(response.responseJSON.errors.dose);
                        $('#timeError').text(response.responseJSON.errors.time);


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
                    url: "{{ url('/centers/vaccines/update') }}",
                    data: EditformData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("#btn-save").html('Updated');
                        $("#btn-save").attr("disabled", false);
                        $('#edit-user-modal').modal('hide');
                        toastr.success('Successfully Updated Schedule!', 'Success Alert', {
                            timeOut: 4000,
                            fadeOut: 1000
                        });
                        $('#page-loader').hide();
                        load_active_schedules();

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
