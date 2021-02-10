<?php
//This function required intervention image library
function SaveImageAllSizes($request, $dir){
    $lg_image = Image::make($request->file('image'))->fit(400);
    $lg_image->response('png');

    $md_image = Image::make($request->file('image'))->fit(200);
    $md_image->response('png');

    $sm_image = Image::make($request->file('image'))->fit(100);
    $sm_image->response('png');

    $xs_image = Image::make($request->file('image'))->fit(50);
    $xs_image->response('png');

    $image_name = $request->image->hashName();

    //$request->file('image')->store($dir, ['disk' => 'public']);
    /* // for local
     Storage::disk('public')->put('lg/' .$dir . $image_name, $lg_image);
     Storage::disk('public')->put('md/' .$dir. $image_name, $md_image);
     Storage::disk('public')->put('sm/' .$dir. $image_name, $sm_image);
     Storage::disk('public')->put('xs/'.$dir . $image_name, $xs_image);*/
    //for s3 bucket
    Storage::disk('s3')->put('lg/' .$dir . $image_name, $lg_image);
    Storage::disk('s3')->put('md/' .$dir. $image_name, $md_image);
    Storage::disk('s3')->put('sm/' .$dir. $image_name, $sm_image);
    Storage::disk('s3')->put('xs/'.$dir . $image_name, $xs_image);
}

function SaveJsonImageAllSizes($image_base64, $dir, $image_path){
    $lg_image = Image::make($image_base64)->fit(400);
    $lg_image->response('png');

    $md_image = Image::make($image_base64)->fit(200);
    $md_image->response('png');

    $sm_image = Image::make($image_base64)->fit(100);
    $sm_image->response('png');

    $xs_image = Image::make($image_base64)->fit(50);
    $xs_image->response('png');

    $image_name = $image_path;

    //$request->file('image')->store($dir, ['disk' => 'public']);
    // for local
    /*Storage::disk('public')->put('lg/'  . $image_name, $lg_image);
    Storage::disk('public')->put('md/' . $image_name, $md_image);
    Storage::disk('public')->put('sm/' . $image_name, $sm_image);
    Storage::disk('public')->put('xs/' . $image_name, $xs_image);*/
    //for s3 bucket
    Storage::disk('s3')->put('lg/'  . $image_name, $lg_image);
    Storage::disk('s3')->put('md/' . $image_name, $md_image);
    Storage::disk('s3')->put('sm/' . $image_name, $sm_image);
    Storage::disk('s3')->put('xs/' . $image_name, $xs_image);
}

//store posts Images
function SavePostJsonImageAllSizes($image_base64, $dir, $image_path){
    $lg_image = Image::make($image_base64)->fit(400);
    $lg_image->response('png');

    $md_image = Image::make($image_base64)->fit(200);
    $md_image->response('png');

    $sm_image = Image::make($image_base64)->fit(100);
    $sm_image->response('png');

    $xs_image = Image::make($image_base64)->fit(50);
    $xs_image->response('png');

    $image_name = $image_path;

    //$request->file('image')->store($dir, ['disk' => 'public']);
    // for local
    /*Storage::disk('public')->put('lg/'  . $image_name, $lg_image);
    Storage::disk('public')->put('md/' . $image_name, $md_image);
    Storage::disk('public')->put('sm/' . $image_name, $sm_image);
    Storage::disk('public')->put('xs/' . $image_name, $xs_image);*/
    //for s3 bucket
    Storage::disk('s3')->put('lg/'  . $image_name, $lg_image);
    Storage::disk('s3')->put('md/' . $image_name, $md_image);
    Storage::disk('s3')->put('sm/' . $image_name, $sm_image);
    Storage::disk('s3')->put('xs/' . $image_name, $xs_image);
}

