@extends('site.layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-xl-9">
            <div class="row">
                <!-- HTML5 Inputs -->
                <form action="/dashboard/storeEmailTemplates" enctype="multipart/form-data" method="POST">
                    @csrf
                    @if(isset($template))
                    <input type="hidden" name="template_id" value="{{$templates->id}}">
                    @endif
                    <div class="card mb-4">
                        <h5 class="card-header">Create Events</h5>

                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Template Name</label>
                                <div class="col-md-10">
                                    <input class="form-control" type="text" name="template_name" value="{{isset($template) && $template->template_name?$template->template_name:''}}" placeholder="Enter Template Name" id="template_name" />
                                </div>
                            </div>
                            <div class="mb-3 row">
                                <label for="html5-text-input" class="col-md-2 col-form-label">Template Data</label>
                                <div class="col-md-10" id="editorjs">
                                    <input type="text" name="template_data" id="template_data" />
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
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: 'textarea#template_data', // Replace this CSS selector to match the placeholder element for TinyMCE
        plugins: 'code table lists',
        toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
    });
</script>
@stop