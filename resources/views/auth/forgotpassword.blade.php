@extends('authentication.layout.layout')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row"> </div>
            <div class="content-body">
                <section class="flexbox-container">
                    <div class="col-12 d-flex px-0 align-items-center justify-content-center">
                        <div class="col-md-4 col-12 box-shadow-2 p-0">
                            <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
                                <div class="card-header border-0 pb-0 px-0">
                                    <div class="card-title text-center"> <img height="100" src="{{asset('public/app-assets/images/logo/logo4.png')}}" alt="branding logo"> </div>
                                    <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2"> <span>We will send you a link to reset password.</span> </h6>
                                </div>
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
                                <div class="card-content">
                                    <div class="card-body px-0 pt-0">
                                        <form class="form-horizontal" id="forgotpasswords" action="{{route('resetpass')}}" novalidate>
                                            <fieldset class="form-group position-relative has-icon-left forgotpassword">
                                                <input type="email" name="email" class="form-control form-control-lg input-lg required" id="user-email"
                                                       placeholder="Your Email Address" required>
                                                <div class="form-control-position"> <i class="ft-mail"></i> </div>
                                            </fieldset>
                                            <button type="submit" class="btn white btn-lg btn-block login_btn_rec"><i class="ft-unlock"></i> Recover Password</button>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-footer py-0 px-0  border-0">
                                    <p class="col-md-12 col-12 px-0 float-sm-left text-right"><a href="{{route('login')}}" class="card-link login_color_change">Back to Login</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

@endsection
