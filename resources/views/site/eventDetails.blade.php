@extends('site.layouts.site')
@section('content')
@php

$user = Auth::user();
$user = !empty($user) ? $user : null;
$event_details_header = $event->event_detail_header;
@endphp

<style>
    .page-title-event {
        background: url("{{url('uploads/events/images/'.$event_details_header)}}") center center no-repeat;
    }
</style>
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
<section class="classes">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="class-details">
                    <div class="class">
                        <div class="class-img">
                            <img src="{{asset('uploads/events/images/'.$event->event_image)}}" class="img-fluid" alt="">
                        </div>
                        <div class="class-content">
                            <div class="class-title">
                                <a href="#">
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
                                <p>{{$event->event_bio}}.</p>
                            </div>
                            <div class="class-footer">
                                <div class="class-share">
                                    <h5>Share:</h5>
                                    <ul class="list-unstyled social-media">
                                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 registerNow">
                <div class="class-sidebar">
                    <form action="/registerNow" method="POST">
                        <div class="sidebar-info">
                            <h4>Register For This Event</h4>

                            @csrf
                            <ul class="info-list list-unstyled">
                                <li hidden>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="event_id" value="{{$event->id}}">
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="first_name" placeholder="First Name" value="{{$user ? $user->first_name:''}}" required>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="last_name" placeholder="Last Name" value="{{$user ? $user->last_name:''}}" required>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="email" placeholder="Email Id" value="{{$user ? $user->email:''}}" required>
                                    </div>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="number" placeholder="Phone Number" value="{{$user ? $user->number:''}}" required>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        <button type="submit" class="register main-btn" href="#"><span>Register Now</span></button>
                    </form>
                    <div class="sidebar-classes">
                        <h4>Other Events</h4>
                        @foreach($events as $event_data)
                        @if($event_data->id != $event->id)
                        <div class="class-inner">
                            <div class="class-image">
                                <img class="img-fluid" src="{{asset('uploads/events/images/'.$event->event_image)}}" alt>
                            </div>
                            <div class="class-info">
                                <h5><a href="#">{{$event_data->event_name}}</a></h5>
                                <p>By: Administrator</p>
                            </div>
                        </div>
                        @endif
                        @endforeach

                    </div>
                    <!-- <div class="sidebar-tags">
                        <h4>Tags</h4>
                        <ul class="tags-list list-unstyled">
                            <li>
                                <a href="#">Marathon</a>
                            </li>
                            <li>
                                <a href="#">Running</a>
                            </li>
                            <li>
                                <a href="#">Event</a>
                            </li>

                        </ul>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</section>

<section class="events" id="events">
    <div class="container">
        <div class="main-title text-center">
            <h2>OBJECTIVE</h2>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="event">
                    <div class="event-img">
                        @guest
                        <a href="/login"><img src="{{asset('images/img.jpg')}}" alt=""></a>
                        @else
                        <iframe width="550" height="300" src="{{$event->event_live_link}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                        @endguest
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="event">
                </div>
                <div class="event-content">
                    <div class="event-title">
                        <a href="/eventDetails/{{Crypt::encryptString($event->id)}}">
                            <h4>{{$event->event_name}}</h4>
                        </a>
                    </div>
                    </ul>
                    <div class="event-text" style="color: #888;">
                        <p>{{$event->event_objective}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="my-btn text-center">
        <a href="/event" target="_blank" class="main-btn"><span>All Events</span></a>
    </div>
    </div>
</section>
@stop