@extends('site.layouts.admin')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="content-wrapper">
        <!-- Responsive Table -->
        <h5 class="card-header">Users Address Details (Total: {{$users instanceof Illuminate\Pagination\LengthAwarePaginator?$users->total():count($users)}} )</h5>
        @include('site.filters.userfilter')
        <div class="card">

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr class="text-nowrap">
                            <th>User Id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Number</th>
                            <th>Email</th>
                            <th>Address Line1</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Pincode</th>
                            <th>created On</th>
                            <th>Updated On</th>
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
                            <td>{{$user->address_line1}}</td>
                            <td>{{$user->city}}</td>
                            <td>{{$user->state}}</td>
                            <td>{{$user->pincode}}</td>
                            <td>{{$user->created_at}}</td>
                            <td>{{$user->updated_at}}</td>
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