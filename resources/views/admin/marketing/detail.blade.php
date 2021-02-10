@extends('admin.layouts.main')
@section('content')
    <div class="app-content content list_custom_setting5">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Marketing Detail</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item"><a href="{{route('all.marketing')}}">Marketing</a> </li>
                                <li class="breadcrumb-item active">Marketing Detail</li>
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
                <section id="user-profile-cards" class="row">
                    <div class="col-xl-3 col-md-3 col-12">
                        <div class="card border-amber border-lighten-2">
                            <div class="text-center">
                                <div class="card-body"> <img  class="img-fluid rounded-circle imgheight" height="220px" src="{{Storage::disk('s3')->exists($data->user->profile_photo_path) ? Storage::disk('s3')->url($data->user->profile_photo_path) : url(Storage::disk('s3')->url('default.png'))}}" class="rounded-circle  height-150"
                                                             alt="Card image">
                                    <h4 class="card-title mt-1">{{$data->user->name}}</h4>
                                    <h6 class="card-subtitle text-muted">{{date('d M,Y',strtotime($data->user->created_at))}}</h6>
                                    <a href="{{route('selected.userdetail',$data->user->id)}}" class="btn btn-social btn-block btn-dark btn-dark text-center mt-1"><span class="ft-user font-medium-3"></span> View Profile</a>
                                    <a href="#" class="btn btn-social btn-block btn-dark btn-dark text-center mt-1"><span class="la la-eye font-medium-3"></span> View Analytics</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-md-9 col-12">
                        <div class="content-body">
                            <section id="card-heading-color-options">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="card">
                                            <div class="card-header card-head-inverse bg-dark">
                                                <h4 class="card-title text-white">Advertisment No: {{$data->add_number}}</h4>
                                            </div>
                                            <div class="card mb-0">
                                                <div class="card-header">
                                                    <div class="form-group row mb-1">
                                                        <div class="col-md-6 label-control" for="eventRegInput1"> <b>Credits Spent: </b>{{$data->totalcount}}</div>
                                                        <div class="col-md-6 label-control" for="eventRegInput1"> <b>Amount: </b>{{$data->user->credits}} Rands</div>
                                                        <div class="col-md-6 label-control pt-1" for="eventRegInput1"> <b>Status: </b>{{$data->status}}</div>
                                                        {{--                                                        <div class="col-md-6 label-control pt-1" for="eventRegInput1"> <b>Fee: </b>20 Rands</div>--}}

                                                        <div class="col-md-12 label-control pt-1" for="eventRegInput1"> <b>Impressions Created: </b>{{$data->totalcount}}</div>
                                                        <div class="col-md-7 label-control pt-1 pr-0" for="eventRegInput1"> <b>Total: </b><span class="badge badge-default badge-pill bg-dark float-right">{{$data->user->credits}} Rands</span></div>
                                                        <div class="col-md-12 mt-2">
                                                            <div class="row d-flex">

                                                                <div class="col-md-3"></div>

                                                                <div class="col-md-3">
                                                                    @if($data->status == "visible")
                                                                        <form class="d-inline-block float-right" method="post" action="{{route('marketingstatus.update',$data->id)}}" name="statusform" id="statusform">
                                                                            @csrf
                                                                            <input name="status" type="hidden" value="pause">

                                                                                <button type="submit" class="btn pr-1 btn-warning d-block white btn-social text-center pr-1">
                                                                                    <span class="ft-stop-circle font-medium-3"></span> Pause Ads </button>

                                                                        </form>
                                                                    @elseif($data->status == "pause")
                                                                        <form class="d-inline-block float-right" method="post" action="{{route('marketingstatus.update',$data->id)}}" name="statusform" id="statusform">
                                                                            @csrf
                                                                            <input name="status" type="hidden" value="visible">

                                                                                <button type="submit" class="btn pr-1 btn-warning d-block white btn-social text-center">
                                                                                    <span class="ft-stop-circle font-medium-3"></span> Resume Ad </button>

                                                                        </form>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-3 marginicon">
                                                                    <form class="d-inline-block float-right" method="post" action="{{route('marketingstatus.update',$data->id)}}" name="statusform" id="statusform">
                                                                        @csrf
                                                                        <input name="status" type="hidden" value="visible">

                                                                            <button type="submit" class="btn btn-danger d-block white btn-social text-center pr-1">
                                                                                <span class="la la-times font-medium-3"></span> Resume Ad </button>

                                                                    </form>
                                                                </div>
                                                                <div class="col-md-3 marginicon">
                                                                    <div class="form-actions"> <a href="{{route('all.marketing')}}" class="btn btn-social btn-dark btn-dark text-center pr-1 float-right"> <span class="ft-arrow-left font-medium-3"></span> Go Back</a> </div>
                                                                </div>
                                                            </div>
                                                        </div>



                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
