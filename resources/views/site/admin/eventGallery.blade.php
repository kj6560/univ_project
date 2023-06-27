@extends('site.layouts.admin')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="content-wrapper">
        <!-- Responsive Table -->
        <a href="/dashboard/addEventGallery" class="btn btn-primary" style="max-width: 150px; margin: 10px auto;">Add Event Gallery Image</a>
        <div class="card">
            <h5 class="card-header">Event Gallery</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr class="text-nowrap">
                            <th>Event Id</th>
                            <th>Event Name</th>
                            <th>Image Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gallery as $event)
                        <tr>
                            <th scope="row">{{$event->id}}</th>
                            <td>{{$event->event_name}}</td>
                            <td><img src="{{asset('uploads/event_gallery/images/'.$event->image)}}" height="50" width="50" alt="Avatar" class="rounded-circle" /></td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="/dashboard/deleteEventGalleryImage/{{$event->id}}"><i class="bx bx-trash me-2"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
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