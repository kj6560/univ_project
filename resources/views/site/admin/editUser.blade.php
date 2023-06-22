@extends('site.layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-xl-9">
            <div class="row">
                <!-- HTML5 Inputs -->
                <form action="/dashboard/storeUser" method="POST">
                    @csrf
                    @if(isset($user))
                    <input type="hidden" name="id" value="{{$user->id}}">
                    @endif
                    <div class="card mb-4">
                        <h5 class="card-header">Edit Users</h5>

                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">First Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="first_name" value="{{isset($user) && $user->first_name?$user->first_name:''}}" placeholder="Enter First Name" id="first_name" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Last Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="{{isset($user) && $user->last_name?$user->last_name:''}}" placeholder="Enter Last Name" name="last_name" id="user_objective" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Password</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="password" placeholder="Enter password" name="password" id="password" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">user email</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" value="{{isset($user) &&  $user->email?$user->email:''}}" placeholder="Enter user Bio" name="email" id="email" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="exampleFormControlSelect1" class="form-label">Select User Role</label>
                                <select class="form-select" id="exampleFormControlSelect1" aria-label="Select User Role" name="user_role">
                                    <option selected>Select User Role</option>
                                    <option value="2" @if(isset($user) && $user->user_role==2) selected @endif>User</option>
                                    <option value="3" @if(isset($user) && $user->user_role==3) selected @endif>Admin</option>
                                    <option value="4" @if(isset($user) && $user->user_role==4) selected @endif>Manager</option>
                                </select>
                            </div>
                           
                            

                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">user number</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" placeholder="Enter user Number" name="number" value="{{isset($user) && $user->number?$user->number:''}}" id="number" />
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