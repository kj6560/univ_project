@extends('site.layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-xl-9">
            <a href="/dashboard/processEventResults" class="btn btn-primary">Process result</a>
            <div class="row">
                <!-- HTML5 Inputs -->
                <form action="/dashboard/storeEventResults" enctype="multipart/form-data" method="POST">
                    @csrf

                    <div class="card mb-4">
                        <h5 class="card-header">Upload Event Results</h5>

                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="exampleFormControlSelect1" class="form-label">Select Event</label>
                                <select class="form-select" id="exampleFormControlSelect1" 
                                aria-label="Select Priority" name="event_id">
                                    <option value="0">Select Event</option>
                                    @foreach($events as $event)
                                    <option value="{{$event->id}}">{{$event->event_name}}</option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="mb-3">
                                <label for="formFile" class="form-label">Csv File</label>
                                <input type="file" name="file" id="inputImage" class="form-control">
                            </div>

                            <div class="mb-3 row">
                                <label for="html5-search-input" class="col-md-2 col-form-label"></label>
                                <div class="col-md-10">
                                    <input class="btn btn-primary" type="submit" value="submit" id="submit" />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop