<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('marketing.layouts.head')
<body class="vertical-layout vertical-menu-modern 2-columns menu-expanded fixed-navbar"
      data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
@include('marketing.layouts.header')
@include('marketing.layouts.aside_bar')
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Transactions Marketer Detail</h3>
          <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a> </li>
                <li class="breadcrumb-item"><a href="{{ route('transactions') }}">Transactions</a> </li>
                <li class="breadcrumb-item active">Transactions Marketer Detail </li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="content-body">
        <section id="card-heading-color-options">
          <div class="row">
            <div class="col-md-6 offset-md-3 col-sm-12">
              <div class="card">
                <div class="card-header card-head-inverse bg-dark">
                  <h4 class="card-title text-white">Transaction Details</h4>
                </div>
                <div class="card mb-0">
                  <div class="card-header">
                    <div class="form-group row mb-1">
                      <label class="col-md-3 label-control" for="eventRegInput1">Transaction ID</label>
                      <div class="col-md-9">
                        <input type="text" id="eventRegInput1" class="form-control" value="{{$transactions->transaction_id}}" readonly>
                      </div>
                    </div>
                    <div class="form-group row mb-1">
                      <label class="col-md-3 label-control" for="eventRegInput1">Transaction Date</label>
                      <div class="col-md-9">
                        <input type="text" id="eventRegInput1" class="form-control" value="{{date('d M, Y',strtotime($transactions->created_at))}}"  readonly>
                      </div>
                    </div>
                    <div class="form-group row mb-0">
                      <label class="col-md-3 label-control" for="eventRegInput1">Transaction Time</label>
                      <div class="col-md-9">
                        <input type="text" id="eventRegInput1" class="form-control" value="{{date('h:i:s A',strtotime($transactions->created_at))}}"  readonly>
                      </div>
                    </div>
                  </div>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item"> <span class="badge badge-default badge-pill bg-dark float-right badge-md badge-square">{{$transactions->amount}} Rands</span> Amount </li>
                  <li class="list-group-item"> <span class="badge badge-default badge-pill bg-dark float-right badge-md badge-square">{{$transactions->fee}} Rands</span> Fee </li>
                  <li class="list-group-item"> <span class="badge badge-default badge-pill bg-dark float-right badge-md badge-square">{{($transactions->fee)+($transactions->amount)}} Rands</span> Total </li>
                  <li class="list-group-item"> <span class="badge badge-default badge-pill bg-dark float-right badge-md badge-square">{{$transactions->package_name}}</span> Package Name</li>
                  <li class="list-group-item"> <span class="badge badge-default badge-pill bg-dark float-right badge-md badge-square" >{{$transactions->credits}}</span> Credits </li>
                  <a href="{{ route('transactions') }}" class="btn btn-dark d-inline-block btn-square btn-social text-center"> <span class="ft-arrow-left font-medium-3"></span> Go Back </a>
                </ul>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>

  </div>

  </div>
@show
@include('marketing.layouts.footer')
@include('marketing.layouts.footer_script')
</body>
</html>
