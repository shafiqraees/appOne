<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('marketing.layouts.head')
<body class="vertical-layout vertical-menu-modern 2-columns menu-expanded fixed-navbar"
      data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
@include('marketing.layouts.header')
@include('marketing.layouts.aside_bar')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row"> </div>
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="col-md-4 col-10 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 m-0">
                                <div class="card-header border-0">
                                    <div class="card-title text-center">
                                        <div class="p-1"> <img src="app-assets/images/logo/logo-dark.png" alt="branding logo"> </div>
                                    </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"> <span>Login with App One</span> </h6>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <form class="form-horizontal  " action="index.php" novalidate>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="text" class="form-control form-control-lg input-lg" id="user-name" placeholder="Your Email"
                                                       required>
                                                <div class="form-control-position"> <i class="ft-user"></i> </div>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left">
                                                <input type="password" class="form-control form-control-lg input-lg" id="user-password"
                                                       placeholder="Enter Password" required>
                                                <div class="form-control-position"> <i class="la la-key"></i> </div>
                                            </fieldset>
                                            <div class="form-group row">
                                                <div class="col-md-12 col-12"><a href="recover-password.php" class="card-link black">Forgot Password?</a></div>
                                            </div>
                                            <a href="dashboard.php" class="btn-amber btn-border-amber btn-lg btn-block white text-center"><i class="ft-unlock"></i> Login</a>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@show
@include('marketing.layouts.footer')
@include('marketing.layouts.footer_script')
</body>
</html>
