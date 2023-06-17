@extends('site.layouts.site')
@section('content')
<section class="demo3" id="home">
    <div class="cotainer-2">
        <video loop autoplay muted>
            <source src="images/movie.mp4" type="video/mp4">
        </video>
    </div>
</section>

<!-- ========== End Home ========== -->

<!-- ========== Start Services ========== -->

<section class="services" id="services">
    <div class="container">
        <div class="main-title text-center">
            <span class="separator">
                <img src="{{asset('images/classes/quality.png')}}" class="img-fluid" alt="">
            </span>
            <h2>Our Expertise</h2>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="service one">
                    <div class="service-bg"></div>
                    <div class="service-item">

                        <h4>Strategic Consulting & Advocacy</h4>
                        <p>Univ advocates an enabling policy outlook basis short - mind long - term solutions based on research, publications, and an inclusive thought leadership outlook. The policy must always be featured basis of actionable outcomes, and here we work with the Indian government, its functionaries, and international trade bodies and organizations.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="service two">
                    <div class="service-bg"></div>
                    <div class="service-item">

                        <h4>Global partnership & sponsorship </h4>
                        <p>We provide solutions to clients & brands that helps them connect with their audience, grow their brand equity and fan base.<br><br><br><br></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="service three">
                    <div class="service-bg"></div>
                    <div class="service-item">
                        <h4>Talent & Athlete Management</h4>
                        <p>Representation and management of athletes help athletes to realize their potential of the field by securing opportunities for brand endorsements and appearances.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="service four">
                    <div class="service-bg"></div>
                    <div class="service-item">
                        <h4>Events planning & management</h4>
                        <p>Conceptualizing, planning, and executing sports events from start to finish in-line with our clients and partner's visions.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="service five">
                    <div class="service-bg"></div>
                    <div class="service-item">
                        <h4>Content Creations, Productions, & Marketing </h4>
                        <p>Creating customized content solutions for brands, athletes, broadcasters, digital platforms, etc. </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="service six">
                    <div class="service-bg"></div>
                    <div class="service-item">
                        <h4>Licensing</h4>
                        <p>Working with IP owners as well as brands to help launch Uniqe licensing programs. working closely with sports franchises and sports federations to create meaningful brand extetions.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== End Services ========== -->

<!-- ========== Start About Us ========== -->

<section class="about-us" id="about-us">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 info">
                <div class="about-info">
                    <!-- <h3>Welcome To Pranayama Studio</h3> -->
                    <h4>OUR APPROACH</h4>
                    <p>Our UNIVERSE covers everything Sport, Entertainment and Gaming with a strong intention to support the very institutional foundation of the industry- Talent,Organisations and Administration. In Sports,for instance, we cater to National Sports Federations and Associations, Sports IPs, Franchises and Investible ideas that need support with pan-India operations and a global outlook.</p>
                    <p>Science is the foundation of excellence and UNIV takes science and technology as the base value for a high-excellence future of 'BHARAT'. In any of our focus sectors of business (Sports, Gaming or Media and Entertainment) the spirit, individual excellence , cognitive science, innovation, and inculcate the spirit of competing fearlessly. Winning is an outcome of the process.</p>
                    <p>UNIV celebrates the spirit of Self-belief: The human mind is unconquerable and limitless. No sporting success has been accomplished without the mind's indomitabl spirit of self-belief.</p>

                    <a href="about"  class="main-btn"><span>Read More</span></a>
                </div>
            </div>
            <div class="col-lg-6 image">
                <div class="about-image">
                    <!-- <div class="about-bg"><i class="flaticon-lotus"></i></div> -->
                    <img class="img-fluid" src="{{asset('images/about-img.png')}}" alt="">
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== End About Us ========== -->


<!-- ========== Start Call To Action ========== -->

<section class="call-to-action2 text-center">
    <div class="container">
        <video loop autoplay muted>
            <source src="images/banner-video.webm" type="video/mp4">
        </video>
    </div>
</section>

<!-- ========== End Call To Action ========== -->








<!-- ========== Start Call To Action ========== -->

<section class="call-to-action ">
    <div class="container">
        <!-- <i class="flaticon-lotus"></i> -->
        <div class="content">
            <h3>UNIV SPORTS - MISSION CRITICAL</h3>
            <p>We understand that the 2024 Paris Olympics will be a milestone year for 'Bharat' in our sporting journey. India's top athletes are already deep into their high-performance sessions. We are determined to aid the athletes and their respective partner federations in presenting them with the right partners.</p><br>
            <p>India's young brigade in shooting, weightlifting and badminton have already booked their quota berths in world's largest sporting stage - the Olympics 2024. UNIV Sports aims to support this ecosystem with technology, science, advocacy and investments.</p>
            
        </div>
    </div>
</section>

<!-- ========== End Call To Action ========== -->


<!-- ========== Start Events ========== -->

<section class="events" id="events">
    <div class="container">
        <div class="main-title text-center">
            <img src="{{asset('images/classes/icon.png')}}" class="img-fluid" alt="">
            <h2>Events</h2>
        </div>
        <div class="row">
            @foreach($events as $event)
            <div class="col-lg-6">
                <div class="event">
                    <div class="event-img">
                        <img src="{{asset('uploads/events/images/'.$event->event_image)}}" alt="">
                    </div>
                    <div class="event-content">
                        <div class="event-title">
                            <a href="event-details.html">
                                <h4>{{$event->event_name}}</h4>
                            </a>
                        </div>
                        <ul class="event-info list-unstyled">
                            <li class="time"><i class="flaticon-clock-circular-outline"></i>@php $date = $event->event_date;
                                    echo date('D M Y', strtotime($date))," "; $date = $event->event_date;
                                    echo date('H:i', strtotime($date)); echo " ",date('H:i', strtotime($date)) > 12 ?"PM":"AM" @endphp</li>
                            <li><i class="flaticon-placeholder"></i>{{$event->event_location}}</li>
                        </ul>
                        <div class="event-text">
                            <p>{{ substr($event->event_bio,0,200) }}</p>
                        </div>
                        <a class="event-more" href="/eventDetails/{{Crypt::encryptString($event->id)}}">Continue Reading</a>
                        <div class="event-date"><span>@php $date = $event->event_date;
                                    echo date('D', strtotime($date)); @endphp</span> </div>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
        <div class="my-btn text-center">
            <a href="/event" target="_blank" class="main-btn"><span>All Events</span></a>
        </div>
    </div>
</section>

<!-- ========== End Events ========== -->






<!-- ========== Start Newsletter ========== -->

<section class="newsletter">
    <div class="container">
        <div class="newsletter-inner">
            <div class="row">
                <div class="col-lg-5">
                    <h2>Subscribe to our newsletter</h2>
                    <p>Fuel Your Passion for Sports: Stay Ahead with Our Action-Packed Newsletter!</p>
                </div>
                <div class="col-lg-7">
                    <form class="newsletter-form" action="#" method="post">
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
                            <button class="main-btn" type="submit" name="send"><span>Subscribe</span></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== End Newsletter ========== -->

<!-- ========== Start Footer ========== -->

@stop