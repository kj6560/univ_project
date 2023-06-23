@extends('site.layouts.admin')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="content-wrapper">
        <!-- Responsive Table -->
        <h5 class="card-header">Emergency Contact Details (Total: {{$users instanceof Illuminate\Pagination\LengthAwarePaginator?$users->total():count($users)}} )</h5>
        @include('site.filters.userfilterEmergencyDetails')
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
                            <th>Blood Group</th>
                            <th>Contact Name</th>
                            <th>Contact Number</th>
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
                            <td>{{$user->blood_group}}</td>
                            <td>{{$user->emergency_contact_name}}</td>
                            <td>{{$user->emergency_contact_number}}</td>
                            <td>{{$user->created_at}}</td>
                            <td>{{$user->updated_at}}</td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="/dashboard/editUserEmergencyDetails/{{$user->id}}"><i class="bx bx-edit-alt me-2"></i> Edit</a>
                                        <a class="dropdown-item" href="/dashboard/deleteUserEmergencyDetails/{{$user->id}}"><i class="bx bx-trash me-2"></i> Delete</a>
                                    </div>
                                </div>
                            </td>
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