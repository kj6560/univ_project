@extends('site.layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">\
        <div class="row">
            <div class="col-xl-3">
                <div class="card mb-4">
                    <h5 class="card-header">Generate Database Backup</h5>
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <label for="html5-search-input" class="col-md-2 col-form-label"></label>
                            <form action="/doBackup" method="get" id="back">
                                <input class="btn btn-primary" type="submit" value="submit" id="submit" />
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="card mb-4">
                    <h5 class="card-header">Last Database Backup</h5>
                    <div class="card-body">
                        <div class="row">
                            <label for="html5-search-input" class="col-md-2 col-form-label"></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var form = document.getElementById("back");
    form.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent default form submission

        var csrfToken = document.getElementsByName('_token')[0].content; // Get the CSRF token value
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var responseData = xhr.responseText;
                    console.log(responseData);
                } else {
                    console.error('Request failed with status:', xhr.status);
                }
            }
        };

        xhr.open('GET', '/doBackup', true);
        xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken); // Set CSRF token in the header

        xhr.send();
    });
</script>
@stop