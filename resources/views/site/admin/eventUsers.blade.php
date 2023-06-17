@extends('site.layouts.admin')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
<div class="content-wrapper">
    <!-- Responsive Table -->
    <div class="card">
        <h5 class="card-header">Users Registered for Event</h5> <a href="/dashboard/downloadEventUsers" class="btn btn-primary" style="width: 200px;margin-left: 10px">Download</a>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr class="text-nowrap">
                        <th>Event Name</th>
                        <th>User First Name</th>
                        <th>User Last Name</th>
                        <th>User Mobile</th>
                        <th>User Email</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($eventusers as $user)
                    <tr>
                        <th scope="row">{{$user->event_name}}</th>
                        <td>{{$user->first_name}}</td>
                        <td>{{$user->last_name}}</td>
                        <td>{{$user->number}}</td>
                        <td>{{$user->email}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="col-12">
                {!! $eventusers->links('pagination::bootstrap-4') !!}
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