@extends('admin.layouts.main')
@section('content')
    <div class="app-content content list_custom_setting5">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Transactions Details</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item"><a href="{{route('alluserstransactions')}}">Transactions</a> </li>
                                <li class="breadcrumb-item active">Transactions Details</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="user-profile-cards" class="row">
                    <div class="col-xl-3 col-md-3 col-12">
                        <div class="card border-amber border-lighten-2">
                            <div class="text-center">
                                <div class="card-body"> <img class="img-fluid rounded-circle imgheight" src="{{Storage::disk('s3')->exists('md/'.$selectedUserTransactions->user->profile_photo_path) ? Storage::disk('s3')->url('md/'.$selectedUserTransactions->user->profile_photo_path) : Storage::disk('s3')->url('default.png')}}" class="rounded-circle  height-150"
                                                             alt="Card image">
                                    <h4 class="card-title mt-1">{{$selectedUserTransactions->user->name}}</h4>
                                    <h6 class="card-subtitle text-muted">{{date('d M, Y h:i A',strtotime($selectedUserTransactions->user->created_at))}}</h6>
                                    <a href="{{route('selected.userdetail',$selectedUserTransactions->user_id)}}" class="btn btn-social btn-block btn-dark btn-dark text-center mt-1"> <span class="ft-user font-medium-3"></span> View Profile</a>
                                    <a href="{{route('selected.creditdetail',$selectedUserTransactions->user_id)}}" class="btn btn-social btn-block btn-dark btn-dark text-center"> <span class="la la-money font-medium-3"></span> View All Transactions</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-9 col-md-9 col-12">
                        <div class="content-body">

                                <div class="card">
                                    <div class="card-header card-head-inverse bg-dark">
                                        <h4 class="card-title text-white">Transactions Details</h4>
                                    </div>
                                    <div class="card mb-0">
                                        <div class="card-header">
                                            <div class="form-group row mb-0">
                                                <div class="col-md-6 label-control" for="eventRegInput1"><b>Transaction Date: </b>{{date('d M, Y',strtotime($selectedUserTransactions->created_at))}} at {{date('h:i A',strtotime($selectedUserTransactions->created_at))}}</div>
                                                <div class="col-md-6 label-control" for="eventRegInput1"><b>Package: </b>{{ $selectedUserTransactions->package_name}}</div>

                                                <div class="col-md-6 label-control pt-1" for="eventRegInput1"><b>Transaction ID: </b>{{ $selectedUserTransactions->transaction_id}}</div>
                                                <div class="col-md-6 label-control pt-1" for="eventRegInput1"><b>Credits: </b>{{ $selectedUserTransactions->credits}}</div>

                                                <div class="col-md-6 label-control pt-1" for="eventRegInput1"><b>Method: </b>Payfast</div>

                                                <div class="col-md-6 offset-md-6 label-control pt-1" for="eventRegInput1"><b>Amount: </b>R {{ $selectedUserTransactions->amount}}</div>
                                                <div class="col-md-6 offset-md-6 label-control pt-1" for="eventRegInput1"><b>Fee: </b>R{{ $selectedUserTransactions->fee}}</div>
                                                <div class="col-md-6 offset-md-6 label-control pt-1" for="eventRegInput1"> <b>Total: </b><span class="badge badge-default badge-pill bg-dark ">R{{ ($selectedUserTransactions->amount)+($selectedUserTransactions->fee)}}</span></div>
                                                <div class="col-md-12 form-actions "><a href="{{route('alluserstransactions')}}" class="btn btn-social btn-dark btn-dark text-center mt-1 pr-1 float-right"> <span class="ft-arrow-left font-medium-3"></span> Go Back</a>  </div>
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
@endsection
