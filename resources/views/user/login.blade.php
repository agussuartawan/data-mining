<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>PT. Trisno Mitra Bali</title>
    <link href="{{ asset('') }}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('') }}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="{{ asset('') }}/css/ruang-admin.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-login">
    <!-- Login Content -->
    <div class="container-login">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-12 col-md-9">
                <div class="card shadow-sm my-5 w-75 mx-auto">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="login-form">
                                    <div class="text-center">
                                        <img src="{{ asset('') }}/img/logo-tmb.jpg"
                                            class="img-thumbnail rounded-circle" style="max-width:40%;">
                                        <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                    </div>
                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            Login gagal.
                                        </div>
                                    @endif
                                    <form class="user" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="form-group">
                                            <input id="email" type="email"
                                                class="form-control" name="email"
                                                value="{{ old('email') }}" required autocomplete="email" autofocus
                                                placeholder="Enter Email Address">
                                        </div>
                                        <div class="form-group">
                                            <input id="password" type="password"
                                                class="form-control"
                                                name="password" required autocomplete="current-password"
                                                placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login Content -->
    <script src="{{ asset('') }}/vendor/jquery/jquery.min.js"></script>
    <script src="{{ asset('') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('') }}/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="{{ asset('') }}/js/ruang-admin.min.js"></script>
</body>

</html>
