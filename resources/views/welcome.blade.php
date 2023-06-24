<!DOCTYPE html>
<html>

<head>
    <title>Vaccination Management System </title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/cal.png') }}">
    
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('admin/vendor/toastr/css/toastr.min.css') }}">
    <style>
        .signup-btn {
            border-radius: 12px;
            background-color: black;
            border: none;
            color: white;
            padding: 16px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            -webkit-transition-duration: 0.4s;
            /* Safari */
            transition-duration: 0.4s;
            cursor: pointer;
        }
    </style>
</head>

<body style="background-image:url(/images/p3.jpg)">
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
    <div class="center">
        <h1>Your Health is our priority..<br>Let's together build a covid-19 free nation..</h1><br>
        <p style="text-align:center;color:black;font-size:30px;top:35%"><B>Reserve Your Vaccine</B></p><br>
        <button onclick="document.getElementById('id01').style.display='block'"
            style="position:absolute;top:50%;left:50%">Login</button>

    </div>
    <div class="footer">
        <ul style="position:absolute;top:93%;background-color:black">

            <li><a href="{{ route('user_dashboard') }}">User Dashboard</a></li>
            <li><a href="{{ route('admin_dashboard') }}">Admin Dashboard</a></li>
        </ul>
    </div>
    <div id="id01" class="modal">

        <form class="modal-content animate" action="{{ route('login') }}" method="post">
            @csrf
            <div class="imgcontainer">
                <span style="float:left">
                    <h2>&nbsp&nbsp&nbsp&nbspLog In</h2>
                </span>
                <span onclick="document.getElementById('id01').style.display='none'" class="close"
                    title="Close Modal">&times;</span>
            </div>

            <div class="container">
                <label><b>Email</b></label>
                <input type="text" placeholder="Enter Email" name="email" required>

                <label><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>
                <button type="submit" name="login">Login</button>

                <input type="checkbox" checked="checked"> Remember me
            </div>

            <div class="container" style="background-color:#f1f1f1">
                <button type="button" onclick="document.getElementById('id01').style.display='none'"
                    class="cancelbtn">Cancel</button>
                <button type="button"
                    onclick="document.getElementById('id02').style.display='block';document.getElementById('id01').style.display='none'"
                    style="float:right">Don't have one?</button>
            </div>
        </form>
    </div>

    <div id="id02" class="modal">

        <form class="modal-content animate">
            <div class="imgcontainer">
                <span onclick="document.getElementById('id02').style.display='none'" class="close"
                    title="Close Modal">&times;</span><br>
            </div>

            <div class="imgcontainer">
                <img src="images/steps.png" alt="Avatar" class="avatar">
            </div>

            <div class="container">
                <p style="text-align:center;font-size:16px;"><b>Sign Up -> Choose your center-Date-vaccine -> Reserve
                        your vaccine</b></p>


            </div>

            <div class="container" style="background-color:#f1f1f1">
                <button type="button" onclick="document.getElementById('id02').style.display='none'"
                    class="cancelbtn">Cancel</button>
                <a class="signup-btn" href="{{ route('user_register') }}" name="signup" style="float:right">Sign
                    Up</a>
            </div>

        </form>
    </div>

    <!-- Toastr -->
    <script src="{{ asset('admin/vendor/toastr/js/toastr.min.js') }}"></script>
    <script type="text/javascript">

    
        @if(Session::has('message'))
       toastr.options =
       {
           "closeButton" : true,
           "progressBar" : true
       }
               toastr.success("{{ session('message') }}");
       @endif
   
       @if(Session::has('error'))
        window.addEventListener("load", function() {
            setTimeout(function() {
                document.getElementById('id01').style.display='block'";
            }, 500)
        });

      
       @endif
      
   
   </script>

</body>

</html>
