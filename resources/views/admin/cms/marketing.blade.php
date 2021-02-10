@extends('admin.layouts.main')
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Marketing</h3>
          <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Dashboard</a> </li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">CMS</a> </li>
                <li class="breadcrumb-item active">Marketing </li>
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
      @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
      <div class="content-body">
        <section id="basic">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-content collapse show">
                  <div class="card-body">
                    <form class="form-horizontal" method="post" id="marketingdesription" action="{{route('admin.update.marketing')}}">
                        <label>Description</label>
                      <input type="hidden" name="recordid" value="{{$marketing->id}}"/>
                      @csrf
                      <div class="form-group">
                        <div class="row">
                          <div class="col-lg-12">
       <textarea rows="15" cols="5" name="marketing" id="marketingdes" class="form-control">{{$marketing->content}}</textarea>
                          </div>
                        </div>
                      </div>
  <div class="form-actions float-right mb-2 mt-0 py-0"><button type="submit" class="btn btn-social btn-dark  btn-dark  text-center  pr-1"> <span class="ft-edit font-medium-3"></span> Update</button> </div>
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

