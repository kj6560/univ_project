@extends('site.layouts.admin')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="content-wrapper">
        <!-- Responsive Table -->
        <div class="card">
            <h5 class="card-header">Event Gallery</h5>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr class="text-nowrap">
                            <th>Event Id</th>
                            <th>Event Name</th>
                            <th>Event Description</th>
                            <th>Event Image</th>
                            <th>Image Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($gallery as $event)
                        <tr>
                            <th scope="row">{{$event->id}}</th>
                            <td>{{$event->event_name}}</td>
                            <td>{{substr($event->event_bio,0,50)."..."}}</td>
                            <td><img src="{{asset('uploads/events/images/'.$event->event_image)}}" height="50" width="50" alt="Avatar" class="rounded-circle" /></td>
                            <td>{{$event->event_image}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="/dashboard/editEvents/{{$event->id}}"><i class="bx bx-edit-alt me-2"></i> Edit</a>
                                        <a class="dropdown-item" href="/dashboard/deleteEvent/{{$event->id}}"><i class="bx bx-trash me-2"></i> Delete</a>
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