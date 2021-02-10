@extends('admin.layouts.main')
@section('content')
<div class="app-content content list_custom_setting5">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
          <h3 class="content-header-title mb-0 d-inline-block">Credit Logs User</h3>
          <div class="row breadcrumbs-top d-inline-block">
            <div class="breadcrumb-wrapper col-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Dashboard</a> </li>
                <li class="breadcrumb-item"><a href="{{route('allcreditlogs')}}">Credit Logs</a> </li>
                <li class="breadcrumb-item active">Credit Logs User</li>
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
                    <table class="table table-striped table-bordered zero-configuration">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Credits</th>
                          <th>Last Purchase</th>
                          <th> Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>24</td>
                          <td>300</td>
                          <td>12-6-2020</td>
                          <td><a href="credit-logs-detail.php" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Detail" class="btn btn-icon bg-dark white mr-1"><i class="la la-eye"></i></a></td>
                        </tr>
                        <tr>
                          <td>30</td>
                          <td>400</td>
                          <td>15-8-2020</td>
                          <td><a href="credit-logs-detail.php" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Detail" class="btn btn-icon bg-dark white mr-1"><i class="la la-eye"></i></a></td>
                        </tr>
                        <tr>
                          <td>36</td>
                          <td>600</td>
                          <td>14-4-2020</td>
                          <td><a href="credit-logs-detail.php" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Detail" class="btn btn-icon bg-dark white mr-1"><i class="la la-eye"></i></a></td>
                        </tr>
                        <tr>
                          <td>24</td>
                          <td>300</td>
                          <td>12-6-2020</td>
                          <td><a href="credit-logs-detail.php" data-toggle="tooltip" data-placement="top" title="" data-original-title="View Detail" class="btn btn-icon bg-dark white mr-1"><i class="la la-eye"></i></a></td>
                        </tr>
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
