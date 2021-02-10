@extends('admin.layouts.main')
<style>
    .dataTables_filter {
        display: none;
    }
    table {
        width: 100%;
        border-collapse: collapse;

    }
    td,
    th {
        padding: 10px;
        border: 1px solid #ccc;

    }
    @media only screen and (max-width: 760px),
    (min-device-width: 768px) and (max-device-width: 1024px) {
        table {
            width: 100%;
        }
        table,
        thead,
        tbody,
        th,
        td,
        tr {
            display: block;
        }
        tr {
            border: 1px solid #ccc;
        }

        td {

            border: none;
            border-bottom: 1px solid #eee;

        }
        tfoot{
            display: block;
            width: 100%;
        }

    }
</style>
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Analytics</h3>
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
                                    <form name="search" action="{{route('marketing.compaign')}}"method="get">
                                        <div class="row">
                                            <div class="col-md-4 mb-1">
                                                <fieldset class="form-group">

                                                        <label> From date</label>
                                                        <input class="form-control heightinputs max-date" name="max_date" id="datefield" value="{{old('min_date', request('min_date'))}}" type="date" >
                                                        <div class="input-group-append">
                                                            <input type="hidden" name="compaign" value="{{old('compaign', request('compaign'))}}">
                                                        </div>

                                                </fieldset>
                                            </div>
                                            <div class="col-xl-4 col-md-4">

                                                    <fieldset class="form-group">
                                                        <label> To date</label>
                                                        <input class="form-control heightinputs min-date" name="min_date" id="min-date" value="{{old('min_date', request('min_date'))}}" type="date" >
                                                    </fieldset>

                                            </div>
                                            <div class="col-xl-4 col-md-4 mt-2" style="padding-top: 7px;">
<!--                                                <button type="cancel" class="btn btn-dark heightinputs refresh_btn"> <i class="fonticon-classname"></i> Refresh </button>-->
<!--                                                <button type="submit" class="btn btn-dark heightinputs"> <i class="fonticon-classname"></i> Filter </button>-->
                                                <input type="submit" name="btnSubmit" class="btn btn-dark heightinputs" value="Download" />
                                                <input type="submit" name="btnSubmit"class="btn btn-dark heightinputs" value="Submit" />
                                            </div>
                                        </div>
                                    </form>

                                        <table class="table-responsive-lg">
                                            <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Totoal Imp</th>
                                                <th>Male Imp</th>
                                                <th>Fem Imp </th>
                                                <th>Totoal Clicks</th>
                                                <th>Male Clicks</th>
                                                <th>Fem Clicks</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php
                                                $totoal_imp = 0;
                                                $male_imp = 0;
                                                $female_imp = 0;
                                                $totoal_click = 0;
                                                $male_click = 0;
                                                $female_click = 0;
                                            @endphp
                                            @foreach($data as $row)
                                                <tr>
                                                    <td>{{date('d M,Y',strtotime($row->created_at))}}</td>
                                                    <td>{{$row->total}}</td>
                                                    <td>{{$row->male_impression}}</td>
                                                    <td>{{$row->female_impression}}</td>
                                                    <td>{{$row->total_click}}</td>
                                                    <td>{{$row->male_click}}</td>
                                                    <td>{{$row->female_click}}</td>
                                                    @php
                                                        $totoal_imp = $totoal_imp + $row->total;
                                                        $male_imp = $male_imp + $row->male_impression;
                                                        $female_imp = $female_imp + $row->female_impression;
                                                        $totoal_click = $totoal_click + $row->total_click;
                                                        $male_click = $male_click + $row->male_click;
                                                        $female_click = $female_click + $row->female_click;
                                                    @endphp
                                                </tr>
                                            @endforeach
                                            </tbody>
                                            <tfoot >
                                            <tr>
                                                <th>Total</th>
                                                <th>{{$totoal_imp}}</th>
                                                <th>{{$male_imp}}</th>
                                                <th>{{$female_imp}}</th>
                                                <th>{{$totoal_click}}</th>
                                                <th>{{$male_click}}</th>
                                                <th>{{$female_click}}</th>
                                            </tr>
                                            </tfoot>
                                        </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
