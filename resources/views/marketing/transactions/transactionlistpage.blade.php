@extends('marketing.layouts.marketer')
@section('content')
<div class="app-content content list_custom_setting5">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Transactions</h3>
          <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a> </li>
                <li class="breadcrumb-item active">Transactions </li>
              </ol>
            </div>
          </div>
        </div>
      </div>
      <div class="content-body">
        <section id="basic-form-layouts">
          <div class="row match-height">
            <div class="col-md-12">
              <div class="card">
                <div class="card-content collapse show">
                  <div class="card-body card-dashboard filter_hide">
                      <form name="search" action="{{route('transactions')}}"method="get">
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
                                          <input class="form-control heightinputs" value="{{old('date', request('date'))}}" name="date" id="datefield" type="date" ></input>
                                      </fieldset>
                                  </div>
                              </div>
                              <div class="col-xl-2 col-md-2">
                                  <button type="cancel" class="btn btn-dark heightinputs refresh_btn"> <i class="fonticon-classname"></i> Refresh </button>
                                  <button type="submit" class="btn btn-dark heightinputs"> <i class="fonticon-classname"></i> Filter </button>
                              </div>

                          </div>
                      </form>
                    <table class="table table-striped table-bordered zero-configuration">
                      <thead>
                        <tr>
                          <th>Date</th>
                          <th>Time</th>
                          <th>Transaction ID</th>
                          <th>Amount</th>
                          <th>Package</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                          <td>{{date('d M, Y',strtotime($transaction->created_at))}}</td>
                          <td>{{date('h:i:s A',strtotime($transaction->created_at))}}</td>
                          <td>{{ $transaction->transaction_id }}</td>
                          <td>R{{ ($transaction->amount) + ($transaction->fee) }}</td>
                          <td>{{ $transaction->package_name }}</td>
                          <td><a href="{{route('transaction-detail',$transaction->id)}}" class="btn btn-icon bg-dark white mr-1" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"><i class="la la-eye"></i></a></td>
                        </tr>
                        @endforeach
                     </tbody>
                    </table>
                      <div class="mt-3" id="xyz"> {{ $transactions->links() }} </div>
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
