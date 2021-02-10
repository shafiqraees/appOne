@extends('marketing.layouts.marketer')
@section('content')
    <div class="app-content content list_custom_setting5">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Marketing</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item active">Marketing </li>
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
                                    <div class="card-body card-dashboard filter_hide">
                                        <form name="search" action="{{route('marketer.marketing')}}"method="get">
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
                                        <div class="form-actions"> <a href="{{route('create.add')}}" class="btn btn-social btn-dark btn-dark text-center pr-1"> <span class="la la-check font-medium-3"></span> Create Advertisement</a> </div>
                                        <table class="table table-striped table-bordered zero-configuration">
                                            <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Created</th>
                                                <th>Impressions</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if(!empty($data))
                                                @foreach($data as $str)
                                                    <tr>
                                                        <td>{{$str->name}}</td>
                                                        <td>{{$str->created_at->diffForHumans()}}</td>
                                                        <td>{{{$str->totalcount}}}</td>
                                                        <td>@if(!empty($str->status) && $str->status === "visible")
                                                                <span class="badge badge-default badge-success">Visible</span>
                                                            @elseif(!empty($str->status) && $str->status === "pause")
                                                                <span class="badge badge-default badge-warning">Paused</span>
                                                            @else
                                                                <span class="badge badge-default badge-danger">Cancelled</span>
                                                            @endif
                                                        </td>
                                                        <td><a href="{{route('add.detail',$str->id)}}" class="btn btn-icon bg-dark white"><i class="la la-eye"></i></a></td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
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
