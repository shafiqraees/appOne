@extends('marketing.layouts.marketer')
@section('content')
    <div class="app-content content list_custom_setting5">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Marketing Detail</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('home')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item"><a href="{{route('marketer.marketing')}}">Marketing</a> </li>
                                <li class="breadcrumb-item active">Create Add Compaign</li>
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
                <section id="demo">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">

                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        <form method="post" action="{{route('save.add')}}" class="steps-validation wizard-circle" enctype="multipart/form-data" >
                                        @csrf
                                        <!-- Step 1 -->
                                            <h6>Create Add</h6>
                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-md-6 mt-1">
                                                        <label for="emailAddress1">Name</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text bg-dark border-dark white" id="basic-addon7 fonticon-container">
                                                                    <div class="fonticon-wrap">
                                                                        <i class="ft-user"></i>
                                                                    </div>
                                                                </span>
                                                            </div>
                                                            <input type="text" name="Name" class="form-control required errormessage heightinputs" aria-describedby="basic-addon7" placeholder="Enter Name" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mt-1">
                                                        <div class="form-group">
                                                            <label for="date1">Start Date </label>
                                                            <input type="date" name="AddDate" class="form-control required heightinputs" id="txtDate" />

                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-1">
                                                        <label for="emailAddress1">Video</label>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text bg-dark border-dark white" id="basic-addon7 fonticon-container">
                                                            <div class="fonticon-wrap">
                                                                <i class="ft-video"></i>
                                                            </div>
                                                                </span>
                                                            </div>
                                                            <input type="file" name="videoupload" value="" class="form-control required errormessage heightinputs" accept="video/mp4,video/x-m4v,video/*"  onchange="ValidateSingleInput(this);"/>

                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 ">
                                                        <div class="form-group mb-0">
                                                            <label for="location1">Description</label>
                                                            <textarea class="form-control" name="Description" id="exampleFormControlTextarea1" rows="4" required></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-6 col-md-6 mt-1">
                                                        <div class="form-group ">
                                                            <label>Banner</label>

                                                            <div class="input-group">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text bg-dark border-dark white" id="basic-addon7 fonticon-container">
                                                            <div class="fonticon-wrap">
                                                                <i class="ft-image"></i>
                                                            </div>
                                                                    </span>
                                                                </div>
                                                                <input type="file" id="imgInp" class="form-control required heightinputs errormessage " name="bannerupload" accept=".png, .jpg, .jpeg" required>
                                                                <img class="img-fluid" id='img-upload'/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <!-- Step 2 -->
                                            <h6>Select Audience</h6>
                                            <fieldset>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="row mb-1">
                                                            <div class="col-md-3">
                                                                <label class="inline-block" for="sel1">Gender</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <fieldset class="row abc">
                                                                    <label class="col-md-6">
                                                                        <input id="rdb1" type="radio" name="Gender" value="male" class="css-checkbox"  checked />
                                                                        Male<span></span>

                                                                    </label>
                                                                    <label class="col-md-6">
                                                                        <input id="rdb2" type="radio" name="Gender" value="female" class="css-checkbox" />
                                                                        Female <span></span> </label>
                                                                </fieldset>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="inline-block  mb-1" for="sel1">Age (Years)</label>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="form-group">
                                                                    <div class="double-slider mt-1">
                                                                        <input type="range" name="Age_from" class="from required" value="{{$diff}}" min="{{$diff}}" max="99" data-prev-value="0" required>
                                                                        <input type="hidden" name="mainimum_age" class="from required" value="{{$diff}}" min="{{$diff}}" max="99" data-prev-value="{{$diff}}" required>
                                                                        <div class="progressbar_from"></div>
                                                                        <input type="range" name="Age_to" class="to required" value="99" min="{{$diff}}" max="99" data-prev-value="99" required>
                                                                        <div class="progressbar_to"></div>
                                                                        <span class="value-output from">{{$diff}}</span> <span class="value-output to">99</span></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <label class="inline-block" for="sel1">Location</label>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <fieldset class="form-group">
                                                                    <input id="autocomplete" onFocus="geolocate()" name='Location' class="form-control required heightinputs" type="text">
                                                                    <input type="hidden" name="latitude" id="latitude" value="">
                                                                    <input type="hidden" name="longitude" id="longitude" value="">
                                                                    <input type="hidden" name="location_id" id="location_id" value="">
                                                                    <input type="hidden" name="url" id="url" value="{{route('audience')}}">
                                                                </fieldset>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label>Requirements :</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="row">
                                                                    <div class="col-md-12 col-sm-12">
                                                                        <fieldset class="row abc">
                                                                            <label class="col-md-5">
                                                                                <input id="rdb1" type="radio" name="UniqueImpressions" value="1" class="css-checkbox" checked />
                                                                                Unique Impressions<span></span></label>
                                                                            <label class="col-md-7 css-label radGroup2" id="bbb">
                                                                                <input id="rdb2"  class="css-checkbox" type="radio" name="UniqueImpressions" value="2" />
                                                                                Show ads multilpe time <span></span>
                                                                                <div id="blk-2" style="display:none"> <span class="badge badge-square inputwdith">
                                                                                    <input type="number" min="2" name="multipleImpressions" size="1" class="form-control col-10" id="basicInput123">
                                                                                        </span> <p class="times">Times</p> </div>
                                                                            </label>
                                                                        </fieldset>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="row">
                                                            <div class="col-md-3 mt-1">
                                                                <label class="inline-block" for="sel1">Radius (KMs)</label>
                                                            </div>
                                                            <div class="col-md-7 col-10">
                                                                <fieldset class="form-group">
                                                                    <input type="number" min="1" name="radius" class="form-control required heightinputs"  id="basicInput3">
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-md-2 col-2">
                                                                <label class="inline-block pt-1" for="sel1">KM</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <!-- Step 3 -->
                                            <h6>Allocate Budget</h6>
                                            <fieldset>
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <div class="badge bg-dark badge-square badge-lg"> <span id="creditsset">1 Credit means 1 impression </span> </div>
                                                        <label class="d-block pt-1" for="sel1">Allocate Funds (Rands)</label>
                                                        <fieldset class="form-group">
                                                            <input type="number" id="alocatefunds" name="Fund_to" min="0" class="form-control required heightinputs" required>
                                                        </fieldset>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="badge bg-dark badge-square badge-lg mb-2"> <span id="creditsset"> Match Audience Found: <p id="audience_mache"></p> </div>

                                                        <fieldset class="row abc mt-1">
                                                            <label class="col-md-6">
                                                                <input id="rdb1" type="radio" name="Endoncebudgetends" value="3" class="css-checkbox"  />
                                                                End Date<span></span>
                                                                <div id="blk-3" style="display:none;margin-top: 10px;">
                                                                    <input type="date" name="Endondate" class="form-control" id="endtxtDate" />
                                                                </div>
                                                            </label>
                                                            <label class="col-md-6">
                                                                <input id="rdb2" type="radio" name="Endoncebudgetends" value="4" class="css-checkbox" checked/>
                                                                End once budget ends <span></span> </label>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </fieldset>
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
