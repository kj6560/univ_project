@extends('site.layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-xl-9">
            <div class="row">
                <!-- HTML5 Inputs -->
                <form action="/dashboard/storeUserAddressDetails" method="POST">
                    @csrf
                    @if(isset($user))
                    <input type="hidden" name="user_id" value="{{$user->user_id}}">
                    @endif
                    <div class="card mb-4">
                        <h5 class="card-header">Edit User Address details</h5>

                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Address Line 1</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" id="address_line1" value="{{isset($user) && $user->address_line1?$user->address_line1:''}}" name="address_line1">
                                </div>
                            </div>


                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">City</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="{{isset($user) &&  $user->city?$user->city:''}}" placeholder="Enter city" name="city" id="city" />
                                </div>
                            </div>

                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">State</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="{{isset($user) &&  $user->state?$user->state:''}}" placeholder="Enter State" name="state" id="state" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Pincode</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="{{isset($user) &&  $user->pincode?$user->pincode:''}}" placeholder="Enter Pincode" name="pincode" id="pincode" />
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