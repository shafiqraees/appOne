@extends('admin.layouts.main')
@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">About</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item"><a href="javascript:void(0);">CMS</a> </li>
                                <li class="breadcrumb-item active">About Us</li>
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
                                        <form method="post" class="form" action="{{route('aboutusupdate')}}" name="form-example-1" id="form-example-1" enctype="multipart/form-data">
                                            @csrf
                                            <div class="input-field mb-1 aboutdescr">
                                                <label class="active">Description</label>
                                                <textarea id="description-1" name="description" id="aboutdesc" class="form-control" rows="10">{{isset($data->CmsTypes->content) ? $data->CmsTypes->content : ""}} </textarea>
                                                <input type="hidden" name="cms_side_bar_id" value="{{isset($data->CmsTypes->id) ? $data->CmsTypes->id : 1}}">
                                            </div>
                                            <div class="form-actions mb-2 mt-0 py-0">
                                                <button type="submit" class="btn btn-social btn-dark  btn-dark float-right text-center pr-1 "> <span class="ft-edit font-medium-3"></span> Update</button>
                                            </div>
                                        </form>

                                        <div class="row"> <div class="col-sm-12 col-md-12"><h4 class="card-title" id="repeat-form">User</h4></div></div>
                                        <div class="row">
                                            <div class="col-sm-12 col-md-12">
                                                @if(isset($data->CmsTypes->CmsTypeImages))
                                                    @foreach($data->CmsTypes->CmsTypeImages as $sub_data)
                                                        @if($sub_data->toturial_type == "user")

                                                            <form name="user-images" class="row" method="post" action="{{route('aboutusuimages')}}" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="form-group mb-1 col-sm-12 col-md-4">

                                                                    <label for="emailAddress1">Video</label>
                                                                    <div class="input-group videoadd ">
                                                                        <div class="input-group-prepend">
                                                                    <span class="input-group-text bg-dark border-dark white" id="basic-addon7 fonticon-container">
                                                                        <div class="fonticon-wrap"> <i class="ft-video"></i></div>
                                                                    </span>
                                                                        </div>
                                                                        <input type="hidden" name="data_id" value="{{$sub_data->id}}" class="form-control required errormessage heightinputs" placeholder="Name">
                                                                        <input type="hidden" name="original_image" value="{{$sub_data->image}}" class="form-control required errormessage heightinputs" placeholder="Name">
                                                                        <input type="hidden" name="user_type" value="{{$sub_data->toturial_type}}" class="form-control required errormessage heightinputs" placeholder="Name">
                                                                        <input type="hidden" name="cms_side_bar_id" value="{{isset($data->CmsTypes->id) ? $data->CmsTypes->id : 1}}">
                                                                        <input type="file" name="video" class="form-control errormessage heightinputs "  accept="video/mp4,video/x-m4v,video/*" multiple  onchange="ValidateSingleInput(this);"/>
                                                                    </div>
                                                                    <a href="https://player.vimeo.com/video/{{$sub_data->image}}" target="_blank"> Play Video</a>
                                                                </div>
                                                                <div class="form-group mb-1 col-sm-12 col-md-4 col-12">
                                                                    <label for="profession">Title</label>
                                                                    <div class="input-group videoadd ">
                                                                        <div class="input-group-prepend">
                                                                    <span class="input-group-text bg-dark border-dark white" id="basic-addon7 fonticon-container">
                                                                    <div class="fonticon-wrap"> <i class="ft-plus-circle"></i></div>
                                                                    </span>
                                                                        </div>
                                                                        <input type="text" name="title" value="{{$sub_data->name}}" id="filetitle" class="form-control required errormessage heightinputs" placeholder="Name">
                                                                    </div>
                                                                </div>
                                                                <div class="form-actions mb-2 col-sm-12 col-md-2 businesbtn_top">
                                                                    <select class="form-select form-control" aria-label=" select example" name="status">
                                                                        <option value="publish" {{ ( $sub_data->status == 'publish') ? 'selected' : '' }}> Publish </option>
                                                                        <option value="unPublish" {{ ( $sub_data->status == 'unPublish') ? 'selected' : '' }}> Unpublish </option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-actions float-right pl-1 col-sm-12 col-md-2 col-12 mb-2 mt-0 py-0">
                                                                    <button type="submit" class="btn btn-social btn-dark  btn-dark  text-center pr-1 aboutbtn_top"> <span class="ft-edit font-medium-3"></span> Update</button>
                                                                </div>
                                                            </form>

                                                        @endif
                                                    @endforeach
                                            </div></div>

                                        <div class="row"> <div class="col-sm-12 col-md-12"><h4 class="card-title mt-2" id="repeat-form">Business</h4></div></div>
                                        @foreach($buisness_data as $sub_data)
                                                <form name="user-images" method="post" class="row" action="{{route('aboutusuimages')}}" enctype="multipart/form-data">
                                                    @csrf

                                                    <div class="form-group mb-1 col-sm-12 col-md-4">
                                                        <label for="emailAddress1">Video</label>
                                                        <div class="input-group videoadd ">
                                                            <div class="input-group-prepend">
                                                                    <span class="input-group-text bg-dark border-dark white" id="basic-addon7 fonticon-container">
                                                                        <div class="fonticon-wrap"> <i class="ft-video"></i></div>
                                                                    </span>
                                                            </div>
                                                            <input type="hidden" name="data_id" value="{{$sub_data->id}}" class="form-control required errormessage heightinputs" placeholder="Name">
                                                            <input type="hidden" name="original_image" value="{{$sub_data->image}}" class="form-control required errormessage heightinputs" placeholder="Name">
                                                            <input type="hidden" name="user_type" value="{{$sub_data->toturial_type}}" class="form-control required errormessage heightinputs" placeholder="Name">
                                                            <input type="hidden" name="cms_side_bar_id" value="{{isset($data->CmsTypes->id) ? $data->CmsTypes->id : 1}}">
                                                            <input type="file" name="video" class="form-control errormessage heightinputs "  accept="video/mp4,video/x-m4v,video/*" multiple  onchange="ValidateSingleInput(this);"/>
                                                        </div>
                                                        <a href="https://player.vimeo.com/video/{{$sub_data->image}}" target="_blank"> Play Video</a>
                                                    </div>
                                                    <div class="form-group mb-1 col-sm-12 col-md-4 col-12">
                                                        <label for="profession">Title</label>
                                                        <div class="input-group videoadd ">
                                                            <div class="input-group-prepend">
                                                                    <span class="input-group-text bg-dark border-dark white" id="basic-addon7 fonticon-container">
                                                                    <div class="fonticon-wrap"> <i class="ft-plus-circle"></i></div>
                                                                    </span>
                                                            </div>
                                                            <input type="text" name="title" value="{{$sub_data->name}}" id="filetitle2" class="form-control required errormessage heightinputs" placeholder="Name">
                                                        </div>
                                                    </div>
                                                    <div class="form-actions mb-2 col-sm-12 col-md-2 businesbtn_top">
                                                        <select class="form-select form-control" aria-label=" select example" name="status">
                                                            <option value="publish" {{ ( $sub_data->status == 'publish') ? 'selected' : '' }}> Publish </option>
                                                            <option value="unPublish" {{ ( $sub_data->status == 'unPublish') ? 'selected' : '' }}> Unpublish </option>
                                                        </select>
                                                    </div>
                                                    <div class="form-actions mb-2 col-sm-12 col-md-2 pl-1 businesbtn_top">
                                                        <button type="submit" class="btn btn-social btn-dark  btn-dark  text-center  pr-1"> <span class="ft-edit font-medium-3"></span> Update</button>
                                                    </div>
                                                </form>
                                        @endforeach
                                        @endif
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
