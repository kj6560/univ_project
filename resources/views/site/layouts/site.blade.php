<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Title -->
    <title>Home | Univ Sporta Tech</title>
    <!-- Favicon -->
    <link rel="icon" href="images/icon.png">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Rubik:400,500,600,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:400,500,600,700,800">

    <!-- Font Awesome Css -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.min.css')}}">
    <!-- Flaticon -->
    <link rel="stylesheet" href="{{asset('fonts/flaticon.css')}}">
    <!-- Bootstrap 4 Css -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <!-- Owl Carousel Css -->
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/owl.theme.default.min.css')}}">
    <!-- Animate Css -->
    <link rel="stylesheet" href="{{asset('css/animate.min.css')}}">
    <!-- Main Style Css -->
    <link rel="stylesheet" href="{{asset('css/main.css')}}">
    <link rel="stylesheet" href="{{asset('css/inner-pages.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        video {
            max-width: 100%;
            height: auto;
        }

        cotainer-2 {
            max-width: 100%;

        }

        .page-title-event {
            background: url("{{asset('/images/event-header.jpg')}}") center center no-repeat;
        }


        .page-title-about {
            background: url("{{asset('/images/header.jpg')}}") center center no-repeat;
        }


        .page-title-gallery {
            background: url("{{asset('/images/gallery-header.jpg')}}") center center no-repeat;
        }


        .page-title-contact {
            background: url("{{asset('/images/contact-header.jpg')}}") center center no-repeat;
        }
    </style>




    <!--[if lt IE 9]>
        <script src="js/html5shiv.min.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->

</head>

<body>
    @php
    $success = Session::get('success');
    $error = Session::get('error');
    @endphp
    <!-- ========== Start Loading ========== -->

    <div class="loading">
        <div class="loading-content">
            <div class="inner-item"></div>
            <div class="inner-item"></div>
            <div class="inner-item"></div>
            <div class="inner-item"></div>
            <div class="inner-item"></div>
        </div>
    </div>

    <!-- ========== End Loading ========== -->

    <!-- ========== Start Upperbar ========== -->

    <div class="upper-bar">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="inner-bar">
                        <div class="row">
                            <div class="col-lg-8 col-12 text-center text-lg-left">
                                <ul class="contact-bar list-unstyled">
                                    <li>
                                        <a href="mailto:info@univsportatech.in">
                                            <i class="fa fa-envelope"></i>
                                            info@univsportatech.in
                                        </a>
                                    </li>
                                    <li>
                                        <a href="tel:8744955443">
                                            <i class="fa fa-phone"></i>
                                            {{env('SITE_NUMBER',"+91 98713 96956")}}
                                        </a>
                                    </li>
                                    <li>
                                        <i class="fa fa-map-marker"></i>
                                        New Delhi | India
                                    </li>
                                </ul>
                            </div>
                            <div class="col-lg-4 col-12 text-center text-lg-right">
                                <ul class="social-media-bar list-unstyled">
                                    <li>
                                        <a href="https://twitter.com/univsportatech/">
                                            <i class="fa fa-twitter"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.instagram.com/univsportatech/">
                                            <i class="fa fa-instagram"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.linkedin.com/company/univ-sportatech/">
                                            <i class="fa fa-linkedin"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <i class="fa fa-youtube"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ========== End Upperbar ========== -->

    <!-- ========== Start Navbar ========== -->

    <div class="header-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-12 text-md-center">
                    <!-- Logo -->
                    <a class="my-logo" href="/"><img src="{{asset('images/logo.png')}}"></a>
                    <!-- Button Menu -->
                    <button class="menu-toggle">
                        <span class="bar"></span>
                        <span class="bar"></span>
                        <span class="bar"></span>
                    </button>
                </div>
                <div class="col-lg-10 col-12">
                    <div class="main-menu">
                        <nav class="navbar navbar-expand-lg">
                            <div class="navbar-collapse">
                                <ul class="nav navbar-nav">
                                    <li class="{{ Request::is('home') ? 'active' : '' }}"><a href="/">Home</a></li>
                                    <li class="{{ Request::is('about') ? 'active' : '' }}"><a href="/about">About Us</a></li>
                                    <li class="{{ Request::is('event') ? 'active' : '' }}"><a href="/event">Event</a></li>
                                    <li class="{{ Request::is('gallery') ? 'active' : '' }}"><a href="/gallery">Gallery</a></li>
                                    <li class="{{ Request::is('contactus') ? 'active' : '' }}"><a href="/contactus">Contact Us</a></li>
                                    @guest
                                    
                                    @else
                                    <li><a href="/userProfile">Profile</a></li>
                                    @endguest
                                    @guest
                                    <li><a href="/login">Login</a></li>
                                    @else
                                    <li><a href="/logout">Logout</a></li>
                                    @endguest
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('content')

    <!-- ========== End Side Menu ========== -->

    <!-- ========== Start Home ========== -->


    <footer class="footer">
        <div class="footer-top">
            <!-- <i class="flaticon-lotus"></i> -->
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-12 footer-menu">
                        <div class="footer-logo">
                            <a class="my-logo" href="/"><img src="{{asset('images/logo-white.png')}}"></a>
                        </div>
                        <ul class="list-unstyled">
                            <li>New Delhi | India</li>
                            <li>info@univsportatech.in</li>
                            <li>{{env('SITE_NUMBER',"+91 98713 96956")}}</li>
                        </ul>
                        <ul class="list-unstyled social-media">
                            <li><a href="https://twitter.com/univsportatech/"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="https://www.instagram.com/univsportatech/"><i class="fa fa-instagram"></i></a></li>
                            <li><a href="https://www.linkedin.com/company/univ-sportatech/"><i class="fa fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 footer-menu">
                        <div class="footer-item">
                            <h4>Quick Links</h4>
                            <ul class="list-unstyled">
                                <li><a href="/">Home</a></li>
                                <li><a href="/about">About us</a></li>
                                <li><a href="/gallery">Gallery</a></li>
                                <li><a href="/contactus">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 footer-menu">
                        <div class="footer-item">
                            <h4>Event Info</h4>
                            <ul class="list-unstyled">
                                <li><a href="/login">Login</a></li>
                                <li><a href="/event">Events</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-12 footer-menu">
                        <div class="footer-item">
                            <h4>About Us</h4>
                            <p style="color: white;">UNIV Sportatech is a professional firm dedicated to providing the highest level of service bringing strategic, commercial, financial, innovative, investible and general business knowledge to the Sports, Media & Entertainment and Gaming ecosystems.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom text-center">
            <div class="copyright">
                <p>&copy; 2023 <a href="https://infinityxlab.com/"><span>Infinityxlab</span></a> All rights reserved</p>
            </div>
        </div>
    </footer>

    <!-- ========== End Footer ========== -->

    <!-- ========== Start Scroll To Top  ========== -->

    <a href="#" class="scroll-top">
        <span><i class="fa fa-arrow-up"></i></span>
    </a>

    <!-- ========== End Scroll To Top  ========== -->

    <!-- ========== Js ========== -->

    <!-- jQuery -->
    <script src="{{asset('js/jquery-3.2.1.min.js')}}"></script>
    <!-- Popper Js  -->
    <script src="{{asset('js/popper.min.js')}}"></script>
    <!-- Bootstrap 4 Js -->
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <!-- Owl Carousel Js -->
    <script src="{{asset('js/owl.carousel.min.js')}}"></script>
    <!--  WOW Js  -->
    <script src="{{asset('js/wow.min.js')}}"></script>
    <!-- Custom Js -->
    <script src="{{asset('js/custom.js')}}"></script>
</body>
<script>
    var success = "{{!empty($success)?$success:'NA'}}";
    var error = "{{!empty($error)?$error:'NA'}}";
    if (success != 'NA') {
        Swal.fire({
            title: 'Done',
            text: success,
            icon: 'success',
            confirmButtonText: 'Okay',

        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/';
            }
        })
    }
    if (error != 'NA') {
        Swal.fire({
            title: 'Failed!',
            text: error,
            icon: 'error',
            confirmButtonText: 'Okay',

        });
    }
</script>

</html>