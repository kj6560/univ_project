@extends('site.layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-xl-9">
            <div class="row">
                <!-- HTML5 Inputs -->
                <form action="/dashboard/storeSlider" enctype="multipart/form-data" method="POST">
                    @csrf
                    @if(isset($event))
                    <input type="hidden" name="slider_id" value="{{$slider->id}}">
                    @endif
                    <div class="card mb-4">
                        <h5 class="card-header">Create Events</h5>

                        <div class="card-body">
                            
                            <div class="mb-3 row">
                                <label for="exampleFormControlSelect1" class="form-label">Select Event</label>
                                <select class="form-select" id="exampleFormControlSelect1" aria-label="Select Event" name="event_id">
                                    <option selected>Select Event</option>

                                    @foreach($events as $event)
                                    <option value="{{$event->id}}" @if(isset($slider) && $slider->event_id==$event->id) selected @endif>{{$event->event_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Slider Image</label>
                                @if( isset($slider) && $slider->image)
                                <img src="{{asset('uploads/events/images/'.$slider->image)}}" height="50" width="50" alt="Avatar" class="rounded-circle" />
                                @endif
                                <input type="file" name="image" placeholder="Select Slider Image" id="inputImage" class="form-control">
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