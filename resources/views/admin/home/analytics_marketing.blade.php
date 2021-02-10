@extends('admin.layouts.main')
<style>
    .dataTables_filter {
        display: none;
    }
</style>
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
                                    <form name="search" action="{{route('marketing.compaign')}}"method="get">
                                        <div class="row">
                                            <div class="col-md-5 mb-1">
                                                <fieldset>
                                                    <select class="form-select form-control select2" id="compaign_users" data-url="{{route('user.compaign')}}" aria-label=" select example" name="users">
                                                        <option value=""> Select User </option>
                                                        @if($data)
                                                            @foreach($data as $rst)
                                                        <option value="{{$rst->id}}"> {{$rst->name}} </option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </fieldset>
                                            </div>
                                            <div class="col-xl-5 col-md-5 compaign">
                                                <div class="form-group">
                                                    <fieldset class="form-group">
                                                        <select class="form-select form-control select2" id="maketing_compaign" aria-label=" select example" name="compaign">
                                                        </select>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-xl-2 col-md-2">
                                                <a href="javascript:void(0)" type="cancel" class="btn btn-dark heightinputs nxt_button"> <i class="fonticon-classname"></i> next </a>
                                                <button type="submit" class="btn btn-dark heightinputs submit_button"> <i class="fonticon-classname"></i> Submit </button>
                                            </div>

                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


