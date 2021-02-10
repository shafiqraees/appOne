@extends('authentication.layout.layout')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row"> </div>
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex px-0 align-items-center justify-content-center">
                        <div class="col-md-4 col-12 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 m-0">
                                <div class="card-header border-0">
                                    <div class="card-title text-center">
                                         <img height="100" src="{{asset('public/app-assets/images/logo/logo4.png')}}" alt="branding logo">
                                    </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"> <span>Login with App One</span> </h6>
                                </div>

                                <div class="card-content">
                                    <div class="card-body">
                                        @if ($errors->any())

                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        @if (session()->has('success'))
                                            <div class="alert alert-success">
                                                @if(is_array(session('success')))
                                                    <ul>
                                                        @foreach (session('success') as $message)
                                                            <li>{{ $message }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    {{ session('success') }}
                                                @endif
                                            </div>

                                        @endif
                                        <form id="login-form" method="POST" name="registration" action="{{ route('login') }}">
                                            @csrf
                                            <fieldset class="form-group position-relative has-icon-left login_admin_error">
                                                <input type="email" name="email" class="form-control form-control-lg input-lg" id="email" placeholder="Your Email">
                                                <div class="form-control-position"> <i class="ft-user"></i> </div>
                                            </fieldset>
                                            <fieldset class="form-group position-relative has-icon-left login_admin_error">
                                                <input type="password" name="password" class="form-control form-control-lg input-lg" id="user-password" placeholder="Enter Password" >
                                                <div class="form-control-position"> <i class="la la-key"></i> </div>
                                            </fieldset>
                                            <div class="form-group row">
                                                 <div class="col-md-12 col-12 text-right"><a href="{{url('/recover-password')}}" class="card-link login_color_change">Forgot Password?</a></div>

                                            </div>

                                            <button type="submit" class="btn-lg btn-block white text-center login_btn"><i class="ft-unlock"></i>
                                                {{ __('Login') }}
                                            </button>
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
@endsection
