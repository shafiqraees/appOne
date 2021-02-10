@extends('admin.layouts.main')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Categories</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item active">Categories </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
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
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-3 col-md-6">
                                            <div class="form-actions"> <a href="{{ route('cat_create')}}" class="btn btn-social btn-dark btn-dark text-center mt-1 pr-1"> <span class="la la-plus font-medium-3"></span> Add New Category</a> </div>
                                        </div>
                                    </div>
                                    <br>
                                    <section id="basic-form-layouts">
                                        <div class="row match-height">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-content collapse show">
                                                        <div class="card-dashboard filter_hide">
                                                            <table class="table table-striped table-bordered zero-configuration">
                                                                <thead>
                                                                <tr>
                                                                    <th>Title</th>
                                                                    <th>Status </th>
                                                                    <th>Created Date</th>
                                                                    <th>Intrested user</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if(!empty($data))
                                                                    @foreach($data as $row)
                                                                        <tr>
                                                                            <td>{{$row->name}} </td>
                                                                            <td>
                                                                                @if($row->status=="publish")
                                                                                    <span class="badge badge-default badge-success">Publish</span>
                                                                                @elseif($row->status=="unPublish")
                                                                                    <span class="badge badge-default badge-warning">Unpublish </span>
                                                                                @endif
                                                                            </td>
                                                                            <td>{{date('d M Y',strtotime($row->created_at))}}</td>
                                                                            <td>{{$row->count}}</td>
                                                                        </tr>
                                                                    @endforeach
                                                                @endif
                                                                </tbody>
                                                            </table>
                                                           <div class="mt-3" id="xyz"> {{ $data->links() }} </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
