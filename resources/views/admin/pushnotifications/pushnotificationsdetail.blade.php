@extends('admin.layouts.main')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Push Notifications View</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item"><a href="{{route('allpushnotifications')}}">Push Notifications</a> </li>
                                <li class="breadcrumb-item active">Push Notifications View </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
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
                <section id="card-bordered-options">
                    <div class="row">
                        @if($data->status=="pending")
                            <div class="col-md-12 col-sm-12">
                                <div class="form-actions mb-1 float-right"> <a href="{{route('notification.status',$data->id)}}" class="btn btn-social btn-dark btn-dark text-center pr-1"> <span class="la la-close font-medium-3"></span> Cancel Notification</a> </div>
                            </div>
                        @endif
                        <div class="col-md-6 col-sm-12">
                            <div class="card box-shadow-0 border-blue-grey">
                                <div class="card-header card-head-inverse bg-dark">
                                    <h4 class="card-title text-white">Select Audience </h4>
                                </div>
                                <div class="card-content collapse show">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"> <span class="badge badge-default badge-pill bg-dark float-right">{{ucfirst($data->gender)}}</span> Gender </li>
                                        <li class="list-group-item"><span class="badge badge-default badge-pill bg-dark float-right"> {{$data->age_from}} - {{$data->age_to}} </span> Age </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="card box-shadow-0 border-blue-grey">
                                <div class="card-header card-head-inverse bg-dark">
                                    <h4 class="card-title text-white">Specify Content</h4>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <fieldset class="form-group mb-1">
                                            <label class="inline-block" for="sel1">Title</label>

                                            <input type="text" value="{{$data->titile}}" class="form-control" id="basicInput" placeholder="tile" readonly>
                                            <br>
                                            @if($data->status =="sent")
                                            <label class="inline-block" for="sel1">Sent</label>
                                            <input type="text" value="{{date('d M Y h:i A',strtotime($data->created_at))}}" class="form-control" id="basicInput" placeholder="tile" readonly>
                                            @elseif($data->status =="pending")
                                                <label class="inline-block" for="sel1">Scheduled</label>
                                                <input type="text" value="{{date('d M Y',strtotime($data->schedule_date_time))}} {{date('h:i A',strtotime($data->time))}}" class="form-control" id="basicInput" placeholder="tile" readonly>
                                            @endif
                                            <br>
                                            <label class="inline-block" for="sel1">Message</label>

                                            <textarea class="form-control" id="exampleFormControlTextarea1" placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s."  rows="3" readonly>{{$data->message}}</textarea>
                                        </fieldset>
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item px-0 py-0">
                                                <label class="inline-block" for="sel1">Created at</label>
                                                <div class="float-right"> <span class="badge badge-default badge-pill bg-dark">{{date('d M Y h:i A',strtotime($data->created_at))}}</span></div>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="content-body"> </div>
                    <div class="form-actions float-right"> <a href="{{route('allpushnotifications')}}" class="btn btn-social btn-dark btn-dark btn-glow text-center mt-1 mt-1 mb-1 pr-1"> <span class="ft-arrow-left font-medium-3"></span> Go Back</a> </div>
                </section>
            </div>
        </div>
    </div>
@endsection
