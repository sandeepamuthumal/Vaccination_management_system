<!DOCTYPE html>
<html>
<head>
    <title>Vaccination Management System </title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 15px;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/cal.png') }}">
</head>

<body style="background-image:url(/images/bookback.jpg)">

    <div class="header">
        <ul>
            <li style="float:left;border-right:none"><a href="{{ url('/') }}" class="logo"><img
                        src="{{ asset('images/cal.png') }}" width="30px" height="30px"><strong> SL-Covid 19 </strong>
                    Vaccination Management System</a>
            </li>
            <li><a href="{{ url('/locate') }}">Locate Us</a></li>
            <li><a href="{{ url('/contact/to') }}">Contact</a></li>
            <li><a href="{{ url('/center/schedule') }}">Center Schedule</a></li>
            <li><a href="{{ url('/') }}">Home</a></li>

        </ul>
    </div>
    <div class="tblcontainer">

        <table class="table table-striped table-bordered no-footer dataTable" id="schedule-field" role="grid"
            aria-describedby="schedule-field_info" style=" ">
            <colgroup>
                <col width="5%">
                <col width="10%">
                <col width="15%">
                <col width="20%">
                <col width="10%">
                <col width="10%">
                <col width="10%">


            </colgroup>
            <thead>
                <tr role="row">
                    <th class="text-center sorting" tabindex="0" aria-controls="schedule-field" rowspan="1"
                        colspan="1" style="width: 10.3375px;" aria-label="#: activate to sort column ascending">#
                    </th>
                    <th class="text-center sorting" tabindex="0" aria-controls="schedule-field" rowspan="1"
                        colspan="1" style="width: 37.9125px;" aria-label="Date: activate to sort column ascending">
                        Date</th>
                    <th class="text-center sorting" tabindex="0" aria-controls="schedule-field" rowspan="1"
                        colspan="1" style="width: 42.6125px;" aria-label="Bus: activate to sort column ascending">
                        Time</th>
                    <th class="text-center sorting_asc" tabindex="0" aria-controls="schedule-field" rowspan="1"
                        colspan="1" style="width: 69.0875px;"
                        aria-label="Location: activate to sort column descending" aria-sort="ascending">Center</th>
                    <th class="text-center sorting" tabindex="0" aria-controls="schedule-field" rowspan="1"
                        colspan="1" style="width: 82.5375px;"
                        aria-label="Departure: activate to sort column ascending">Vaccine</th>
                    <th class="text-center sorting" tabindex="0" aria-controls="schedule-field" rowspan="1"
                        colspan="1" style="width: 90.0625px;"
                        aria-label="Availability: activate to sort column ascending">Available Count</th>
                    <th class="text-center sorting" tabindex="0" aria-controls="schedule-field" rowspan="1"
                        colspan="1" style="width: 32.8125px;" aria-label="ETA: activate to sort column ascending">
                        Contact</th>
                </tr>
            </thead>


            <tbody>
                @php
                    $count = 1;
                @endphp
                @foreach ($schedules as $item)
                    <tr role="row" class="odd">
                        <td class="text-center sorting_1">{{ $count++ }}</td>
                        <td class="">{{ $item->date }}</td>
                        <td class="">{{ $item->time }}</td>
                        <td class="">{{ $item->center_name }}</td>
                        <td>{{ $item->vaccine_name }}</td>
                        <td>{{$item->count}}</td>
                        <td>{{ $item->contact_no }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</body>

</html>
