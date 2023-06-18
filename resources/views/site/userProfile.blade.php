@extends('site.layouts.site')
@section('content')
<style type="text/css">
    body {
        margin-top: 20px;
        color: #1a202c;
        text-align: left;
        background-color: #e2e8f0;
    }

    .main-body {
        padding: 15px;
    }

    .card {
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
    }

    .newbtn {
        max-width: 78%;
    }

    .newbtn2 {
        max-width: 37%;
    }

    .card {
        position: relative;
        display: flex;
        flex-direction: column;
        min-width: 0;
        word-wrap: break-word;
        background-color: #fff;
        background-clip: border-box;
        border: 0 solid rgba(0, 0, 0, .125);
        border-radius: .25rem;
    }

    .card-body {
        flex: 1 1 auto;
        min-height: 1px;
        padding: 1rem;
    }

    .gutters-sm {
        margin-right: -8px;
        margin-left: -8px;
    }

    .gutters-sm>.col,
    .gutters-sm>[class*=col-] {
        padding-right: 8px;
        padding-left: 8px;
    }

    .mb-3,
    .my-3 {
        margin-bottom: 1rem !important;
    }

    .bg-gray-300 {
        background-color: #e2e8f0;
    }

    .h-100 {
        height: 100% !important;
    }

    .shadow-none {
        box-shadow: none !important;
    }