function UpdateImageAllSizes($request, $dir, $old_image){
    //Delete old images
    /*	Storage::disk('public')->delete('lg/' . $old_image);
        Storage::disk('public')->delete('md/' . $old_image);
        Storage::disk('public')->delete('sm/' . $old_image);
        Storage::disk('public')->delete('xs/' . $old_image);*/
    //for s3 bucket
    Storage::disk('s3')->delete('lg/' . $old_image);
    Storage::disk('s3')->delete('md/' . $old_image);
    Storage::disk('s3')->delete('sm/' . $old_image);
    Storage::disk('s3')->delete('xs/' . $old_image);
    $lg_image = Image::make($request->file('profile_pic'))->fit(400);
    $lg_image->response('png');

    $md_image = Image::make($request->file('profile_pic'))->fit(200);
    $md_image->response('png');

    $sm_image = Image::make($request->file('profile_pic'))->fit(100);
    $sm_image->response('png');

    $xs_image = Image::make($request->file('profile_pic'))->fit(50);
    $xs_image->response('png');

    $image_name = $request->profile_pic->hashName();

    /* Storage::disk('public')->put('lg/' .$dir . $image_name, $lg_image);
     Storage::disk('public')->put('md/' .$dir. $image_name, $md_image);
     Storage::disk('public')->put('sm/' .$dir. $image_name, $sm_image);
     Storage::disk('public')->put('xs/'.$dir . $image_name, $xs_image);*/
    //for s3 bucket
    Storage::disk('s3')->put('lg/' .$dir . $image_name, $lg_image);
    Storage::disk('s3')->put('md/' .$dir. $image_name, $md_image);
    Storage::disk('s3')->put('sm/' .$dir. $image_name, $sm_image);
    Storage::disk('s3')->put('xs/'.$dir . $image_name, $xs_image);
}

function UpdateJsonImageAllSizes($image_base64, $dir, $image_path ,$old_image){
    //Delete old images
    /*Storage::disk('public')->delete('lg/' . $old_image);
    Storage::disk('public')->delete('md/' . $old_image);
    Storage::disk('public')->delete('sm/' . $old_image);
    Storage::disk('public')->delete('xs/' . $old_image);*/
    //for s3 bucket
    Storage::disk('s3')->delete('lg/' . $old_image);
    Storage::disk('s3')->delete('md/' . $old_image);
    Storage::disk('s3')->delete('sm/' . $old_image);
    Storage::disk('s3')->delete('xs/' . $old_image);

    $lg_image = Image::make($image_base64)->fit(400);
    $lg_image->response('png');

    $md_image = Image::make($image_base64)->fit(200);
    $md_image->response('png');

    $sm_image = Image::make($image_base64)->fit(100);
    $sm_image->response('png');

    $xs_image = Image::make($image_base64)->fit(50);
    $xs_image->response('png');

    $image_name = $image_path;

    /*Storage::disk('public')->put('lg/'  . $image_name, $lg_image);
    Storage::disk('public')->put('md/' . $image_name, $md_image);
    Storage::disk('public')->put('sm/' . $image_name, $sm_image);
    Storage::disk('public')->put('xs/' . $image_name, $xs_image);*/
    //for s3 bucket
    Storage::disk('s3')->put('lg/' . $image_name, $lg_image);
    Storage::disk('s3')->put('md/' . $image_name, $md_image);
    Storage::disk('s3')->put('sm/' . $image_name, $sm_image);
    Storage::disk('s3')->put('xs/'. $image_name, $xs_image);
}

