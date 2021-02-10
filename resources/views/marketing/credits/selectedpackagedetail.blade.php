@extends('marketing.layouts.marketer')
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Buy Credits Detail</h3>
          <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a> </li>
                <li class="breadcrumb-item"><a href="{{route('buyredits')}}">Buy Credit</a> </li>
                <li class="breadcrumb-item active">Buy Credits Detail </li>
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
                <ul class="list-group list-group-flush">
                  <li class="list-group-item"> <span class="badge badge-default badge-pill bg-dark float-right badge-md badge-square">{{$package->name}}</span> Package </li>
                  <li class="list-group-item"> <span class="badge badge-default badge-pill bg-dark float-right badge-md badge-square">{{$package->price}} Rands</span> Amount </li>
                  <li class="list-group-item"> <span class="badge badge-default badge-pill bg-dark float-right badge-md badge-square">{{$customerAmount- $package->price}} Rands</span> Fee </li>
                  <li class="list-group-item"> <span class="badge badge-default badge-pill bg-dark float-right badge-md badge-square">{{$customerAmount}} Rands</span> Total </li>
                 {{--  <form action="https://www.payfast.co.za/eng/process" method="POST"> --}}
  <form action="https://sandbox.payfast.co.za/eng/process" method="POST" class="mb-0">
 <input type="hidden" name="merchant_id"  value="{{$data['merchant_id']}}">
  <input type="hidden" name="merchant_key" value="{{$data['merchant_key']}}">
  <input type="hidden" name="return_url"   value="{{$data['return_url']}}">
 <input type="hidden" name="cancel_url"    value="{{$data['cancel_url']}}">
 <input type="hidden" name="notify_url"    value="{{$data['notify_url']}}">
 <input type="hidden" name="name_first"    value="{{$data['name_first']}}">
 <input type="hidden" name="email_address" value="{{$data['email_address']}}">
 <input type="hidden" name="m_payment_id"  value="{{$data['m_payment_id']}}">
 <input type="hidden" name="amount"        value="{{$data['amount']}}">
 <input type="hidden" name="item_name"     value="{{$data['item_name']}}">
 <input type="hidden" name="item_description" value="{{$data['item_description']}}">
 <input type="hidden" name="custom_int1"    value="{{$data['custom_int1']}}">
 <input type="hidden" name="custom_int2"    value="{{$data['custom_int2']}}">
 <input type="hidden" name="custom_int3"    value="{{$data['custom_int3']}}">
 <input type="hidden" name="custom_int5"    value="{{$data['custom_int5']}}">
 <input type="hidden" name="custom_str1"    value="{{$data['custom_str1']}}">
 <input type="hidden" name="custom_str2"    value="{{$data['custom_str2']}}">
 {{-- <input type="hidden" name="payment_method"  value="cc"> --}}
 <input type="hidden" name="signature"         value="{{$data['signature']}}">
<button type="submit" class="btn btn-dark btn-block d-inline-block btn-square btn-social text-center"><span class="la la-credit-card font-medium-3"></span>Pay Now With Payfast</button>
                  </form>
                </ul>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
@endsection
