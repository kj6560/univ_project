@extends('site.layouts.site')
@section('content')
<section class="page-title page-title-abhishek" id="page-title">
            <div class="container">
                <div class="content">
                    <h2>Meet Our Awesome Founder</h2>
                    <ul class="list-unstyled">
                        <li><a href="/">Home</a></li>
                        <li>Founder</li>
                    </ul>
                </div>
            </div>
        </section>

        <!-- ========== End Page Title ========== -->
        
        <!-- ========== Start Team Single ========== -->
		
		<section class="team-single">
            <div class="container">
                <div class="row">
					<div class="col-md-4">
						<div class="trainer-image">
							<img class="img-fluid" src="{{asset('uploads/teams/'.$teams->image)}}" alt="">
						</div>
					</div>
					<div class="col-md-8">
						<div class="trainer-info">
							<h3>About</h3>
							<p>{{$teams->info}}</p>
							<ul class="info list-unstyled">
								<li><span>Name: </span>{{$teams->name}}</li>
								<li><span>Email: </span> {{$teams->email}}</li>
								<li><span>Phone: </span>+91 - {{$teams->number}}</li>
								<li><span>social: </span>
									<ul class="social list-unstyled">
										
										<li><a href="{{$teams->twitter_link}}"><i class="fa fa-twitter"></i></a></li>
									
									
									</ul>
								</li>
							</ul>
							
						</div>
					</div>
				</div>
				
				
            </div>
        </section>

        @stop