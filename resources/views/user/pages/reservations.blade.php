@extends('user.layouts.app')


@section('content')
    <div class="container-fluid">


        {{-- Update Reservation --}}

        <div class="modal fade bd-example-modal-lg" id="edit-user-modal" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg">


                <div class="modal-content">


                    <div class="modal-header">
                        <h5 class="modal-title">Update Reservation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="basic-form">
                            <form id="edit-reservation-form">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Center Schedule</label>
                                        <select name="schedule_name" id="schedule_name" class="custom-select form-control wide">
                                            <option value="" selected hidden>Choose center...</option>
                                            @foreach ($schedules as $schedule)
                                                <option value="{{ $schedule->id }}">{{ $schedule->center_name . ' ' . $schedule->vaccine_name }}</option>
                                            @endforeach
                                        </select>
                                        <input type="text" name="reservation_id" id="reservation_id" hidden>
                                        <span class="text-danger" id="centerError"></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label text-black font-w500">Dose</label>
                                        <select name="dose" id="dose" class="custom-select form-control wide">
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
                        <h4 class="card-title">Your Reservations</h4>
                        <a href="{{ route('schedules') }}" class="btn btn-rounded btn-outline-primary shadow btn-sm sharp"><span class="btn-icon-start text-info"><i
                                    class="fa fa-plus color-info"></i>
                            </span>Add New</a>
                    </div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="user-table" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Booking Code</th>
                                        <th>Center</th>
                                        <th>Vaccine</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Contact No</th>
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
        load_active_reservations();


        function load_active_reservations() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#page-loader').show();

            $.ajax({
                type: "POST",
                url: "{{ url('/reservations/load') }}",
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
                            columns: [
                                {
                                    data: 'code',
                                    title: 'Booking Code'
                                },
                                {
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
                                    data: 'verification',
                                    title: 'Verification'
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
                title: 'Are you sure to delete reservation?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete It!'
            }).then((result) => {
                if (result.isConfirmed) {

                    let url = '{{ route('delete_reservation', ':id') }}'
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
                            load_active_reservations();
                            Swal.fire(
                                'Deleted!',
                                'Your reservation has been deleted.',
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
                    url: "{{ url('/reservation/edit') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        var reservation = response.reservation;

                        $("#btn-save").html('Update');
                        $('#edit-user-modal').modal('show');
                        $("#reservation_id").val(reservation.id);
                        $("#schedule_name").val(reservation.center_has_vaccines_id);
                        $("#dose").val(reservation.dose);
                        $("#time").val(reservation.time);

                        $('#page-loader').hide();
                    }
                });
            });

            $('body').on('click', '#btn-save', function(event) {
                let EditformData = new FormData($('#edit-reservation-form')[0]);
                $("#btn-save").html('Please Wait...');
                $("#btn-save").attr("disabled", true);
                $('#page-loader').show();

                // ajax
                $.ajax({
                    type: "POST",
                    url: "{{ url('/reservation/update') }}",
                    data: EditformData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $("#btn-save").html('Updated');
                        $("#btn-save").attr("disabled", false);
                        $('#edit-user-modal').modal('hide');
                        toastr.success('Successfully Updated Reservation!', 'Success Alert', {
                            timeOut: 4000,
                            fadeOut: 1000
                        });
                        $('#page-loader').hide();
                        load_active_reservations();

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
