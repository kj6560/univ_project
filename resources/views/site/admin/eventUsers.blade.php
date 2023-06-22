@extends('site.layouts.admin')
@section('content')
<style>
    input {
        margin: 15px;
        padding: 2px 3px;
        width: 209px;
    }

    .filter {
        display: none;
        padding: 5px;
    }

    .header {
        cursor: pointer;
        margin: 15px;
    }
</style>
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="content-wrapper">
        <!-- Responsive Table -->
        <div class="card">
            <h5 class="card-header">Users Registered for Event (Total: {{$eventusers->total()}} users)</h5>
            @include('site.filters.userfilter')
            <a href="/dashboard/downloadEventUsers" class="btn btn-primary" style="width: 200px;margin-left: 10px">Download</a>
            <div class="table-responsive text-nowrap">
                <table class="table" id="table">
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
<script src="{{asset('admin/assets')}}/vendor/libs/jquery/jquery.js"></script>
<script>
    var $rows = $('#table tr');
    $('#search').keyup(function() {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

        $rows.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });
    $(".header").click(function() {

        $content = $('.filter');
        $content.slideToggle(500, function() {
            //execute this after slideToggle is done
            //change text of header based on visibility of content div
            // $header.text(function() {
            //     //change text based on condition
            //     return $content.is(":visible") ? "Collapse" : "Expand";
            // });
        });

    });
</script>
@stop