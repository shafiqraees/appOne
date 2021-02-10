@extends('admin.layouts.main')
@section('content')
<div class="app-content content list_custom_setting5">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Credit Logs</h3>
          <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Dashboard</a> </li>
                <li class="breadcrumb-item active">Credit Logs </li>
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
                      <form name="search" action="{{route('allcreditlogs')}}"method="get">
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
                          <th>Id</th>
                          <th>User</th>
                          <th>Credits</th>
                          <th>Purchase Date</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($allCreditLog as $row)
                        <tr>
                          <td>{{ $row->id}}</td>
                          <td>{{ $row->user->name}}</td>
                          <td>{{ $row->credits}}</td>
                          <td>{{ date('d M, Y h:i A',strtotime($row->created_at))}}</td>
                          <td>
                              <a href="{{route('selected.creditdetail',$row->user->id)}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Detail" class="btn btn-icon bg-dark white"><i class="la la-eye"></i></a>
                              <a href="{{route('selected.userdetail',$row->user->id)}}" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Profile" class="btn btn-icon bg-dark white marginicon"><i class="ft-user"></i></a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                      <div class="mt-1" id="xyz"> {{ $allCreditLog->links() }} </div>
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


