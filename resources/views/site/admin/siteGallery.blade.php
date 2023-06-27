@extends('site.layouts.admin')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="content-wrapper">
        <a href="/dashboard/addGallery" class="btn btn-primary" style="max-width: 150px; margin: 10px auto;">Add Gallery Image</a>
        <!-- Responsive Table -->
        <div class="card">
            <h5 class="card-header">Site Gallery</h5>
            
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr class="text-nowrap">
                            <th>Image Name</th>
                            <th>Added On</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gallery as $image)
                        <tr>
                            <td><img src="{{asset('uploads/events/images/'.$image->image)}}" height="50" width="50" alt="Avatar" class="rounded-circle" /></td>
                            <td>{{$image->created_at}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-12">
                    {!! $gallery->links('pagination::bootstrap-4') !!}
                </div>
            </div>
        </div>
        <!--/ Responsive Table -->
    </div>
    <!-- / Content -->
    <div class="content-backdrop fade"></div>
</div>
</div>
@stop