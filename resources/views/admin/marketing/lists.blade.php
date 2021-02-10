@extends('admin.layouts.main')
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Marketing</h3>
          <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Dashboard</a> </li>
                <li class="breadcrumb-item active">Marketing </li>
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
                    <form name="search" action="{{route('all.marketing')}}"method="get">
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
                  <div class="table-responsive mt-1">
                    <table class="table">
                      <thead>
                        <tr>
                            <th>Id </th>
                            <th>User </th>
                            <th>Title</th>
                            <th>Created</th>
                            <th>Impressions</th>
                            <th>Funds alot </th>
                            <th>Status </th>
                            <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach($data as $row)
                        <tr>
                          <td>{{$row->id}}</td>
                          <td>{{$row->user->name}}</td>
                          <td>{{$row->name}}</td>
                          <td>{{date('d M,Y h:i A',strtotime($row->created_at))}}</td>
                          <td>{{$row->add_impressions_count}}</td>
                          <td>R {{!empty($row->funds_to) ? $row->funds_to : "Not Assign Fund"}}</td>
                          <td> {{$row->status}}</td>
                          <td>
                            <a href="{{route('marketing.detail',$row->id)}}" class="btn btn-icon bg-dark white" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Marketing Detail"><i class="la la-eye"></i></a>
                            <a href="{{route('selected.userdetail',$row->user_id)}}" class="btn marginicon btn-icon bg-dark white" data-toggle="tooltip" data-placement="top" title="" data-original-title="View User Profile"><i class="ft-user"></i></a>
                            <a href="{{route('underconstruction')}}" class="btn marginicon1 btn-icon bg-dark white" data-toggle="tooltip" data-placement="top" title="" data-original-title="View analytics Profile"><i class="ft-trending-up"></i></a>
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                      <div class="mt-3" id="xyz"> {{ $data->links() }} </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth()+1; //January is 0!
        var yyyy = today.getFullYear();
        if(dd<10){
            dd='0'+dd
        }
        if(mm<10){
            mm='0'+mm
        }

        today = yyyy+'-'+mm+'-'+dd;
        document.getElementById("date").setAttribute("max", today);

    });
</script>
@endsection



