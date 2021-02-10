@extends('admin.layouts.main')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Transactions</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item active">Transactions </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <form name="search" action="{{route('alluserstransactions')}}"method="get">
                                        <div class="row">
                                            <div class="col-md-5 mb-1">
                                                <fieldset>
                                                    <div class="input-group">
                                                        <input type="text" name="keyword" value="{{old('keyword', request('keyword'))}}" class="form-control heightinputs" placeholder="Search" aria-describedby="button-addon4">
                                                        <div class="input-group-append">
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-5 col-md-5 ">
                                                <div class="form-group">
                                                    <fieldset class="form-group">
                                                        <input class="form-control heightinputs" name="date" id="datefield" value="{{old('date', request('date'))}}" type="date" ></input>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-2">
                                                <button type="cancel" class="btn btn-dark heightinputs refresh_btn"> <i class="fonticon-classname"></i> Refresh </button>
                                                <button type="submit" class="btn btn-dark heightinputs"> <i class="fonticon-classname"></i> Filter </button>
                                            </div>

                                        </div>
                                    </form>
                                    <div class="table-responsive mt-1">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Id </th>
                                                <th>User </th>
                                                <th>Transaction ID</th>
                                                <th> Date/Time</th>
                                                <th>Package</th>
                                                <th>Total </th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($allTransactions as $row)
                                                <tr>
                                                    <td>{{$row->id}}</td>
                                                    <td>{{$row->user->name}}</td>
                                                    <td>{{$row->transaction_id}}</td>
                                                    <td>{{date('d M,Y',strtotime($row->created_at))}}<br>
                                                        {{date('h:i A',strtotime($row->created_at))}}</td>
                                                    <td>{{$row->package_name}}</td>
                                                    <td>R {{($row->amount)+($row->fee)}}</td>
                                                    <td>
                                                        <a href="{{route('selected.transactiondetail',$row->id)}}" class="btn btn-icon bg-dark white" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Transaction Detail"><i class="la la-eye"></i></a>
                                                        <a href="{{route('selected.userdetail',$row->user_id)}}" class="btn btn-icon bg-dark white marginicon" data-toggle="tooltip" data-placement="top" title="" data-original-title="View User Profile"><i class="ft-user"></i></a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        <div class="mt-3" id="xyz"> {{ $allTransactions->links() }} </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection



