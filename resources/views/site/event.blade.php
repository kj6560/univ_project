@extends('site.layouts.site')
@section('content')

<section class="page-title page-title-event" id="page-title">
    <div class="container">
        <div class="content">
            <h2>Events</h2>
            <ul class="list-unstyled">
                <li><a href="/">Home</a></li>
                <li>Events</li>
            </ul>
        </div>
    </div>
</section>

<!-- ========== End Page Title ========== -->

<!-- ========== Start Class Grid ========== -->

<section class="classes">
    <div class="container">
        <div class="main-title text-center">
            <img src="images/classes/icon.png" class="img-fluid" alt="">
            <h2>Events</h2>
        </div>
        <div class="row">
            @foreach($events as $event)
            <!-- New Item -->
            <div class="col-lg-4 col-md-6">
                <div class="class">
                    <div class="class-img">
                        <img src="{{asset('uploads/events/images/'.$event->event_image)}}" class="img-fluid" alt="">
                    </div>
                    <div class="class-content">
                        <div class="class-title">
                            <a href="/eventDetails/{{Crypt::encryptString($event->id)}}">
                                <h4>{{$event->event_name}}</h4>
                            </a>
                        </div> 
                        <ul class="details list-unstyled">
                            <li><i class="fa fa-calendar"></i>@php $date = $event->event_date;
                                    echo date('D d M Y', strtotime($date)); @endphp</li>
                            <li><i class="fa fa-clock-o"></i>@php $date = $event->event_date;
                                echo date('H:i', strtotime($date)); echo " ",date('H:i', strtotime($date)) > 12 ?"PM":"AM" @endphp</li>
                        </ul>
                        <div class="class-text">
                            <p>{{substr($event->event_bio,0,200)}}</p>
                        </div>
                        <ul class="class-info list-unstyled">
                            <li class="pull-left">Administrator</li>
                            <li class="pull-right"><a href="/eventDetails/{{Crypt::encryptString($event->id)}}" class="post-more">Read more<i class="fa fa-angle-double-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- ========== End Class Grid ========== -->





<!-- <form>
    <section id="contact-form">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-8 offset-lg-2">
                    <div class="form-area mt-5 p-lg-4 p-3">
                        <form>
                            <div class="row">
                                <div class="col-sm-12 text-center text-info mb-3 font-secondary">
                                    <h3>Fill the Details</h3>
                                </div>
                            </div>
                            <dl class="row">
                                <dt class="col-sm-4 text-info font-secondary">Name*</dt>
                                <dd class="col-sm-8"><input type="text" class="form-control" placeholder="Name"></dd>

                                <dt class="col-sm-4 text-info font-secondary">Email*</dt>
                                <dd class="col-sm-8">
                                    <input type="Email" class="form-control text-info" placeholder="Email">
                                </dd>

                                <dt class="col-sm-4 text-info font-secondary">Address(1)</dt>
                                <dd class="col-sm-8"><input type="text" class="form-control" placeholder="Address"></dd>

                                <dt class="col-sm-4 text-truncate text-info font-secondary">Address(2)</dt>
                                <dd class="col-sm-8"><input type="text" class="form-control" placeholder="Address"></dd>

                                <dt class="col-sm-4 text-truncate text-info font-secondary">Passport Number</dt>
                                <dd class="col-sm-8"><input type="text" class="form-control" placeholder="Passport Number"></dd>
                            </dl>
                            <div class="row">
                                <div class="col-sm-12">
                                    <input type="submit" class="form-control bg-info text-light font-secondary" value="Submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="footer" class="mt-4">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 text-center">
                    <p class="text-light">© 2019 <a target="_blank" href="http://nasirkhan.me">Nasir Khan</a> All Rights Reserved || <a target="_blank" href="https://youtu.be/Eqzph_YbvKY">Check This Video</a></p>
                </div>
            </div>
        </div>
    </section>


</form>  -->

</html>


<section class="classes">
    <div class="container">
        <div class="main-title text-center">
            <h2>Gallery</h2>
        </div>
        <div class="row">
            <!-- New Item -->
            @foreach($event_gallery as $gallery)
            <!-- New Item -->
            <div class="col-lg-3 col-md-6">
                <div class="class">
                    <div class="class-img">
                        <a target="_blank" href="{{asset('uploads/event_gallery/images/'.$gallery->image)}}">
                            <img src="{{asset('uploads/event_gallery/images/'.$gallery->image)}}" class="img-fluid" alt="">
                    </div>
                </div>
            </div>
            @endforeach
            
        </div>
    </div>
</section>
<section class="newsletter area">
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
<!-- ========== End Newsletter ========== -->