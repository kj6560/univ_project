@extends('site.layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-xl-9">
            <div class="row">
                <!-- HTML5 Inputs -->
                <form action="/dashboard/storeUserEmergencyDetails" method="POST">
                    @csrf
                    @if(isset($user))
                    <input type="hidden" name="user_id" value="{{$user->user_id}}">
                    @endif
                    <div class="card mb-4">
                        <h5 class="card-header">Edit User Emergency details</h5>

                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Blood Group</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" id="blood_group" value="{{isset($user) && $user->blood_group?$user->blood_group:''}}" name="blood_group">
                                </div>
                            </div>


                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Emergency Contact Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="{{isset($user) &&  $user->emergency_contact_name?$user->emergency_contact_name:''}}" placeholder="Enter emergency contact name" name="emergency_contact_name" id="emergency_contact_name" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Emergency Contact Number</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="{{isset($user) &&  $user->emergency_contact_number?$user->emergency_contact_number:''}}" placeholder="Enter emergency contact number" name="emergency_contact_number" id="emergency_contact_number" />
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