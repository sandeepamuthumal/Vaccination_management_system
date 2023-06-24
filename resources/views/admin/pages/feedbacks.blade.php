@extends('admin.layouts.app')


@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Feedbacks</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-responsive-sm">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Feedback</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $count = 1; ?>
                                    @foreach ($feedbacks as $item)
                                        <tr>
                                            <td width="10%">{{ $count++ }}</td>
                                            <td width="20%">{{ $item->user_name }}</td>
                                            <td width="30%">{{ $item->email }}</td>
                                            <td width="50%">{{ $item->feedback }}</td>
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
