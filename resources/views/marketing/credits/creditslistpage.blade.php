@extends('marketing.layouts.marketer')
@section('content')
    <div class="app-content content list_custom_setting5">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Buy Credits</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a> </li>
                                <li class="breadcrumb-item active">Buy Credits</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <section id="user-profile-cards" class="row mt-2">
                    @php
                        $i=1;
                    @endphp
                    @foreach($packages as $package)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="badge badge-dark badge-square">Package {{ $i++ }}</div>
                                    <h2 class="pt-1">{{$package->name}}</h2>
                                    <h4>Credits: {{$package->credits}}</h4>
                                    <h1 class="text-muted"><span class="badge border-success  border-success  success  badge-square badge-border">{{$package->price}} Rands</span></h1>
                                </div>
                                <a href="{{route('selected.package',$package->id)}}" class="btn btn-social btn-dark d-block  text-center btn-square"> <span class="la la-shopping-cart font-medium-3"></span> Buy Now</a> </div>
                        </div>
                    @endforeach
                </section>
            </div>
        </div>
    </div>
@endsection
