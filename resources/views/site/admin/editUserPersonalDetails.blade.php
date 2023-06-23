@extends('site.layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-xl-9">
            <div class="row">
                <!-- HTML5 Inputs -->
                <form action="/dashboard/storeUserPersonalDetails" enctype="multipart/form-data" method="POST">
                    @csrf
                    @if(isset($user))
                    <input type="hidden" name="user_id" value="{{$user->user_id}}">
                    @endif
                    <div class="card mb-4">
                        <h5 class="card-header">Edit Users</h5>

                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Birthday</label>
                                <div class="col-md-10">
                                    <input type="datetime-local" id="birthdaytime" value="{{isset($user) && $user->birthday?$user->birthday:''}}" name="birthday">
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="exampleFormControlSelect1" class="form-label">Select Gender</label>
                                <select class="form-select" id="exampleFormControlSelect1" aria-label="Select Gender" name="gender">
                                    <option selected>Select Gender</option>
                                    <option value="1" @if(isset($user) && $user->gender==1) selected @endif>Male</option>
                                    <option value="2" @if(isset($user) && $user->gender==2) selected @endif>Female</option>
                                    <option value="3" @if(isset($user) && $user->gender==3) selected @endif>Other</option>
                                </select>
                            </div>
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Married</label>
                                <select class="form-select" id="exampleFormControlSelect1" aria-label="Select Marital Status" name="married">
                                    <option selected>Select Marital Status</option>
                                    <option value="1" @if(isset($user) && $user->married==1) selected @endif>Married</option>
                                    <option value="0" @if(isset($user) && $user->married==0) selected @endif>UnMarried</option>
                                </select>
                            </div>
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Height</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="{{isset($user) &&  $user->height?$user->height:''}}" placeholder="Enter Height" name="height" id="height" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Weight</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="{{isset($user) &&  $user->weight?$user->weight:''}}" placeholder="Enter weight" name="weight" id="weight" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Age</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="{{isset($user) &&  $user->age?$user->age:''}}" placeholder="Enter Age" name="age" id="age" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Doc Image</label>
                                <input type="file" name="user_doc" style="margin-left: px;">

                            </div>
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Profile Picture</label>
                                <input type="file" name="profile_image" style="margin-left: 130px;" id="profile_image">
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