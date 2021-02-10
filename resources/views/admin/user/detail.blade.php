@extends('admin.layouts.main')
@section('content')
    <div class="app-content content list_custom_setting5">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-12 col-12 mb-2 breadcrumb-new">
                    <h3 class="content-header-title mb-0 d-inline-block">Users</h3>
                    <div class="row breadcrumbs-top d-inline-block">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admindashboard')}}">Dashboard</a> </li>
                                <li class="breadcrumb-item"><a href="{{route('alluser')}}">Users</a> </li>
                                <li class="breadcrumb-item active">Users Detail</li>
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
                <ul class="nav nav-tabs nav-iconfall bg-white">
                    <li class="nav-item"> <a class="nav-link active" id="baseIcon-tab41" data-toggle="tab" aria-controls="tabIcon41"
                                             href="#tabIcon41" aria-expanded="true"><i class="ft-user"></i> Main Profile</a> </li>
                    @if($user_info->profiles)
                        @foreach($user_info->profiles as $data)
                            <li class="nav-item"> <a class="nav-link" id="baseIcon-tab{{$data->id}}" data-toggle="tab" aria-controls="tabIcon{{$data->id}}"
                                                     href="#tabIcon{{$data->id}}" aria-expanded="false"><i class="icon-bag"></i>{{$data->profile_name}}</a> </li>
                        @endforeach
                    @endif

                </ul>
                <div class="tab-content pt-1">
                    <div role="tabpanel" class="tab-pane active" id="tabIcon41" aria-expanded="true"
                         aria-labelledby="baseIcon-tab41">
                        <section id="user-profile-cards" class="row">
                            <div class="col-xl-3 col-md-3 col-12">
                                <div class="card border-dark border-lighten-2">
                                    <div class="text-center">
                                        <div class="card-header card-head-inverse bg-dark">
                                            <h4 class="card-title text-white">Main Profile</h4>
                                        </div>
                                        <div class="card-body"> <img src="{{Storage::disk('s3')->exists('md/'.$user_info->profile_photo_path) ? Storage::disk('s3')->url('md/'.$user_info->profile_photo_path) : Storage::disk('s3')->url('default.png')}}" class="rounded-circle  height-150"
                                                                     alt="Card image">
                                            <h4 class="card-title mt-1">{{$user_info->name}}</h4>
                                            <br>
                                            @if($user_info->gender == "male")
                                                <div class="badge border-left-amber badge-square badge-striped"> <i class="la la-male font-medium-2"></i> <span>Male</span> </div>
                                            @elseif($user_info->gender == "female")
                                                <div class="badge border-left-amber badge-square badge-striped mb-1"> <i class="la la-female font-medium-2"></i> <span>Female</span> </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-9 col-md-9 col-12">
                                <div class="content-body">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="row">
                                                <div class="col-xl-12 col-md-12 col-12 mb-1">
                                                    <a  href="{{route('allcreditlogs',['keyword'=>$user_info->name])}}" class="btn btn-outline-dark bg-dark bg-darken-1 white" data-toggle="tooltip" data-placement="top" title="" data-original-title="Credit Log"> <i class="la la-dollar"></i> </a>
                                                    <a href="{{route('alluserstransactions',['keyword'=>$user_info->name])}}" class="btn btn-outline-dark bg-dark bg-darken-4 white" data-toggle="tooltip" data-placement="top" title="" data-original-title="Transactions"> <i class="la la-money"></i> </a>
                                                    <a href="{{route('all.marketing',['keyword'=>$user_info->name])}}" class="btn btn-outline-dark bg-dark bg-lighten-2 white" data-toggle="tooltip" data-placement="top" title="" data-original-title="Marketing"> <i class="la la-star-o"></i> </a>
                                                    <div class="form-actions float-right">
                                                        @if($user_info->is_active == "false")
                                                            <button type="button"  class="btn btn-social text-center pr-1  bg-danger bg-darken-4 white mt-1 confirm-color UnSuspend" data-id="{{$user_info->id}}"> <span class="ft-stop-circle font-medium-3"></span> Unsuspend full profile</button>
                                                        @else
                                                            <button type="button"  class="btn btn-social text-center pr-1  bg-danger bg-darken-4 white mt-1 confirm-color Suspend" data-id="{{$user_info->id}}"> <span class="ft-stop-circle font-medium-3"></span> Suspend full profile</button>
                                                        @endif
                                                        <input type="hidden" name="url" id="user_url" value="{{route('suspend.user',$user_info->id)}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6  mb-1">
                                                    <label for="sel1">Email Address</label>
                                                    <fieldset>
                                                        <div class="input-group">
                                                            <input type="email" class="form-control heightinputs"  value="{{$user_info->email}}" placeholder="{{$user_info->email}}" aria-describedby="basic-addon4" readonly>
                                                            <div class="input-group-append"> <span class="input-group-text bg-dark border-dark white" id="basic-addon4"><i class="la la-envelope"></i></span> </div>
                                                        </div>
                                                    </fieldset>
                                                </div>
                                                <div class="col-md-6 ">
                                                    <label for="sel1">Password</label>
                                                    <fieldset>
                                                        <div class="input-group">
                                                            <input type="text" class="form-control heightinputs" value="{{$user_info->org_password}}" placeholder="{{$user_info->org_password}}" aria-describedby="basic-addon4" readonly>

                                                            <div class="input-group-append"> <span class="input-group-text bg-dark border-dark white" id="basic-addon4"><i class="la la-lock"></i></span> </div>
                                                        </div>
                                                    </fieldset>
                                                    <br>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="sel1">Date of Birth</label>
                                                    <fieldset>
                                                        <div class="input-group">

                                                            <input type="text" class="form-control heightinputs" value="{{date('d M Y',strtotime($user_info->date_of_birth))}}" placeholder="{{$user_info->date_of_birth}}" aria-describedby="basic-addon4" readonly>

                                                            <div class="input-group-append"> <span class="input-group-text bg-dark border-dark white" id="basic-addon4"><i class="la la-calendar"></i></span> </div>
                                                        </div>
                                                    </fieldset>
                                                    <br>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group  mb-0">
                                                        <label for="sel1">Country</label>
                                                        <select name="Country" class="form-control inline-block heightinputs" id="sel1" readonly>

                                                            <option value="{{$user_info->country->name}}" selected="selected">{{$user_info->country->name}}</option>
                                                        </select>
                                                        <br>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group form-group mb-0">
                                                        <label for="sel1">City</label>

                                                        <select name="Country" class="form-control inline-block heightinputs" id="sel1" readonly>

                                                            <option value="{{$user_info->city->name}}" selected="selected">{{$user_info->city->name}}</option>
                                                        </select>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-actions float-right">
                                        <a href="{{route('alluser')}}" class="btn btn-social btn-dark btn-dark text-center pr-1">
                                            <span class="ft-arrow-left font-medium-3"></span> Go Back
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    @if($user_info->profiles)
                        @foreach($user_info->profiles as $data)
                            <div class="tab-pane" id="tabIcon{{$data->id}}" aria-labelledby="baseIcon-tab{{$data->id}}">
                                <section id="user-profile-cards" class="row">
                                    <div class="col-xl-3 col-md-3 col-12">
                                        <div class="card border-dark border-lighten-2">
                                            <div class="text-center">
                                                <div class="card-header card-head-inverse bg-dark">
                                                    @if($data->profile_type =="business")
                                                        <h4 class="card-title text-white">{{$data->profile_name}} <br> (Business Profile)</h4>
                                                    @else
                                                        <h4 class="card-title text-white">{{$data->profile_name}}<br> (Social Profile)</h4>
                                                    @endif
                                                </div>
                                                <div class="card-body"> <img src="{{Storage::disk('s3')->exists('md/'.$data->profile_image) ? Storage::disk('s3')->url('md/'.$data->profile_image) : Storage::disk('s3')->url('default.png')}}" class="rounded-circle  height-150"
                                                                             alt="Card image">
                                                    <h4 class="card-title mt-1">{{$data->profile_name}}</h4>
                                                    {{--@if($data->profile_type =="social")--}}
                                                        @if($data->profile_status =="private")
                                                            <div class="badge border-left-amber badge-square badge-striped mb-1"> <i class="icon-lock font-medium-2"></i> <span>Private</span> </div>
                                                        @else
                                                            <div class="badge border-left-amber badge-square badge-striped"> <i class="icon-globe font-medium-2"></i> <span>Public</span> </div>
                                                        @endif
                                                        <br>

                                                    <!--                                                        <h6>Status: <span class="badge border-amber  amber  badge-square badge-border">{{$user_info->status}}</span></h6>-->
                                                    {{--@endif--}}
                                                </div>
                                                <div class="btn-group" role="group" aria-label="Profile example">
                                                    <button type="button" class="btn bg-blue-grey bg-darken-1 white btn-float box-shadow-0 btn-blue-grey btn-square"> <span class="ladda-label">{{$data->posts_count}} <span>Posts</span> </span> <span class="ladda-spinner"></span> </button>
                                                    <button type="button" class="btn bg-blue-grey bg-darken-2 white btn-float box-shadow-0 btn-blue-grey btn-square"> <span class="ladda-label">{{$data->followers_count}} <span>Followers</span> </span> <span class="ladda-spinner"></span> </button>
                                                    <button type="button" class="btn bg-blue-grey bg-darken-3 white btn-float box-shadow-0 btn-blue-grey btn-square"> <span class="ladda-label">{{$data->following_count}} <span>Following</span> </span> <span class="ladda-spinner"></span> </button>
                                                </div>
                                                <div class="list-group list-group-flush">
                                                    <h2 class="card-title mt-2">Stats</h2>
                                                    <a class="list-group-item bg-blue-grey bg-darken-1 white"><i class="la la-comment"></i> Comments<br>{{$data->postcomment_count}}</a>
                                                    <a class="list-group-item bg-blue-grey bg-darken-2 white"><i class="ft-video"></i> Video's<br>{{$data->video_count}}</a>
                                                    <a class="list-group-item bg-blue-grey bg-darken-3 white"><i class="ft-image"></i> Images<br>  {{$data->image_count}}</a>
                                                    <a class="list-group-item bg-blue-grey bg-darken-4 white"> <i class="la la-heart"></i> Likes<br>
                                                        {{$data->like_count}}</a> </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-9 col-md-9 col-12">
                                        <div class="content-body">
                                            <div class="card">
                                                <div class="card-header">
                                                    <div class="row">
                                                        @if($data->profile_type =="business")
                                                            <div class="col-xl-12 col-md-12 col-12 mb-1">
                                                                <div class="form-actions float-right">
                                                                    @if($user_info->is_active == "true")
                                                                        @if($data->profile_is_suspend == "false")

                                                                            <button type="button"  class="btn btn-social btn-dark btn-adn text-center pr-1 btn-outline-dark bg-danger bg-darken-4 white mt-1 profile-update" data-id="{{$data->id}}"> <span class="ft-stop-circle font-medium-3 suspendProfile{{$data->id}}"></span> Suspend {{$data->profile_name}}</button>

                                                                        @else

                                                                            <button type="button"  class="btn btn-social btn-dark btn-adn text-center pr-1 btn-outline-dark bg-danger bg-darken-4 white mt-1 profile-update" data-id="{{$data->id}}"> <span class="ft-stop-circle font-medium-3 suspendProfile{{$data->id}}"></span> Unsuspend {{$data->profile_name}}</button>

                                                                        @endif
                                                                    @endif
                                                                    <input type="hidden" name="url" id="profile_url" value="{{route('suspend.profile',$data->id)}}">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6 mt-1">

                                                                <label for="sel1">Email Address</label>
                                                                <fieldset>
                                                                    <div class="input-group">
                                                                        <input type="email" class="form-control heightinputs" value="{{$data->profile_email}}" placeholder="xyz@gmail.com" aria-describedby="basic-addon4" readonly>
                                                                        <div class="input-group-append"> <span class="input-group-text bg-dark border-dark white" id="basic-addon4"><i class="la la-envelope"></i></span> </div>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                            <div class="col-md-6 mt-1">

                                                                <label for="sel1">Country</label>
                                                                <fieldset>
                                                                    <div class="input-group">
                                                                        <input type="text" value="{{$data->country->name}}" class="form-control heightinputs" placeholder="12 April 2020" aria-describedby="basic-addon4" readonly>
                                                                        <div class="input-group-append"> <span class="input-group-text bg-dark border-dark white" id="basic-addon4"><i class="la la-flag"></i></span> </div>
                                                                    </div>
                                                                </fieldset>
                                                                <br>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="sel1">City</label>
                                                                <fieldset>
                                                                    <div class="input-group">
                                                                        <input type="email" class="form-control heightinputs" value="{{$data->city->name}}" placeholder="abc@gmail.com" aria-describedby="basic-addon4" readonly>
                                                                        <div class="input-group-append"> <span class="input-group-text bg-dark border-dark white" id="basic-addon4"><i class="la la-building"></i></span> </div>
                                                                    </div>
                                                                </fieldset>
                                                                <br>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <label for="sel1">Website</label>
                                                                <fieldset>
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control heightinputs" value="{{$data->profile_website}}" placeholder="www.google.com" aria-describedby="basic-addon4" readonly>
                                                                        <div class="input-group-append"> <span class="input-group-text bg-dark border-dark white" id="basic-addon4"><i class="la la-globe"></i></span> </div>
                                                                    </div>
                                                                </fieldset>
                                                            </div>
                                                        @endif
                                                        <div class="col-md-6">
                                                            <label class="invisible" for="sel1">Category</label>
                                                            <fieldset>
                                                                @foreach($data->userCategories as $category)

                                                                    <span class="badge badge-lg badge-square badge-dark mb-1">{{$category->name}}</span>

                                                                @endforeach
                                                            </fieldset>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>About</label>
                                                                <textarea id="projectinput8" rows="4" cols="50" class="form-control" placeholder="{{$data->profile_about}} " name="comment" readonly>{{$data->profile_about}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-actions float-right"> <a href="{{url()->previous()}}" class="btn btn-social btn-dark btn-dark text-center pr-1"> <span class="ft-arrow-left font-medium-3"></span> Go Back</a> </div>
                                        </div>
                                    </div>
                                </section>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
