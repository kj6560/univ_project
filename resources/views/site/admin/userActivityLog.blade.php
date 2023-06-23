@extends('site.layouts.admin')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="content-wrapper">
        <!-- Responsive Table -->
        <h5 class="card-header">Users Log (Total: {{$users instanceof Illuminate\Pagination\LengthAwarePaginator?$users->total():count($users)}} Logs)</h5>
        @include('site.filters.userfilter')
        <div class="card">

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr class="text-nowrap">
                            <th>User Id</th>
                            <th>User First Name</th>
                            <th>User Last Name</th>
                            <th>User Number</th>
                            <th>User Email</th>
                            <th>User Activity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <th scope="row">{{$user->id}}</th>
                            <td>{{$user->first_name}}</td>
                            <td>{{$user->last_name}}</td>
                            <td>{{$user->number}}</td>
                            <td>{{$user->email}}</td>
                            <td>{{$user->activity_name}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-12">
                    @php
                    if($users instanceof Illuminate\Pagination\LengthAwarePaginator){
                    @endphp
                    {!! $users->links('pagination::bootstrap-4') !!}
                    @php } @endphp
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