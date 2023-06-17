<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{env('SITE_NAME')}}</title>
    <link rel="stylesheet" type="text/css" href="{{asset('/css-1/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css-1/fontawesome-all.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css-1/iofrm-style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/css-1/iofrm-theme4.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
@php
$success = Session::get('success');
$error = Session::get('error');
@endphp

<body>
    <div class="form-body">
        <div class="website-logo">
            <a href="/">
                <div class="logo">
                    <img class="logo-size" src="{{asset('/images/logo2')}}" alt="">
                </div>
            </a>
        </div>
        <div class="row">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <img src="{{asset('/images/graphic1.svg')}}" alt="">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Password Reset</h3>
                        <p>Please Enter New Password</p>
                        <form action="/resetPasswordUser" method="POST">
                            @csrf
                            <input class="form-control" type="password" name="password1" placeholder="Enter Password" required>
                            <input class="form-control" type="password" name="email" value="{{$email}}" placeholder="Enter Password" hidden required>
                            <input class="form-control" type="password" name="password2" placeholder="Confirm Password" required>
                            <div class="form-button full-width">
                                <button id="submit" type="submit" class="ibtn btn-forget">Reset Password</button>
                            </div>
                        </form>
                    </div>
                    <div class="form-sent">
                        <div class="tick-holder">
                            <div class="tick-icon"></div>
                        </div>
                        <h3>Password link sent</h3>
                        <p>Please check your inbox <a href="http://brandio.io/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="84edebe2f6e9c4edebe2f6e9f0e1e9f4e8e5f0e1aaedeb">[email&#160;protected]</a></p>
                        <div class="info-holder">
                            <span>Unsure if that email address was correct?</span> <a href="#">We can help</a>.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js-1"></script>
    <script src="{{asset('/js-1/jquery.min.js-1')}}"></script>
    <script src="{{asset('/js-1/popper.min.js')}}"></script>
    <script src="{{asset('/js-1/bootstrap.min.js')}}"></script>
    <script src="{{asset('/js-1/main.js')}}"></script>
</body>
<script>
    var success = "{{!empty($success)?$success:'NA'}}";
    var error = "{{!empty($error)?$error:'NA'}}";
    if (success != 'NA') {
        Swal.fire({
            title: 'Password updated successfully',
            text: success,
            icon: 'success',
            confirmButtonText: 'Okay',
            onclick() {
                console.log('Okay');
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/';
            }
        })
    }
    if (error != 'NA') {
        Swal.fire({
            title: 'Password Update Failed!',
            text: error,
            icon: 'error',
            confirmButtonText: 'Okay',
            onclick() {
                console.log('Okay');
            }
        });
    }
</script>

</html>