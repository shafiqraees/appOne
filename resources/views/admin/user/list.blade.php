@extends('admin.layouts.main')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Users</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item active">Users </li>
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
                                    <form name="search" action="{{route('alluser')}}"method="get">
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
                                    <section id="basic-form-layouts">
                                        <div class="row match-height">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-content collapse show">
                                                        <div class="card-dashboard filter_hide">
                                                            <table class="table table-striped table-bordered zero-configuration">
                                                                <thead>
                                                                <tr>
                                                                    <th>Id</th>
                                                                    <th>Name</th>
                                                                    <th>Email </th>
                                                                    <th>Buisness</th>
                                                                    <th>Created at</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @if(!empty($data))
                                                                    @foreach($data as $row)
                                                                        <tr>
                                                                            <td>{{$row->id}} </td>
                                                                            <td>{{$row->name}} </td>
                                                                            <td>{{$row->email}} </td>
                                                                            <td>{{$row->profiles_count}} </td>
                                                                            <td>{{date('d M Y',strtotime($row->created_at))}}</td>
                                                                            <td>
                                                                                <a href="{{route('selected.userdetail',$row->id)}}" class="btn btn-icon bg-dark white" data-toggle="tooltip" data-placement="top" title="" data-original-title="View User detail"><i class="ft-user"></i></a>
                                                                            </td>
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
