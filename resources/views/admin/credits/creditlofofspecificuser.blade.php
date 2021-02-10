@extends('admin.layouts.main')
@section('content')
    <link rel="stylesheet" type="text/css" href="{{asset('public/app-assets/css/pages/users.css')}}">
    <div class="app-content content list_custom_setting5">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Credit Logs Detail</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item"><a href="{{route('allcreditlogs')}}">Credit Logs</a> </li>
                                <li class="breadcrumb-item active">Credit Logs Detail</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="user-profile-cards" class="row">
                    <div class="col-xl-3 col-md-3 col-12">
                        <div class="card border-teal border-lighten-2">
                            <div class="text-center">
                                <div class="card-body"> <img src="{{Storage::disk('s3')->exists('md/'.$userDetail->profile_photo_path) ? Storage::disk('s3')->url('md/'.$userDetail->profile_photo_path) : Storage::disk('s3')->url('default.png')}}" class="rounded-circle  height-150"
                                                             alt="Card image">
                                    <h4 class="card-title mt-1">{{ $userDetail->name}}</h4>
                                    <h6 class="card-subtitle text-muted">User ID: {{ $userDetail->id}}</h6>
                                    <h6 class="text-muted">No of Business: {{ isset($userBuiseness->profiles_count) ? $userBuiseness->profiles_count : 0}}</h6>
                                    <a href="{{route('selected.userdetail',$userDetail->id)}}" class="btn btn-social btn-dark mt-1 btn-dark text-center mt-1 pr-1"> <span class="ft-user font-medium-3"></span> View Profile</a> </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-xl-9 col-md-9 col-12">
                        <div class="content-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header current-credit-div pb-0">
                                            <h4 class="card-title d-inline">Log of Transactions</h4>
                                            <div id="mySidenav" class="sidenav card-title white current-credit bg-success bg-darken-1 white credittopsetting">
                                                <h4 class="credits_logs">{{ isset($cureent_credits) ? $cureent_credits->credits - $cureent_credits->add_impression_count : 0}} <br>
                                                    Current Credits</h4>
                                            </div>
                                        </div>
                                        <div class="card-content collapse show">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead class="bg-dark white">
                                                        <tr>
                                                            <th>Id </th>
                                                            <th>Transacton ID </th>
                                                            <th>Date</th>
                                                            <th>Package</th>
                                                            <th>Credits</th>
                                                            <th>Amount</th>
<!--                                                            <th>Action</th>-->
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($userTransactions as $row)
                                                            <tr>
                                                                <td>{{$row->id}}</td>
                                                                <td>{{$row->transaction_id}}</td>
                                                                <td>{{date('d M , Y h:i A',strtotime($row->created_at))}}</td>
                                                                <td>{{$row->package_name}}</td>
                                                                <td>{{$row->credits}}</td>
                                                                <td>R{{($row->amount) + ($row->fee)}}</td>
<!--                                                                <td>
                                                                    <a href="#" class="btn btn-icon btn-dark"
                                                                       data-toggle="modal" data-controls-modal="your_div_id" data-backdrop="static" data-keyboard="false" data-target="#log_transactions{{ $row->transaction_id}}"><i class="la la-eye"></i></a>
                                                                </td>-->
                                                            </tr>
                                                            <div class="modal fade text-left" id="log_transactions{{ $row->transaction_id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4"   aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title" id="myModalLabel4">Log of Transactions</h4>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                                                        </div>
                                                                        <div class="modal-body px-0 py-0">
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <ul class="list-group list-group-flush">
                                                                                        <li class="list-group-item"> <span class="badge-default badge-pill float-right">{{$row->transaction_id}}</span> <b>ID:</b> </li>
                                                                                        <li class="list-group-item"> <span class=" badge-default badge-pill  float-right">{{date('d M , Y h:i A',strtotime($row->created_at))}}</span> <b>Date</b> </li>

                                                                                    </ul></div>
                                                                                <div class="col-md-6">
                                                                                    <ul class="list-group list-group-flush">
                                                                                        <li class="list-group-item"> <span class=" badge-default badge-pill float-right">{{$row->package_name}}</span> <b>Package: </b></li>
                                                                                        <li class="list-group-item"> <span class=" badge-default badge-pill float-right">{{$row->credits}}</span> <b>Credits: </b></li>
                                                                                    </ul></div>
                                                                            </div>
                                                                            <ul class="list-group list-group-flush">


                                                                                <li class="list-group-item"> <span class="badge badge-default badge-pill bg-dark float-right">R{{($row->amount) + ($row->fee)}}</span><b> Amount: </b></li>
                                                                            </ul>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                        @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section id="user-profile-cards" class="row">
                    <div class="col-xl-3 col-md-3 col-12"></div>
                    <div class="col-xl-9 col-md-9 col-12">
                        <div class="content-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header current-credit-div pb-0">
                                            <h4 class="card-title d-inline">Marketing Campaigns</h4>
                                        </div>
                                        <div class="card-content collapse show">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead class="bg-dark white">
                                                        <tr>
                                                            <th>Id </th>
                                                            <th>Title </th>
                                                            <th>Created</th>
                                                            <th>Spent</th>
                                                            <th>Status</th>
<!--                                                            <th>Action</th>-->
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @php
                                                            $i=0;
                                                        @endphp
                                                        @foreach($marketing_compaign as $compeign)
                                                            <tr>
                                                                <td>{{$compeign->id}}</td>
                                                                <td>{{$compeign->name}}</td>
                                                                <td>{{date('d M , Y h:i A',strtotime($compeign->created_at))}}</td>
                                                                <td>{{$compeign->add_impressions_count}}</td>
                                                                <td>

                                                                    <span class="badge badge-default badge-success">{{$compeign->status}}</span>
                                                                </td>
<!--                                                                <td>
                                                                    <a href="#" class="btn btn-icon btn-dark"
                                                                       data-toggle="modal" data-controls-modal="your_div_id" data-backdrop="static" data-keyboard="false" data-target="#log_transactions{{ $i}}"><i class="la la-eye"></i></a>
                                                                </td>-->
                                                            </tr>
                                                            <div class="modal fade text-left" id="log_transactions{{ $i}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel4"   aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h4 class="modal-title" id="myModalLabel4">Marketing Campaigns</h4>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                                                        </div>
                                                                        <div class="modal-body px-0 py-0">
                                                                            <div class="row">
                                                                                <div class="col-md-7">
                                                                                    <ul class="list-group list-group-flush">
                                                                                        <li class="list-group-item"> <span class="badge-default badge-pill float-right">{{$compeign->name}}</span> <b>Title:</b> </li>
                                                                                        <li class="list-group-item"> <span class=" badge-default badge-pill  float-right">{{date('d M , Y H:i A',strtotime($compeign->created_at))}}</span> <b>Create at</b> </li>

                                                                                    </ul></div>
                                                                                <div class="col-md-5">
                                                                                    <ul class="list-group list-group-flush">
                                                                                        <li class="list-group-item"> <span class=" badge-default badge-pill float-right">{{$compeign->add_impressions_count}}</span> <b>Spent: </b></li>
                                                                                        <li class="list-group-item"> <span class=" badge-default badge-pill float-right">{{$compeign->status}}</span> <b>Status: </b></li>
                                                                                    </ul></div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Close</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @php
                                                                $i++;
                                                            @endphp
                                                        @endforeach
                                                        </tbody>
                                                    </table>
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
    </div>
@endsection
