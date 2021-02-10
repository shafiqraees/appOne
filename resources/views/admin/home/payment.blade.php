@extends('admin.layouts.main')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Payments</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Settings</a> </li>
                                <li class="breadcrumb-item active">Payments </li>
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
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form class="form mb-0" id="form_id" name="payment" method="post" action="{{route('admin.payment.update')}}">
                                            @csrf
                                            <div class="form-body">
                                                <div class="row">
                                                    <div class="col-md-6 mt-1">
                                                        <label for="merchantKey">Merchant Key</label>
                                                        <div class="input-group paymentsetting">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text bg-dark border-dark white" id="basic-addon7 fonticon-container">
                                                              <div class="fonticon-wrap">
                                                                  <i class="la la-dollar"></i>
                                                              </div>
                                                            </div>
                                                            <input type="text" name="merchant_key"  id="merchantkey" value="{{$data->merchant_key}}" class="form-control heightinputs errormessage" aria-describedby="basic-addon7" placeholder="Enter Key">

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mt-1">
                                                        <label for="merchantId">Merchant ID</label>
                                                        <div class="input-group paymentsetting">
                                                            <div class="input-group-prepend"> <span class="input-group-text bg-dark border-dark white" id="basic-addon7 fonticon-container">
                                                                    <div class="fonticon-wrap"> <i class="la la-dollar"></i> </div></span>
                                                            </div>
                                                            <input type="number" name="merchant_id" min="1" id="merchantid" value="{{$data->merchant_id}}" class="form-control heightinputs errormessage" aria-describedby="basic-addon7" placeholder="Enter ID">

                                                            <input type="hidden" name="id" value="{{$data->id}}" class="form-control" aria-describedby="basic-addon7" placeholder="Merchant ID">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="float-right py-1">
                                                <button type="submit" class="btn btn-social btn-dark btn-dark text-center pr-1"> <span class="ft-edit font-medium-3"></span> Update</button>
                                            </div>
                                        </form>
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

