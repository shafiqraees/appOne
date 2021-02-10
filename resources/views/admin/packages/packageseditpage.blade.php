@extends('admin.layouts.main')
@section('content')
    <div class="app-content content list_custom_setting5">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Packages</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item active">Packages</li>
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
                <section id="user-profile-cards" class="row mt-2">
                    @php $i=1;
                    @endphp
                    @foreach($allPackages as $packages)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">

                                    <div class="badge badge-dark badge-square">Package {{ $i++ }}</div>
                                    <form class="form-horizontal" id="packages{{$i}}" name="packagesname" method="post" action="{{route('admin.package.update')}}">
                                        @csrf
                                        <fieldset>
                                            <label class="mt-1" for="packagesname">Packages Name</label>
                                            <div class="input-group packageserrors">
                                                <input type="text" class="form-control" id="package{{$i}}" name="name" placeholder="Name" aria-describedby="basic-addon4" value="{{$packages->name  }}">
                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <label class="mt-1" for="credits">Credits</label>
                                            <div class="input-group packageserrors">
                                                <input type="number" class="form-control" id="credits{{$i}}" min="0" name="credits" placeholder="Credits" aria-describedby="basic-addon4" value="{{$packages->credits  }}">

                                            </div>
                                        </fieldset>

                                        <fieldset>
                                            <label class="mt-1" for="packageprice">Package Price</label>
                                            <div class="input-group packageserrors">
                                                <input type="number" class="form-control" id="price{{$i}}" min="0" name="price" placeholder="Package Price" aria-describedby="basic-addon4" value="{{$packages->price  }}">
                                            </div>
                                        </fieldset>

                                        <input type="hidden" name="recordid" value="{{$packages->id  }}"/><br/>
                                        <button class="btn btn-dark btn-square btn-social text-center px-0 btn-block" type="submit"> <span class="la
                la-rotate-right font-medium-3"></span>Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </section>
            </div>
        </div>
    </div>

@endsection

