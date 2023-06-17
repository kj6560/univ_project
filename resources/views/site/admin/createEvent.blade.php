@extends('site.layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-xl-9">
            <div class="row">
                <!-- HTML5 Inputs -->
                <form action="/dashboard/storeEvent" enctype="multipart/form-data" method="POST">
                    @csrf
                    @if(isset($event))
                    <input type="hidden" name="event_id" value="{{$event->id}}">
                    @endif
                    <div class="card mb-4">
                        <h5 class="card-header">Create Events</h5>

                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="event_name" value="{{isset($event) && $event->event_name?$event->event_name:''}}" placeholder="Enter Event Name" id="event_name" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Event Objective</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="{{isset($event) && $event->event_objective?$event->event_objective:''}}" placeholder="Enter Event Objective" name="event_objective" id="event_objective" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Event Bio</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="{{isset($event) &&  $event->event_bio?$event->event_bio:''}}" placeholder="Enter Event Bio" name="event_bio" id="event_bio" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="exampleFormControlSelect1" class="form-label">Select Category</label>
                                <select class="form-select" id="exampleFormControlSelect1" aria-label="Select Category" name="event_category">
                                    <option selected>Select Category</option>
                                    
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}" @if(isset($event) && $event->event_category==$category->id) selected @endif>{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Event Date</label>
                                <div class="col-md-10">
                                    <input type="datetime-local" id="birthdaytime" value="{{isset($event) && $event->event_date?$event->event_date:''}}" name="event_date">
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Event Location</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" placeholder="Enter Event Location" name="event_location" value="{{isset($event) && $event->event_location?$event->event_location:''}}" id="event_location" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Event Live Link</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" placeholder="Enter Event Live Link" name="event_live_link" value="{{isset($event) && $event->event_live_link?$event->event_live_link:''}}" id="event_live_link" />
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="formFile" class="form-label">Event Main Image</label>
                                @if( isset($event) && $event->event_image)
                                <img src="{{asset('uploads/events/images/'.$event->event_image)}}" height="50" width="50" alt="Avatar" class="rounded-circle" />
                                @endif
                                <input type="file" name="image" placeholder="Select Event Main Image" id="inputImage" class="form-control">
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