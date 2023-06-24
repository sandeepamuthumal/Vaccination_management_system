<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Vaccination Management System </title>
    <link rel="stylesheet" href="{{ asset('contact/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/cal.png') }}">

</head>

<body>

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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous">
    </script>
    <script src="{{ asset('contact/js/jquery.js') }}"></script>
    <script src="{{ asset('contact/js/bootstrap.js') }}"></script>


    <div class="container">

        <div class="section-title text-center center">
            <div class="about_heading">
                <h2 style="color:white">Get in Touch</h2>

                <hr style="color: black;">
            </div>
        </div>
    </div>

    <div class="container">
        <div class="card bg-dark text-white">
            <img class="card-img" src="\contact\contact.jpg" alt="Card image" style="opacity: 0.2; ">
            <div class="card-img-overlay">
                <form class="form-contact contact_form" action="contact_process.php" method="post" id="contactForm"
                    novalidate="novalidate" style="padding-top: 10%;">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <textarea class="form-control w-100" name="message" id="message" cols="30" rows="12"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Message'" placeholder=" Enter Message"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-6 ">
                            <div class="form-group">
                                <input class="form-control valid" name="name" id="name" type="text"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'"
                                    placeholder="Enter your name">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input class="form-control valid" name="email" id="email" type="email"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'"
                                    placeholder="Email">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <input class="form-control" name="subject" id="subject" type="text"
                                    onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Subject'"
                                    placeholder="Enter Subject">
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <button class="btn btn-outline-warning btn-lg" type="submit"
                            class="button button-contactForm boxed-btn"
                            style="padding-left: 40%; padding-right: 40%; margin-left: 60px;">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>

</html>
