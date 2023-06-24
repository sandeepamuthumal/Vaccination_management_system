@extends('admin.layouts.app')


@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Reservations</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>User Name</th>
                                        <th>Booking Code</th>
                                        <th>Center</th>
                                        <th>Vaccine</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reservations as $item)
                                        <tr>
                                            <td>{{ $item->user_name }}</td>
                                            <td>{{ $item->token }}</td>
                                            <td>{{ $item->center_name }}</td>
                                            <td>{{ $item->vaccine_name }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td>{{ $item->time }}</td>
                                            <td>
                                                @if ($item->status == 1)
                                                    <span class="badge light badge-success">Success</span>
                                                @else
                                                    <a href="{{ url('reservation/complete',$item->id) }}" class="badge light badge-danger">Pending</a>
                                                @endif
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
                        $("#schedule_id").val(schedule.id);
                        $("#center_name").val(schedule.center_id);
                        $("#vaccine_name").val(schedule.vaccines_id);
                        $("#date").val(schedule.date);
                        $("#time").val(schedule.time);
                        $("#count").val(schedule.count);
                        $('#contact_number').val(schedule.contact_no);

                        $('#page-loader').hide();
                    }
                });
            });

            $('body').on('click', '#show-add-model', function(event) {
                $("#add-btn").html('Create');

                $('#centerError').text("");
                $('#vaccineError').text("");
                $('#add-user-form').trigger("reset");
                $('#add-user-modal').modal('show');
                $("#add-btn").attr("disabled", false);
            });

           

            $('body').on('click', '#btn-save', function(event) {
                let EditformData = new FormData($('#edit-user-form')[0]);
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
