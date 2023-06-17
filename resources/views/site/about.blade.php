@extends('site.layouts.site')
@section('content')

<section class="page-title page-title-about" id="page-title">
    <div class="container">
        <div class="content">
            <h2>About Us</h2>
            <ul class="list-unstyled">
                <li><a href="index.html">Home</a></li>
                <li>About us</li>
            </ul>
        </div>
    </div>
</section>

<!-- ========== End Page Title ========== -->

<!-- ========== Start About Us ========== -->

<section class="about-us" id="about-us">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 info">
                <div class="about-info">
                    <h3>Welcome To Univ</h3>
                    <h4>UNIV, derived from ‘UNIVERSE’, is established as a leading Strategy and Consulting firm catering a gamut of services under the umbrella of Sports, Entertainment, Gaming and related Technology.</h4>
                    <p style="font-size: large;">UNIV Sportatech is a professional firm dedicated to providing the highest level of service bringing strategic, commercial, financial, innovative, investible and general business knowledge to the Sports, Media & Entertainment and Gaming ecosystems. Technology and Knowledge are the two pillars of our service operations and we work with a specialised global business outlook.</p>
                    <p style="font-size: large;">Our investments service caters to cross border transactions within the Sports, M&E and Gaming industries. Our UNIVERSE of engagement is built with the strong intention to support the very institutional foundation of these industries - Talent, Technology and Administration.</p>
                </div>
            </div>
            <div class="col-lg-6 image">
                <div class="about-image">
                    <div class="about-bg"><i class="flaticon-sport"></i></div>
                    <img class="img-fluid" src="images/about01.png" alt="">
                </div>
            </div>
            <!-- <div class="col-lg-6 image">
                        <div class="about-image">
							<div class="about-bg"></div>
                            <img class="img-fluid" src="images/about01.png" alt="">
                        </div>
                    </div> -->
            <div class="col-lg-6 info">
                <div class="about-info">
                    <h3>Youth is a state of being and our business universe is often driven one of our core audience.</h3>
                    <p style="font-size: large;">In Sports, we cater to National Sports Federations andAssociations, Sports IPs, Franchises, and Investible ideas that need support with pan-India operations and a global outlook.</p>
                    <p style="font-size: large;">In Gaming, we work on the fundamentals of gamification of talent, performance, engagement and investments.</p>
                    <p style="font-size: large;">Media and Entertainment today has become the medium of knowledge generation and exchange. Ideas, Innovation and Investments are central to our theme of supporting these industries.</p>
                    <p style="font-size: large;">Knowledge drives understanding, internalisation, planning and execution with measurable outcomes. We curate and build our services bouquet on the foundation of knowledge.</p>
                    <p style="font-size: large;">The Business of Sports, Media & Entertainment and Gaming are inter-weaving and its that common denominator in the inter-twining of these universes that UNIV Sportatech finds itself driving the greatest values in strategy, investment, partnerships and growth.</p>
                </div>
            </div>
            <div class="col-lg-6 image">
                <div class="about-image">
                    <div class="about-bg"></div>
                    <section class="call-to-action2 text-center">
                        <div class="container">
                            <video loop autoplay muted>
                                <source src="images/about-banner.webm" type="video/mp4">
                            </video>
                        </div>
                    </section>

                </div>
            </div>
        </div>


    </div>
    </div>
</section>

<!-- ========== End About Us ========== -->

<!-- ========== Start Call To Action ========== -->

<section class="call-to-action text-center">
    <div class="container">
        <!-- <i class="flaticon-lotus"></i> -->
        <div class="content">
            <h3>ABOUT UNIV SPORTA TECH</h3>
            <p>DERIVED FROM UNIVERSE, "UNIV" STANDS FOR ONE-STOP SOLUTION TO CREATE A <br>PROFITABLE ECOSYSTEM FOR SPORTS, GAMING, MEDIA & ENTERTAINMENT VENTURES.</p>
            
        </div>
    </div>
</section>

<!-- ========== End Call To Action ========== -->



<!-- ========== Start Our Team ========== -->

<section class="team" id="team">
    <div class="container">
        <div class="main-title text-center">
            <!-- <span class="separator">
						<i class="flaticon-chakra"></i>
					</span> -->
            <h2>Our Awesome Team</h2>
        </div>
        <div class="row">
            @foreach($teams as $team)
            <div class="col-lg-4 col-md-6">
                <div class="member">
                    <div class="member-img">
                        <img src="{{asset('uploads/teams/'.$team->image)}}" class="img-fluid" alt="">
                        <div class="overlay">
                            <div class="social-media text-center">
                                <a href="{{$team->twitter_link}}"><i class="fa fa-twitter"></i></a>
                                <a href="{{$team->linked_in_link}}"><i class="fa fa-linkedin"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="member-info">
                        <a href="/team/{{Crypt::encryptString($team->id)}}">
                            <h4 class="member-name">{{$team->name}}</h4>
                        </a>
                        <span>{{$team->designation}}</span>
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>
    </div>
</section>

<!-- ========== End Our Team ========== -->





<!-- ========== Start Newsletter ========== -->

<section class="newsletter ">
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
@stop