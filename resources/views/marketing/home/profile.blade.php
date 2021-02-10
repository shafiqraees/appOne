@extends('marketing.layouts.marketer')
@section('content')
    <div class="app-content content list_custom_setting5">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Profile</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Settings</a> </li>
                                <li class="breadcrumb-item active">Profile</li>
                            </ol>
                        </div>
                    </div>
                </div>
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
            <div class="content-body">
                <form name="update-profile" method="post" action="{{route('update.profile',$user->id)}}" enctype="multipart/form-data">
                    @csrf
                    <section id="user-profile-cards" class="row match-height">
                        <div class="col-xl-3 col-md-3 col-12">
                            <div class="card border-blue-grey border-lighten-2">
                                <div class="text-center">
                                    <div class="avatar-upload">
                                        <div class="avatar-edit">
                                            <input type='file' name="profile_pic" id="imageUpload" accept=".png, .jpg,, .MP4, .jpeg" />
                                            <label for="imageUpload"></label>
                                        </div>
                                        <div class="avatar-preview">
                                            <div id="imagePreview" style="
                                                background-image: url({{Storage::disk('s3')->exists('md/'.$user->profile_photo_path) ? Storage::disk('s3')->url('md/'.$user->profile_photo_path) : Storage::disk('s3')->url('default.png')}});">
                                            </div>
                                            <h4 class="card-title mt-2 mb-0">{{$user->name}}</h4>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9 col-md-9 col-12">
                            <div class="content-body">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-6 mt-1">
                                                <label for="sel1">Name</label>
                                                <fieldset>
                                                    <div class="input-group">

                                                        <div class="input-group-append"> <span class="input-group-text bg-dark  border-dark  white" id="basic-addon4"><i class="la la-user"></i></span> </div>
                                                        <input  type="text" name="name" id="username" value="{{$user->name}}" class="form-control errormessage heightinputs" placeholder="Name" aria-describedby="basic-addon4" required>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-md-6 mt-1">
                                                <label for="sel1">Email Address</label>
                                                <fieldset>
                                                    <div class="input-group">

                                                        <div class="input-group-append"> <span class="input-group-text bg-dark  border-dark white" id="basic-addon4"><i class="la la-envelope"></i></span> </div>
                                                        <input  type="email" name="email" value="{{$user->email}}"  class="form-control errormessage heightinputs" placeholder="Email" aria-describedby="basic-addon4" readonly>
                                                    </div>
                                                </fieldset>
                                                <br>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="sel1">Password</label>
                                                <fieldset>
                                                    <div class="input-group">

                                                        <div class="input-group-append"> <span class="input-group-text bg-dark border-dark white" id="basic-addon4"><i class="la la-lock"></i></span> </div>
                                                        <input  type="password" pattern=".{5,}" minlength="5" id="txtPassword" name="Password" class="form-control errormessage heightinputs" placeholder="New Password" aria-describedby="basic-addon4">
                                                    </div>
                                                </fieldset>
                                                <br>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="sel1">Repeat Password</label>
                                                <fieldset>
                                                    <div class="input-group">

                                                        <div class="input-group-append"> <span class="input-group-text bg-dark border-dark white" id="basic-addon4"><i class="la la-lock"></i></span> </div>
                                                        <input  type="password" pattern=".{5,}" minlength="5" id="txtConfirmPassword" name="password_confirmation" class="form-control errormessage heightinputs" placeholder="Repeat Password" aria-describedby="basic-addon4">
                                                        <input type="hidden" name="id" value="{{$user->id}}">
                                                        <span id='message'></span>
                                                    </div>
                                                </fieldset>
                                                <br>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-actions">
                                                    <button type="submit" class="btn btn-dark btn-dark btn-dark text-center pr-1 float-right"> <span class="ft-edit font-medium-3"></span> Update</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </div>
@endsection

