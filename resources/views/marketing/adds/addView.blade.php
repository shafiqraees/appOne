@extends('marketing.layouts.marketer')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Advertisment View</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item"><a href="{{route('marketer.marketing')}}">Marketing </a> </li>
                                <li class="breadcrumb-item active">Advertisment View </li>
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
                <section id="card-heading-color-options">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="card">
                                <div class="card-header card-head-inverse bg-dark pb-0">
                                    <h4 class="card-title text-white d-inline-block pt-2 mb-1">Advertisement  No: {{$data->add_number}}</h4>

                                    <div class="float-right">
                                        @if($data->status == "visible")
                                            <form class="d-inline-block mt-1" method="post" action="{{route('addstatus.update',$data->id)}}" name="statusform" id="statusform">
                                                @csrf
                                                <input name="status" type="hidden" value="pause">
                                                <button type="submit" class="btn btn-warning white btn-social text-center pr-1 mb-1"><span class="ft-stop-circle font-medium-3"></span> Pause Ad </button>
                                            </form>
                                        @elseif($data->status == "pause")
                                            <form class="d-inline-block  mt-1" method="post" action="{{route('addstatus.update',$data->id)}}" name="statusform" id="statusform">
                                                @csrf
                                                <input name="status" type="hidden" value="visible">
                                                <button type="submit" class="btn btn-warning white btn-social text-center pr-1 mb-1"><span class="ft-stop-circle font-medium-3"></span> Resume Ad </button>
                                            </form>
                                        @endif
                                            <form class="d-inline-block" method="post" action="{{route('addstatus.update',$data->id)}}" name="statusform" id="statusform">
                                                @csrf
                                                <input name="status" type="hidden" value="cancell">
                                                <button type="submit" class="btn btn-danger  white btn-social text-center pr-1  mb-1"><span class="la la-times font-medium-3"></span> Cancel Ad </button>
                                            </form>
                                    </div>
                                </div>
                                <div class="card mb-0">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <div class="form-group row mb-1">
                                                    <label class="col-md-3 label-control">Name</label>
                                                    <div class="col-md-9">
                                                        <input type="text" id="eventRegInput1" value="{{$data->name}}" class="form-control" placeholder="John Mark" name="fullname" readonly="">
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-1">
                                                    <label class="col-md-3 label-control" >Start Date</label>
                                                    <div class="col-md-9">
                                                        <input type="text" id="eventRegInput1" value="{{$data->add_date ? date("j F Y", strtotime($data->add_date)) : ''}}" class="form-control" placeholder="15 April 2019" name="fullname" readonly="">
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-1">
                                                    <label class="col-md-3 label-control" >Video</label>
                                                    <div class="col-md-9">
                                                        <div class="embed-responsive embed-responsive-16by9">
                                                            <iframe src="https://player.vimeo.com/video/{{$data->video}}" class="embed-responsive-item" width="100%" height="" frameborder="0" title="{video_title}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-1">
                                                    <label class="col-md-3 label-control" >Description</label>
                                                    <div class="col-md-9">
                                                        <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s." rows="3" readonly="">{{$data->description ? $data->description : ''}}</textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-1">
                                                    <label class="col-md-3 label-control" >Banner</label>
                                                    <div class="col-md-9"> <img width="100%" class="img-fluid d-block" src="{{Storage::disk('s3')->exists('lg/'.$data->banner) ? Storage::disk('s3')->url('lg/'.$data->banner) : Storage::disk('s3')->url('default.png')}}" alt="xyz"> </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row mb-1">
                                                    <label class="col-md-3 label-control" >Gender</label>
                                                    <div class="col-md-9"> <span class="badge badge-default badge-pill bg-dark float-right text-capitalize">{{$data->gender ? $data->gender : ''}}</span> </div>
                                                </div>
                                                <div class="form-group row mb-1">
                                                    <label class="col-md-3 label-control" >Location</label>
                                                    <div class="col-md-9">

                                                        <div id="map"></div>

                                                        <input type="text" id="eventRegInput1" value="{{$data->location}}" class="form-control" placeholder="John Mark" name="fullname" readonly="">

                                                        <input type="hidden" id="lat" name="lat" value="{{$data->latitude}}">
                                                        <input type="hidden" id="long" name="long" value="{{$data->longitude}}">
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-1">
                                                    <label class="col-md-4 label-control" >Impressions Frequency </label>
                                                    <div class="col-md-8"> <span class="badge badge-default badge-pill bg-dark float-right">@if($data->impressions == 1) Unique @else {{$data->impressions}} @endif</span> </div>
                                                </div>
                                                <div class="form-group row mb-1">
                                                    <label class="col-md-3 label-control" >Age (Years)</label>
                                                    <div class="col-md-9"> <span class="badge badge-default badge-pill bg-dark float-right">{{$data->age_from ? $data->age_from : 1}} - {{$data->age_to ? $data->age_to : ''}}</span> </div>
                                                </div>

                                                <div class="form-group row mb-1">
                                                    <label class="col-md-3 label-control" >Radius (KMs)</label>
                                                    <div class="col-md-9"> <span class="badge badge-default badge-pill bg-dark float-right">{{$data->radious ? $data->radious : ''}}</span> </div>
                                                </div>
                                                <div class="form-group row mb-1">
                                                    <label class="col-md-4 label-control">Allocate Funds (Rands)</label>
                                                    <div class="col-md-8"> <span class="badge badge-default badge-pill bg-dark float-right">{{$data->funds_to ? $data->funds_to : ''}}</span> </div>
                                                </div>
                                                <div class="form-group row mb-1">
                                                    @if(!empty($data->end_date))
                                                    <label class="col-md-4 label-control" >End Date</label>
                                                    @else
                                                        <label class="col-md-4 label-control" >End once budget ends</label>
                                                    @endif
                                                    <div class="col-md-8"> <span class="badge badge-default badge-pill bg-dark float-right">{{$data->end_date ? date('d M Y',strtotime($data->end_date)) : "true"}}</span> </div>
                                                </div>
                                                <div class="form-group row mb-1">
                                                    <label class="col-md-4 label-control" >Advertisement  Status</label>
                                                    <div class="col-md-8"> <span class="badge badge-default badge-pill bg-dark float-right text-capitalize">{{$data->status ? $data->status : ''}}</span> </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions float-right"> <a href="{{route('marketer.marketing')}}" class="btn btn-social btn-dark btn-dark text-center pr-1"> <span class="ft-arrow-left font-medium-3"></span> Go Back</a> </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection
