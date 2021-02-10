@extends('admin.layouts.main')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Advertise with us</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item active">Advertise with us </li>
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
                <form class="form-horizontal" id="formsss" method="post" action="{{route('adsave')}}" name="specifycontent" enctype="multipart/form-data">
                    @csrf
                    <section id="card-bordered-options">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="card box-shadow-0 border-dark">
                                    <div class="card-header card-head-inverse bg-dark">
                                        <h4 class="card-title text-white">Advertise with us</h4>
                                    </div>
                                    <div class="card-content collapse show">
                                        <div class="card-body">
                                            <fieldset class="form-group row">
                                                <div class="col-md-12">
                                                    <label class="inline-block" for="sel1">File </label>
                                                    <input type="file" name="image" class="form-control"  required accept="video/mp4,video/x-m4v,video/*">
                                                    <input type="hidden" name="id" value="{{$data->id}}">
                                                </div>
                                            </fieldset>
                                            <fieldset class="form-group row">
                                                <div class="col-md-3">
                                                    <label class="inline-block" for="sel1">Video </label>
                                                    <div class="embed-responsive embed-responsive-16by9">
                                                        <iframe src="https://player.vimeo.com/video/{{$data->image}}" class="embed-responsive-item" width="100%" height="" frameborder="0" title="{video_title}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <div class="form-actions float-right mt-0 pt-0 buttonbordertop">
                                                <button type="submit" class="btn btn-social btn-dark btn-dark text-center  pr-1"> <span class="la la-check font-medium-3"></span> Create </button>
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
