@extends('site.layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-xl-9">
            <div class="row">
                <!-- HTML5 Inputs -->
                <form action="/dashboard/storeSettings"  method="POST">
                    @csrf
                    @if(isset($settings))
                    <input type="hidden" name="id" value="{{$settings->id ?$settings->id:0}}">
                    @endif
                    <div class="card mb-4">
                        <h5 class="card-header">Create Settings</h5>

                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="site_key" value="{{isset($settings) && $settings->site_key?$settings->site_key:''}}" placeholder="Enter settings key" id="event_name" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Event Objective</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="site_value" value="{{isset($settings) && $settings->site_value?$settings->site_value:''}}" placeholder="Enter Settings value" id="event_objective" />
                                </div>
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