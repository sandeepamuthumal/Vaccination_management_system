@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row">
        <div class="card" style="background-image:url(/admin_page/images/doctordesk.jpg);">
            <div class="card-body">
                <div class="align-items-center" style="height:100%;margin-bottom:30%">
                    <h1>Your Health is our priority..<br>Let's together build a covid-19 free nation..</h1><br>
                            <p class="text-primary" style="text-align:center;color:black;font-size:40px;top:35%;text-transform:uppercase"><B>WELCOME {{ Session::get('vaccine_log_user_name') }}</B></p><br>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
