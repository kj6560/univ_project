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



<body>
    @php
    $success = Session::get('success');
    $error = Session::get('error');
    @endphp
    @php
    $email = $settings['site_email'];
    $number = $settings['site_number'];
    @endphp

    <div class="form-body">

        <div class="website-logo">

            <a href="index.html">

                <div class="logo">

                    <img class="logo-size" src="{{asset('/images/logo.svg')}}" alt="">

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

                        <h3>Univ Sporta Tech.</h3>

                        <p>Please Raise an account deletion request.</p>



                        <form method="POST" action="/requestDelete">

                            @csrf

                            <input class="form-control" type="text" name="email" placeholder="E-mail Address" required>

                            <input class="form-control" type="text" name="reason" placeholder="Enter reason for deletion" required>

                            <div class="form-button">

                                <button id="submit" type="submit" class="ibtn">Submit</button>

                            </div>

                        </form>



                    </div>

                </div>

            </div>

        </div>

    </div>

    <script src="{{asset('/js-1/jquery.min.js')}}"></script>

    <script src="{{asset('/js-1/popper.min.js')}}"></script>

    <script src="{{asset('/js-1/bootstrap.min.js')}}"></script>

    <script src="{{asset('/js-1/main.js')}}"></script>

</body>

<script>
    var success = "{{!empty($success)?$success:'NA'}}";
    var error = "{{!empty($error)?$error:'NA'}}";
    console.log(success);
    if (success != 'NA') {
        Swal.fire({
            title: 'Done',
            text: success,
            icon: 'success',
            confirmButtonText: 'Okay',

        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '/';
            }
        })
    }
    if (error != 'NA') {
        Swal.fire({
            title: 'Failed!',
            text: error,
            icon: 'error',
            confirmButtonText: 'Okay',

        });
    }
</script>

</html>