function SaveBannerAllSizes($request, $dir){
    $lg_image = Image::make($request->file('bannerupload'))->fit(400);
    $lg_image->response('png');

    $md_image = Image::make($request->file('bannerupload'))->fit(200);
    $md_image->response('png');

    $sm_image = Image::make($request->file('bannerupload'))->fit(100);
    $sm_image->response('png');

    $xs_image = Image::make($request->file('bannerupload'))->fit(50);
    $xs_image->response('png');

    $image_name = $request->bannerupload->hashName();

    //$request->file('image')->store($dir, ['disk' => 'public']);
    /* // for local
     Storage::disk('public')->put('lg/' .$dir . $image_name, $lg_image);
     Storage::disk('public')->put('md/' .$dir. $image_name, $md_image);
     Storage::disk('public')->put('sm/' .$dir. $image_name, $sm_image);
     Storage::disk('public')->put('xs/'.$dir . $image_name, $xs_image);*/
    //for s3 bucket
    Storage::disk('s3')->put('lg/' .$dir . $image_name, $lg_image);
    Storage::disk('s3')->put('md/' .$dir. $image_name, $md_image);
    Storage::disk('s3')->put('sm/' .$dir. $image_name, $sm_image);
    Storage::disk('s3')->put('xs/'.$dir . $image_name, $xs_image);
}

function UpdateBannerAllSizes($request, $dir, $old_image){
    //Delete old images
    Storage::disk('public')->delete($dir . $old_image);
    Storage::disk('public')->delete($dir . 'lg/' . $old_image);
    Storage::disk('public')->delete($dir . 'md/' . $old_image);
    Storage::disk('public')->delete($dir . 'sm/' . $old_image);
    Storage::disk('public')->delete($dir . 'xs/' . $old_image);

    $lg_image = Image::make($request->file('banner'))->fit(400);
    $lg_image->response('png');

    $md_image = Image::make($request->file('banner'))->fit(200);
    $md_image->response('png');

    $sm_image = Image::make($request->file('banner'))->fit(100);
    $sm_image->response('png');

    $xs_image = Image::make($request->file('banner'))->fit(50);
    $xs_image->response('png');

    $image_name = $request->banner->hashName();

    $request->file('banner')->store($dir, ['disk' => 'public']);
    Storage::disk('public')->put($dir . 'lg/' . $image_name, $lg_image);
    Storage::disk('public')->put($dir . 'md/' . $image_name, $md_image);
    Storage::disk('public')->put($dir . 'sm/' . $image_name, $sm_image);
    Storage::disk('public')->put($dir . 'xs/' . $image_name, $xs_image);
}

function SavePhotoAllSizes($request, $dir){

    $lg_image = Image::make($request->file('photo'))->fit(400);
    $lg_image->response('png');

    $md_image = Image::make($request->file('photo'))->fit(200);
    $md_image->response('png');

    $sm_image = Image::make($request->file('photo'))->fit(100);
    $sm_image->response('png');

    $xs_image = Image::make($request->file('photo'))->fit(50);
    $xs_image->response('png');

    $image_name = $request->photo->hashName();

    $request->file('photo')->store($dir, ['disk' => 'public']);
    Storage::disk('public')->put($dir . 'lg/' . $image_name, $lg_image);
    Storage::disk('public')->put($dir . 'md/' . $image_name, $md_image);
    Storage::disk('public')->put($dir . 'sm/' . $image_name, $sm_image);
    Storage::disk('public')->put($dir . 'xs/' . $image_name, $xs_image);
}

function UpdatePhotoAllSizes($request, $dir, $old_image){
    //Delete old images
    Storage::disk('public')->delete($dir . $old_image);
    Storage::disk('public')->delete($dir . 'lg/' . $old_image);
    Storage::disk('public')->delete($dir . 'md/' . $old_image);
    Storage::disk('public')->delete($dir . 'sm/' . $old_image);
    Storage::disk('public')->delete($dir . 'xs/'. $old_image);

    $lg_image = Image::make($request->file('photo'))->fit(400);
    $lg_image->response('png');

    $md_image = Image::make($request->file('photo'))->fit(200);
    $md_image->response('png');

    $sm_image = Image::make($request->file('photo'))->fit(100);
    $sm_image->response('png');

    $xs_image = Image::make($request->file('photo'))->fit(50);
    $xs_image->response('png');

    $image_name = $request->photo->hashName();

    $request->file('photo')->store($dir, ['disk' => 'public']);
    Storage::disk('public')->put($dir . 'lg/' . $image_name, $lg_image);
    Storage::disk('public')->put($dir . 'md/' . $image_name, $md_image);
    Storage::disk('public')->put($dir . 'sm/' . $image_name, $sm_image);
    Storage::disk('public')->put($dir . 'xs/' . $image_name, $xs_image);
}

