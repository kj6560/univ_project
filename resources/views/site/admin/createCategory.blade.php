@extends('site.layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-xl-6">
            <div class="row">
                <!-- HTML5 Inputs -->
                <form action="/dashboard/storeCategory" enctype="multipart/form-data"  method="POST">
                    @csrf
                    <div class="card mb-4">
                        <h5 class="card-header">Create Category</h5>

                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="name" placeholder="Enter Category Name" id="html5-text-input" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Description</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="description" id="html5-text-input" />
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="formFile" class="form-label">Icons</label>
                                <input type="file" name="image" id="inputImage" class="form-control">
                            </div>
                            <div class="mb-3 row">
                                <label for="html5-search-input" class="col-md-2 col-form-label"></label>
                                <div class="col-md-10">
                                    <input class="btn btn-primary" type="submit" value="submit" id="html5-search-input" />
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