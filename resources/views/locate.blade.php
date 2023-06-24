<html>

<head>
    <title>Vaccination Management System </title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/cal.png') }}">
</head>

<body style="background-image:url(/images/yellowpage.jpg)">
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
    <form action="locateus.php" method="post">
        <div class="sucontainer" style="background-image:url(/images/yellowpage.jpg)">
            <ul style="background-image:url(/images/yellowpage.jpg)">
                <label><b>Search Vaccine</b></label>
                <input type="text" name="doctorname" placeholder="Enter Vaccine Name"></input>
                <button type="submit" style="position:center" name="subd" value="Submit">Submit</button>
            </ul>
            <label style="font-size:20px">City:</label><br>
            <select name="city" id="city-list" class="demoInputBox" onChange="getTown(this.value);"
                style="width:100%;height:35px;border-radius:9px">
                <option value="">Select City</option>
            </select><br>

            <label style="font-size:20px">Town:</label><br>
            <select id="town-list" name="Town" onChange="getClinic(this.value);"
                style="width:100%;height:35px;border-radius:9px">
                <option value="">Select Town</option>
            </select><br>

            <label style="font-size:20px">Center:</label><br>
            <select id="clinic-list" name="Center" onChange="getDoctorday(this.value);"
                style="width:100%;height:35px;border-radius:9px">
                <option value="">Select Center</option>
            </select><br>
            <div class="container">
                <button type="submit" style="position:center" name="submit" value="Submit">Submit</button>
            </div>

    </form>
</body>

</html>