function sendNotificationFCM($notification_id, $title, $message, $id,$type) {

    $accesstoken = env('FCM_KEY');
    $URL = 'https://fcm.googleapis.com/fcm/send';
    $post_data = '{
            "to" : "' . $notification_id . '",
            "data" : {
              "body" : "",
              "title" : "' . $title . '",
              "type" : "' . $type . '",
              "id" : "' . $id . '",
              "message" : "' . $message . '",
            },
            "notification" : {
                 "body" : "' . $message . '",
                 "title" : "' . $title . '",
                  "type" : "' . $type . '",
                 "id" : "' . $id . '",
                 "message" : "' . $message . '",
                "icon" : "new",
                "sound" : "default"
                },

          }';

    $crl = curl_init();
    $headr = array();
    $headr[] = 'Content-type: application/json';
    $headr[] = 'Authorization: ' . $accesstoken;
    curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($crl, CURLOPT_URL, $URL);
    curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);
    curl_setopt($crl, CURLOPT_POST, true);
    curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    $rest = curl_exec($crl);
    if ($rest === false) {
        // throw new Exception('Curl error: ' . curl_error($crl));
        //print_r('Curl error: ' . curl_error($crl));
        $result_noti = 0;
    } else {
        $result_noti = 1;
    }
    return $result_noti;
}

function sendEmail($email_to, $subject, $body,$type ) {

    $to = $email_to;
    //$subject = 'Welcome to YQ';
    $from = 'yq@arcticapps.dev';

// To send HTML mail, the Content-type header must be set
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Create email headers
    $headers .= 'From: '.$from."\r\n".
        'Reply-To: '.$from."\r\n" .
        'X-Mailer: PHP/' . phpversion();

// Compose a simple HTML email message
    $message = '<html><body>';
    if (isset($type) && $type == "register"){
        $message .= "<p>Welcome to YQ. We are thrilled to have you with us. We hope your experience with us would be fascinating.</p>";
    }
    if (isset($type) && $type == "verify"){
        $message .= '<p>"'.(int)( $body).'"</p>';
    } else {
        $message .= '<p>"'.$body.'"</p>';
    }
    $message .= '</body></html>';

// Sending email
    if(mail($to, $subject, $message, $headers)){
        return "success";
    } else{
        echo 'please enter valid email.';
    }
}

function sendFireBaseNotification($firebase_token, $title,$body)

{
    //$firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();
    $token = "da9da7NLQ9G9LJ1gngpStd:APA91bHwjS1_wt66s6Nn5nbtVPcZ7WUzzlicjxUkVQ5arspcD6gWThyXuVYLhVlUBn0Z";

    $firebaseToken = [$token];

    $SERVER_API_KEY = "AAAArGWF1DA:APA91bGCHo5eUZFzrQrb_E4kzp8LYHBVHKdso2zuo3U8khGv8Llg8DGdkkccGnWC9jH5PnEp7vjcvQLYOQegMQnp0ZycgVF8-DOAAfrJW-GKn6YKrEH1zf_rV_uRQl3a_czXdZHVE60j";

    $data = [

        "registration_ids" => [$firebase_token],

        "notification" => [

            "title" => $title,
            //"title" => "test Title",

            "body" => $body
            //"body" => "Test Body",

        ]

    ];

    $dataString = json_encode($data);

    $headers = [

        'Authorization: key=' . $SERVER_API_KEY,

        'Content-Type: application/json',
    ];

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

    $response = curl_exec($ch);
    return $response;

}
