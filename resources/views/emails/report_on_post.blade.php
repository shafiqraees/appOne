<!DOCTYPE html>

<html>

<head>

    <title>APP One</title>

</head>

<body>
<p>Hy {{ $details['name'] }}!</p>

<p>{{ $details['message'] }}</p>

<h4>Content:</h4>

<h5>Post title:</h5>

<p>{{ $details['post_title'] }}</p>
@if(isset($details['post_video']) && !empty($details['post_video']))
    <a href="https://player.vimeo.com/video/{{$details['post_video']}}">Video click here</a>
    <fieldset class="form-group row">
        <div class="col-md-3">
            <div class="embed-responsive embed-responsive-16by9">
                <iframe src="https://player.vimeo.com/video/{{$details['post_video']}}" class="embed-responsive-item" width="100%" height="" frameborder="0" title="{video_title}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
            </div>
        </div>
    </fieldset>
@else
    <img src="{{Storage::disk('s3')->exists('md/'.$details['post_image']) ? Storage::disk('s3')->url('md/'.$details['post_image']) : Storage::disk('s3')->url('default.png')}}">
@endif

<h5>Post Discription:</h5>

<p>{{ $details['post_description'] }}</p>

<h4>Date Posted:</h4>

<p>{{ $details['post_created_at'] }}</p>

<h4>Message by Reporter:</h4>

<p>Reported by: {{ $details['reported_by'] }}</p>

<p>{{ $details['reported_message'] }}</p>

<p>{{ $details['company_message'] }}</p>

<h4>{{ $details['body'] }}</h4>

</body>

</html>
