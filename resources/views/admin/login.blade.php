<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">

        <title>Login Admin - Work Produktif</title>

        <meta name="description" content="Work Produktif">
        <meta name="robots" content="noindex, nofollow">
        <!-- Stylesheets -->
        <!-- Codebase framework -->
        <link rel="stylesheet" id="css-main" href="/css/codebase.min.css">
        @vite(['resources/sass/main.scss', 'resources/js/codebase/app.js',
        'resources/js/app.js'])
    </head>

    <body>
        <div id="page-container" class="main-content-boxed">

            <!-- Main Container -->
            <main id="main-container">
                <!-- Page Content -->
                    <div class="row mx-0 justify-content-center">
                        <div class="hero-static col-lg-6 col-xl-5">
                            <div class="content content-full overflow-hidden">
                                <!-- Header -->
                                <div class="py-4 text-center">
                                    <img src="/images/logo.png" width="200px">
                                </div>
                                <!-- END Header -->
                                <div class="block border-top border-secondary border-3 block-rounded mt-md-5">
                                    <div class="block-content">
                                        <form method="POST" action="{{ route('admin.login') }}">
                                            @csrf
                                            <div class="mb-4">
                                                <label class="form-label" for="val-username">Username
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" class="form-control {{ $errors->has('username') ? 'is-invalid' : '' }}" id="val-username" name="username">
                                                <x-input-error :messages="$errors->get('username')" class="mt-2" />
                                            </div>
                                            <div class="mb-4">
                                                <label class="form-label" for="val-password">Password
                                                    <span class="text-danger">*</span>
                                                </label>
                                                <input type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="val-password" name="password">
                                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                            </div>
                                            <div class="mb-4">
                                            <button type="submit" class="btn btn-lg btn-primary fw-medium w-100">
                                                Login
                                            </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- END Sign Up Form -->
                            </div>
                        </div>
                    </div>
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->
        </div>
        <!-- END Page Container -->
    </body>
</html>