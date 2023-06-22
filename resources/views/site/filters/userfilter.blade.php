<div class="header">
    <span>Expand</span>
</div>
<div class="col-xl-9 filter">
    <div class="row">
        <!-- HTML5 Inputs -->
        <form action="/dashboard/eventUsers" method="get">
            @csrf

            <div class="card mb-4">
                <h5 class="card-header">Search User</h5>

                <div class="card-body">
                    <div class="mb-3 row">
                        <label for="html5-text-input" class="col-md-2 col-form-label">User Name</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="user_name" value="{{$filters['user_name'] ?? ''}}" placeholder="Enter first name and last name seperated by space" id="user_name" />
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="html5-text-input" class="col-md-2 col-form-label">User Email</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="user_email" value="{{$filters['user_email'] ?? ''}}" placeholder="Enter user email" id="user_email" />
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="html5-text-input" class="col-md-2 col-form-label">User Phone Number</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="number" value="{{$filters['number'] ?? ''}}" placeholder="Enter phone number" id="number" />
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