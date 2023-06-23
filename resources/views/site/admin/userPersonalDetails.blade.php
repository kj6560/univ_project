@extends('site.layouts.admin')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="content-wrapper">
        <!-- Responsive Table -->
        <h5 class="card-header">Users Personal Details (Total: {{$users instanceof Illuminate\Pagination\LengthAwarePaginator?$users->total():count($users)}} )</h5>
        @include('site.filters.userfilter')
        <div class="card">

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr class="text-nowrap">
                            <th>User Id</th>
                            <th>DOB</th>
                            <th>Gender</th>
                            <th>Married</th>
                            <th>Height</th>
                            <th>Weight</th>
                            <th>Age</th>
                            <th>User Doc</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <th scope="row">{{$user->id}}</th>
                            <td>{{$user->birthday}}</td>
                            <td>{{$user->gender==1?'Male':'Female'}}</td>
                            @if(!empty($user->married) && $user->married ==1)
                            <td>Yes</td>
                            @elseif(!empty($user->married) && $user->married ==0)
                            <td>Yes</td>
                            @else
                            <td>Not Available</td>
                            @endif
                            <td>{{$user->height}}</td>
                            <td>{{$user->weight}}</td>
                            <td>{{$user->age}}</td>
                            <td>{{$user->user_doc}}</td>
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