</style>
<div class="container">
    <div class="main-body">
        <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="{{(!empty($userPersonalDetails->image))?asset('uploads/users/profile_pics/'.$userPersonalDetails->image):''}}" alt="Admin" class="rounded-circle" width="150">
                            <div class="mt-3">
                                <h4>{{ucfirst($user->first_name)}} {{ucfirst($user->last_name)}}</h4>
                                <br>
                                <input type="file" name="profile_image" style="margin-left: 130px;" id="profile_image">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap cont_details active">
                            <h6 class="mb-0" id="cont_det" style="cursor: pointer;">Contact Details</h6>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap pers_details">
                            <h6 class="mb-0" id="pers_det" style="cursor: pointer;">Personal Details/Documents</h6>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap emer_details">
                            <h6 class="mb-0 " id="emer_det" style="cursor: pointer;">Emergency Contact Details</h6>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-8" id="personal_details" hidden>
                <div class="card mb-3">
                    <div class="card-body">
                        <form action="/userUpdatePersonalDetails" enctype="multipart/form-data" method="POST">
                            @csrf
                            <input type="text" class="form-control" name="user_id" value="{{$user->id}}" placeholder="First Name" hidden>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Gender</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <select class="form-control" name="gender" required>
                                        <option value="0">Select Gender</option>
                                        <option value="1" {{!empty($userPersonalDetails->gender) && $userPersonalDetails->gender==1?'selected':''}}>Male</option>
                                        <option value="2" {{!empty($userPersonalDetails->gender) && $userPersonalDetails->gender==2?'selected':''}}>Female</option>
                                        <option value="3" {{!empty($userPersonalDetails->gender) && $userPersonalDetails->gender==3?'selected':''}}>Other</option>
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Height (in CM)</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="height" value="{{!empty($userPersonalDetails->height)?$userPersonalDetails->height:''}}" placeholder="height" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Weight (in KG)</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="weight" value="{{!empty($userPersonalDetails->weight)?$userPersonalDetails->weight:''}}" placeholder="weight" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Age</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="age" value="{{!empty($userPersonalDetails->age)?$userPersonalDetails->age:''}}" placeholder="Age" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-9">
                                    <input type="file" name="doc_image" style="margin-left: px;">
                                    <br><br>Please upload any one of the mentioned document : Aadhar Card, Driving License ,
                                    Voter ID Card, Pan Card for verification purposes
                                </div>

                            </div>
                            <hr>
                            <button class=" btn btn-info"> Save</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-8" id="emergency_details" hidden>
                <div class="card mb-3">
                    <div class="card-body">
                        <form action="/userUpdateEmergencyDetails" method="post">
                            @csrf
                            <input type="text" class="form-control" name="user_id" value="{{$user->id}}" placeholder="First Name" hidden>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Blood Group</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="blood_group" value="{{!empty($emergencyContactDetails->blood_group)?$emergencyContactDetails->blood_group:''}}" placeholder="Blood Group" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Emergency Contact Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="emergency_contact_name" value="{{!empty($emergencyContactDetails->emergency_contact_name)?$emergencyContactDetails->emergency_contact_name:''}}" placeholder="Emergency Contact Name">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Emergency Contact Number</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="emergency_contact_number" value="{{!empty($emergencyContactDetails->emergency_contact_number)?$emergencyContactDetails->emergency_contact_number:''}}" placeholder="Contact Number">
                                </div>
                            </div>
                            <hr>
                            <button class=" btn btn-info"> Save</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8" id="contact_details">
                <div class="card mb-3">
                    <div class="card-body">
                        <form action="/userUpdateContactDetails" method="post">
                            @csrf
                            <input type="text" class="form-control" name="user_id" value="{{$user->id}}" placeholder="First Name" hidden>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">First Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="first_name" value="{{$user->first_name?$user->first_name:''}}" placeholder="First Name" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Last Name</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="last_name" value="{{$user->last_name?$user->last_name:''}}" placeholder="Last Name">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Email</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="email" value="{{$user->email?$user->email:''}}" placeholder="email" disabled>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Mobile</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="number" value="{{$user->number?$user->number:''}}" placeholder="Number" required>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Address Line 1</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="address_line1" value="{{!empty($userAddressDetails->address_line1)?$userAddressDetails->address_line1:''}}" placeholder="Address Line 1">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">City</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="city" value="{{!empty($userAddressDetails->city)?$userAddressDetails->city:''}}" placeholder="City">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">State</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="state" value="{{!empty($userAddressDetails->state)?$userAddressDetails->state:''}}" placeholder="State">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-3">
                                    <h6 class="mb-0">Pincode</h6>
                                </div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="text" class="form-control" name="pincode" value="{{!empty($userAddressDetails->pincode)?$userAddressDetails->pincode:''}}" placeholder="Pincode">
                                </div>
                            </div>
                            <hr>
                            <button class=" btn btn-info"> Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var contact_details = document.getElementById("cont_det");
        var personal_details = document.getElementById("pers_det");
        var emergency_details = document.getElementById("emer_det");

        var _contact_details = document.getElementById("contact_details");
        var _personal_details = document.getElementById("personal_details");
        var _emergency_details = document.getElementById("emergency_details");

        contact_details.addEventListener("click", function() {
            _personal_details.hidden = true;
            _emergency_details.hidden = true;
            _contact_details.hidden = false;
            $('.pers_details').removeClass('active');
            $('.emer_details').removeClass('active');
            $('.cont_details').addClass('active');
        });
        personal_details.addEventListener("click", function() {
            _contact_details.hidden = true;
            _emergency_details.hidden = true;
            _personal_details.hidden = false;
            $('.cont_details').removeClass('active');
            $('.emer_details').removeClass('active');
            $('.pers_details').addClass('active');
        });
        emergency_details.addEventListener("click", function() {
            _personal_details.hidden = true;
            _contact_details.hidden = true;
            _emergency_details.hidden = false;
            $('.pers_details').removeClass('active');
            $('.cont_details').removeClass('active');
            $('.emer_details').addClass('active');
        });
        $('#profile_image').change(function() {
            var file_data = $('#profile_image').prop('files')[0];
            var form_data = new FormData();
            form_data.append('file', file_data);
            form_data.append('user_id', "{{$user->id}}");
            form_data.append('_token', "{{csrf_token()}}");
            $.ajax({
                url: "/userUpdateProfilePic",
                type: "POST",
                data: form_data,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    console.log(data);
                }
            });
        });
    });
</script>

@stop