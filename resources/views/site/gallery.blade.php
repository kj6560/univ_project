@extends('site.layouts.site')
@section('content')
<section class="page-title page-title-gallery" id="page-title">
    <div class="container">
        <div class="content">
            <h2>Gallery</h2>
            <ul class="list-unstyled">
                <li><a href="index.html">Home</a></li>
                <li>Gallery</li>
            </ul>
        </div>
    </div>
</section>

<!-- ========== End Page Title ========== -->




<!-- ========== Start Class Grid ========== -->

<section class="classes">
    <div class="container">
        <div class="row">
            <!-- New Item -->
            @foreach($gallery as $gallery_item)
            <div class="col-lg-3 col-md-6">
                <div class="class">
                    <div class="class-img">
                            <img src="{{asset('uploads/event_gallery/images/'.$gallery_item->image)}} " class="img-fluid" alt="">
                    </div>
                </div>
            </div>
            @endforeach
            <div class="col-12">
                {!! $gallery->links('pagination::bootstrap-4') !!}
            </div>
            <!-- New Item -->
        </div>
    </div>
</section>

<!-- ========== End Class Grid ========== -->



<!-- ========== Start Newsletter ========== -->

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

<!-- ========== End Newsletter ========== -->
@stop