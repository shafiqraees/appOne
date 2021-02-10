@extends('admin.layouts.main')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Push Notifications Create</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item"><a href="{{route('allpushnotifications')}}">Push Notifications</a> </li>
                                <li class="breadcrumb-item active">Push Notifications Create </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            @if (session()->has('success'))
                <div class="alert alert-success"> @if(is_array(session('success')))
                        <ul>
                            @foreach (session('success') as $message)
                                <li>{{ $message }}</li>
                            @endforeach
                        </ul>
                    @else
                        {{ session('success') }}
                    @endif </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="content-body">
                <form class="form-horizontal" id="formsss" method="post" action="{{route('admin.generate.pushnotification')}}" name="specifycontent">
                    @csrf
                    <section id="card-bordered-options">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="card box-shadow-0 border-dark">
                                    <div class="card-header card-head-inverse bg-dark">
                                        <h4 class="card-title text-white">Select Audience </h4>
                                    </div>
                                    <div class="card-content collapse show">
                                        <div class="card-body">
                                            <section class="icheck-radio">
                                                <div class="row">
                                                    <div class="col-xl-12 col-lg-12">
                                                        <div class="card">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label class="inline-block" for="sel1">Gender</label>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <fieldset class="row abc">
                                                                        <label class="col-md-5">
                                                                            <input id="input-radio-11" type="radio" name="gender" value="male" class="css-checkbox" checked />
                                                                            Male<span></span></label>
                                                                        <label class="col-md-7 css-label radGroup2" id="bbb">
                                                                            <input id="input-radio-12"  class="css-checkbox" type="radio" name="gender" value="female" />
                                                                            Female <span></span> </label>
                                                                    </fieldset>
                                                                    <div class="skin skin-square">
                                                                        <fieldset class="mr-5 d-inline-block">
                                                                        </fieldset>
                                                                        <fieldset class="d-inline-block">
                                                                        </fieldset >
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <label class="inline-block" for="sel1">Age</label>
                                                                </div>
                                                                <div class="col-md-9">
                                                                    <div class="form-group mt-1">
                                                                        <div class="double-slider">
                                                                            <input type="range" name="range_from" class="from" value="{{$diff}}" min="{{$diff}}" max="99" data-prev-value="{{$diff}}">
                                                                            <div class="progressbar_from"></div>
                                                                            <input type="range" name="range_to" class="to" value="99" min="0" max="99" data-prev-value="99">
                                                                            <div class="progressbar_to"></div>
                                                                            <span class="value-output from">{{$diff}}</span> <span class="value-output to">99</span> </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="card box-shadow-0 border-dark">
                                    <div class="card-header card-head-inverse bg-dark">
                                        <h4 class="card-title text-white">Specify Content</h4>
                                    </div>
                                    <div class="card-content collapse show">
                                        <div class="card-body">
                                            <fieldset class="form-group">
                                                <label class="inline-block" for="sel1">Title</label>
                                                <input type="text" name="title" class="form-control" id="basicInput" required>
                                                <br>
                                                <label class="inline-block" for="sel1">Message</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" name="message" placeholder="Message Body" rows="3" required></textarea>
                                            </fieldset>
                                            <fieldset class="row abc">
                                                <label class="col-md-3">
                                                    <input id="rdb1" type="radio" name="send" value="1" data-id="1" class="css-checkbox" checked />
                                                    Send Now<span></span></label>
                                                <label class="col-md-9 css-label radGroup2" id="bbb">
                                                    <input id="rdb2"  class="css-checkbox" type="radio" name="send" data-id="2" value="2" />
                                                    Schedule <span></span>
                                                    <div id="blk-2" class="datefield"> <span class="badge badge-square">
                                                    <input type="date" name="scheduleat" class="form-control" id="dateTime"/>
                                                    <input class="form-control mt-1" type="time" value='now' id="time" name="appt">
                                                    </span>
                                                    </div>
                                                </label>
                                            </fieldset>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions float-right mb-2 mt-0 py-0">
                            <button type="submit" class="btn btn-social btn-dark btn-dark text-center pr-1"> <span class="la la-check font-medium-3"></span> Create </button>
                        </div>
                    </section>
                </form>
            </div>
        </div>
    </div>
@endsection
