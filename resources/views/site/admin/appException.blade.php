@extends('site.layouts.admin')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="content-wrapper">
        <!-- Responsive Table -->
        <h5 class="card-header">App Exceptions (Total: {{$exceptions instanceof Illuminate\Pagination\LengthAwarePaginator?$exceptions->total():count($exceptions)}})</h5>

        <div class="card">

            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr class="text-nowrap">
                            <th>User Name</th>
                            <th>Execption Message</th>
                            <th>Exception Source</th>
                            <th>Exception Status</th>
                            <th>Exception Location</th>
                            <th>Exception Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($exceptions as $exception)
                        <tr>
                            <td>{{$exception->user_name}}</td>
                            <td>{{$exception->exception_msg}}</td>
                            <td>{{$exception->source ==1 ? "web":"mobile"}}</td>
                            <td>{{$exception->status ==1 ? "Active":"Inactive"}}</td>
                            <td>{{$exception->exception_location}}</td>
                            <td>{{$exception->created_at}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="col-12">
                    @php
                    if($exceptions instanceof Illuminate\Pagination\LengthAwarePaginator){
                    @endphp
                    {!! $exceptions->links('pagination::bootstrap-4') !!}
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