<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="{{ asset('admin_page/css/main.css') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/cal.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body style="background-image:url(/admin_page/images/doctordesk.jpg)">
    <form action="{{ route('registration') }}" method="post">
        @csrf
        <div class="header">
            <ul>
                <li style="float:left;border-right:none"><strong> Admin Registration</strong></li>

                <li><a href="{{ url('/admin/login') }}">Login</a></li>
                <li><a href="{{ url('/') }}">Home</a></li>
            </ul>
        </div>
        <div class="sucontainer">
            <label><b>Name:</b></label><br>
            <input type="text" placeholder="Enter your name" name="name" required><br>

            <label><b>Address:</b></label><br>
            <input type="text" placeholder="Enter your address" name="address" required><br>

            <label><b>Contact Number:</b></label><br>
            <input type="text" placeholder="Enter your contact no" name="contact" required><br>

            <label><b>NIC Number:</b></label><br>
            <input type="text" placeholder="Enter your nic" name="nic" required><br>

            <label><b>Date Of Birth:</b></label><br>
            <input type="date" placeholder="Enter your date of birth" name="birthday" required><br>

            <label><b>Email:</b></label><br>
            <input type="email" placeholder="Enter your email" name="email" required><br>

            <label><b>Password:</b></label><br>
            <input type="password" placeholder="Enter Password" name="password" required><br><br>

            <div class="container" style="background-color:grey">
                <button type="submit" name="submit" style="float:right">Sign Up</button>
            </div>
        </div>
    </form>
</body>

</html>
