@extends('admin.layouts.main')
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Push Notifications</h3>
          <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Dashboard</a> </li>
                <li class="breadcrumb-item active">Push Notifications </li>
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
        @if (session()->has('error'))
            <div class="alert alert-danger">
                @if(is_array(session('error')))
                    <ul>
                        @foreach (session('error') as $message)
                            <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                @else
                    {{ session('error') }}
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
                      <div class="form-actions"> <a href="{{ route('createpushnotification')}}" class="btn btn-social btn-dark btn-dark text-center mt-1 pr-1"> <span class="la la-plus font-medium-3"></span> Add New Push Notifications</a> </div>
                    </div>
                  </div>
                  <br>
                  <section id="basic-form-layouts">
                    <div class="row match-height">
                      <div class="col-12">
                        <div class="card">
                          <div class="card-content collapse show">
                            <div class="card-dashboard filter_hide">
                              <table class="table table-striped table-bordered zero-configuration ">
                                <thead>
                                  <tr>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Status </th>
                                      <th>Created Date</th>
                                    <th>Action</th>
                                  </tr>
                                </thead>
                                <tbody>
                                @if(!empty($pushNotification))
                                  @foreach($pushNotification as $row)
                                  <tr>
                                    <td>{{$row->id}} </td>
                                    <td>{{$row->titile}} </td>
                                    <td>
                                      @if($row->status=="sent")
                                      <span class="badge badge-default badge-success">Sent</span>
                                        @elseif($row->status=="pending")
                                      <span class="badge badge-default badge-warning">Scheduled </span>
                                        @elseif($row->status=="cancelled")
                                            <span class="badge badge-default badge-danger">Cancelled </span>
                                      @endif
                                    </td>
                                      <td>{{date('d M Y h:i A',strtotime($row->created_at))}}</td>
                                    <td><a href="{{route('notification.detail',$row->id)}}" class="btn btn-icon bg-dark white" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"><i class="la la-eye"></i></a></td>
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
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
