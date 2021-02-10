<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentLikeRequest;
use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\DislikeRequest;
use App\Http\Requests\PostActivitiesRequest;
use App\Http\Requests\PostRequest;
use App\Http\Requests\ReportingPostRequest;
use App\Http\Requests\SaveCommentRequest;
use App\Http\Requests\VideoRequest;
use App\Mail\BusinessCreation;
use App\Mail\ReportOnPost;
use App\Models\AboutUsImage;
use App\Models\Category;
use App\Models\HashTag;
use App\Models\Post;
use App\Models\PostActivity;
use App\Models\PostCategory;
use App\Models\PostComment;
use App\Models\PostCommentsLike;
use App\Models\PostHashTag;
use App\Models\PostImage;
use App\Models\PostTopic;
use App\Models\PostViewer;
use App\Models\ReportingPost;
use App\Models\Topic;
use App\Models\UserProfile;
use App\Models\UserProfileCategory;
use App\Models\UserTopic;
use App\Traits\Transformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Vimeo\Laravel\Facades\Vimeo;

class PostController extends Controller
{
    /**
     *  store Posts
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request,$id)
    {

        $postRequest = New PostRequest();
        $validator = Validator::make($request->all(), $postRequest->rules(),$postRequest->messages());

        if ($validator->fails()) {
            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', $validator->errors());
        }

        try {
            DB::beginTransaction();
            //upload profile pic
            $image_path = "post/default.png";
            $video_path = NULL;
            if ($request->image) {
                $req = json_decode(file_get_contents("php://input"));

                if ($req->image) {
                    $image_parts = explode(";base64,", $req->image);
                    $image_type_aux = explode("image/", $image_parts[0]);

                    $image_type = $image_type_aux[1];

                    $image_base64 = base64_decode($image_parts[1]);
                    $image_path = 'posts/' . uniqid() . '.' . $image_type;
                    //$path = 'profiles/' . uniqid() . '.' . $image_type;
                    SavePostJsonImageAllSizes($image_base64, 'posts/',$image_path);
                    //Storage::disk('s3')->put($image_path, $image_base64);
                }
            }
            /*if ($request->video) {
                $req = json_decode(file_get_contents("php://input"));

                if ($req->video) {
                    $video_parts = explode(";base64,", $req->video);

                    $video_type_aux = explode("image/", $video_parts[0]);

                    $video_type = $video_type_aux[1];
                    $video_base64 = base64_decode($video_parts[1]);
                    $video_path = uniqid() . '.' . $video_type;
                    dd($video_path);
                    $video  = Vimeo::upload($video_base64);
                    dd($video);
                    //Storage::disk('s3')->put($image_path, $video_base64);
                }
            }*/
            $data = [
                'user_id' => $request->user_id,
                'title' => $request->title,
                'description' => $request->description,
                'user_profile_id' => $id,
                'is_featured' => $request->is_featured
            ];
            $post = Post::Create($data);
            $data_image = [
                'user_profile_id' => $id,
                'post_id' => $post->id,
                'image' => $image_path,
                'video' => $video_path
            ];
            PostImage::Create($data_image);
            // store data in user interest categories
            if (!empty($request->categories)) {
                foreach ($request->categories as $interest) {
                    if (isset($interest['id'])) {
                        $category_id = $interest['id'];
                    } else {
                        if (empty($interest['name'])) {
                            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', 'Category name is required');
                        }
                        $find = Category::whereName($interest['name'])->first();
                        if ($find) {
                            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', 'Category name should be unique');
                        }
                        $data_interest['name'] = $interest['name'];
                        $category = Category::Create($data_interest);
                        $category_id = $category->id;
                    }
                    $category_rst = UserProfileCategory::whereCategoryId($category_id)->whereUserProfileId($id)->first();
                    if ($category_rst){
                        $category_data['category_id'] = $category_id;
                        $category_data['user_profile_id'] = $id;
                        $category_data['post_id'] = $post->id;
                        PostCategory::create($category_data);
                    } else {
                        $category_data['category_id'] = $category_id;
                        $category_data['user_profile_id'] = $id;
                        $category_data['post_id'] = $post->id;
                        PostCategory::Create($category_data);
                    }

                }

            }
            // store data in user topics
            if (!empty($request->topic)) {
                foreach ($request->topic as $topic) {
                    if (isset($topic['id'])) {
                        $topic_id = $topic['id'];
                    } else {
                        if (empty($topic['name'])) {
                            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', 'Topic name is required');
                        }
                        $find_topic = Topic::whereName($topic['name'])->first();
                        if ($find_topic) {
                            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', 'Topic name should be unique');
                        }
                        $data_topic['name'] = $topic['name'];
                        $topics = Topic::Create($data_topic);
                        $topic_id = $topics->id;
                    }
                    $topic_rst = UserTopic::whereTopicId($topic_id)->whereUserProfileId($id)->first();
                    if ($topic_rst) {
                        $topic_data_pre['topic_id'] = $topic_id;
                        $topic_data_pre['user_profile_id'] = $id;
                        $topic_data_pre['post_id'] = $post->id;
                        PostTopic::Create($topic_data_pre);
                    } else {
                        $topic_selected['topic_id'] = $topic_id;
                        $topic_selected['user_profile_id'] = $id;
                        $topic_selected['user_id'] = $request->user_id;
                        $usertopic = UserTopic::Create($topic_selected);
                        // insert into post topics
                        $topic_data['topic_id'] = $topic_id;
                        $topic_data['user_profile_id'] = $id;
                        $topic_data['post_id'] = $post->id;
                        PostTopic::Create($topic_data);
                    }

                }

            }
            // store hastag with posts data
            if (!empty($request->hashtag)) {
                foreach ($request->hashtag as $hashtag) {
                    if (isset($hashtag['id'])) {
                        $hashtag_id = $hashtag['id'];
                    } else {
                        if (empty($hashtag['name'])) {
                            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', 'Hashtag name is required');
                        }
                        $find_hashtag = HashTag::whereName($hashtag['name'])->first();
                        if ($find_hashtag) {
                            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', 'Hashtag name should be unique');
                        }
                        $data_hashtag['name'] = $hashtag['name'];
                        $hashtags = HashTag::Create($data_hashtag);
                        $hashtag_id = $hashtags->id;
                    }

                    $hash_selected['hash_tag_id'] = $hashtag_id;
                    $hash_selected['user_profile_id'] = $id;
                    $hash_selected['post_id'] = $post->id;
                    $usertopic = PostHashTag::Create($hash_selected);

                }

            }
            DB::commit();
            $transformed_posts = Transformer::transformCreatePost($post);
            return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_posts);
        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
    /**
     *  update Posts
     * @param Request $request
     * @return mixed
     */
    public function update(Request $request,$id,$post_id)
    {

        $postRequest = New PostRequest();
        $validator = Validator::make($request->all(), $postRequest->rules(),$postRequest->messages());

        if ($validator->fails()) {
            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', $validator->errors());
        }

        try {
            $user_profile = UserProfile::find($id);
            if ($user_profile) {
                $profile_post = Post::find($post_id);
                if ($profile_post) {
                    DB::beginTransaction();
                    $post_files = PostImage::wherePostId($post_id)->first();
                    $path = $post_files->image;
                    if ($request->image) {
                        $req = json_decode(file_get_contents("php://input"));
                        if ($req->image) {
                            $image_parts = explode(";base64,", $req->image);
                            $image_type_aux = explode("image/", $image_parts[0]);
                            $image_type = $image_type_aux[1];
                            $image_base64 = base64_decode($image_parts[1]);
                            $path = 'posts/' . uniqid() . '.' . $image_type;
                            //$path = 'profiles/' . uniqid() . '.' . $image_type;
                            UpdateJsonImageAllSizes($image_base64, 'posts/', $path, $post_files->image);
                            //Storage::disk('s3')->put($path, $image_base64);
                        }
                    }
                    $data = [
                        'title' => $request->title,
                        'description' => $request->description,
                        'is_featured' => $request->is_featured
                    ];
                    $profile_post->update($data);
                    $data_image = [
                        'user_profile_id' => $id,
                        'post_id' => $post_id,
                        'image' => !empty($path) ? $path : $post_files->image,
                    ];
                    $post_files->update($data_image);

                    // store data in user interest categories
                    if (!empty($request->categories)) {
                        $topic_rst = PostCategory::wherePostId($post_id)->whereUserProfileId($id)->pluck('id');
                        if ($topic_rst) {
                            PostCategory::whereIn('id', $topic_rst)->delete();
                        }
                        foreach ($request->categories as $interest) {
                            $category_data['category_id'] = $interest['id'];
                            $category_data['user_profile_id'] = $id;
                            $category_data['post_id'] = $post_id;
                            PostCategory::Create($category_data);
                        }
                    }
                    // store data in user topics
                    if (!empty($request->topic)) {
                        $topic_rst = PostTopic::wherePostId($post_id)->whereUserProfileId($id)->pluck('id');
                        if ($topic_rst) {
                            PostTopic::whereIn('id', $topic_rst)->delete();
                        }
                        foreach ($request->topic as $topic) {
                                $topic_data['topic_id'] = $topic['id'];;
                                $topic_data['user_profile_id'] = $id;
                                $topic_data['post_id'] = $post_id;
                                PostTopic::Create($topic_data);
                            }

                        }
                    // store hastag with posts data
                    if (!empty($request->hashtag)) {
                        $hash_rst = PostHashTag::wherePostId($post_id)->whereUserProfileId($id)->pluck('id');
                        if ($hash_rst) {
                            PostHashTag::whereIn('id', $hash_rst)->delete();
                        }
                        foreach ($request->hashtag as $hashtag) {
                            if (isset($hashtag['id'])) {
                                $hashtag_id = $hashtag['id'];
                            } else {
                                if (empty($hashtag['name'])) {
                                    return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', 'Hashtag name is required');
                                }
                                $find_hashtag = HashTag::whereName($hashtag['name'])->first();
                                if ($find_hashtag) {
                                    return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', 'Hashtag name should be unique');
                                }
                                $data_hashtag['name'] = $hashtag['name'];
                                $hashtags = HashTag::Create($data_hashtag);
                                $hashtag_id = $hashtags->id;
                            }
                            $hash_selected['hash_tag_id'] = $hashtag_id;
                            $hash_selected['user_profile_id'] = $id;
                            $hash_selected['post_id'] = $post_id;
                            $post_hash_tags = PostHashTag::Create($hash_selected);
                        }

                    }
                    DB::commit();
                    return $this->apiResponse(JsonResponse::HTTP_OK, 'data', "Post updated successfully");
                } else {
                    return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Post not found');
                }
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     *  store Posts videos
     * @param Request $request
     * @return mixed
     */
    public function storeVideo(Request $request,$id,$post_id)
    {
        try {
            DB::beginTransaction();
            $userprofile = UserProfile::find($id);
            if ($userprofile) {
                $post = Post::find($post_id);
                if ($post) {
                    if ($request->hasFile('video')) {
                        $video = $request->file('video');
                        $fiel_name = $request->file('video')->getClientOriginalName();
                        $vimeo = Vimeo::upload($video,[
                            "name" => $fiel_name
                        ]);
                        $videourl = str_replace('/videos/', '', $vimeo); //it contains vimeo id
                    }
                    if ($request->hasFile('image')) {
                        SaveImageAllSizes($request, 'advertise/');
                        $path = 'advertise/'.$request->image->hashName();
                    }
                    $input_data_images = [
                        'video'    =>   !empty($videourl) ? $videourl : "",
                        'video_thumbnail'    =>   !empty($path) ? $path : "",
                    ];
                    PostImage::wherePostId($post_id)->update($input_data_images);

                    DB::commit();
                    return $this->apiResponse(JsonResponse::HTTP_OK, 'data', "File uploaded successfully");
                } else {
                    return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Post not found');
                }

            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }
        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     *  store Posts videos
     * @param Request $request
     * @return mixed
     */
    public function updateVideo(Request $request,$id,$post_id)
    {
        try {
            DB::beginTransaction();
            $userprofile = UserProfile::find($id);
            if ($userprofile) {
                $post = Post::find($post_id);
                if ($post) {
                    $post_image = PostImage::find($request->image_id);
                    if ($post_image) {
                        if ($request->hasFile('video')) {
                            $video = $request->file('video');
                            $fiel_name = $request->file('video')->getClientOriginalName();
                            $vimeo = Vimeo::upload($video,[
                                "name" => $fiel_name
                            ]);
                            $videourl = str_replace('/videos/', '', $vimeo); //it contains vimeo id
                        }
                        if ($request->hasFile('profile_pic')) {
                            UpdateImageAllSizes($request, 'advertise/', $post_image->video_thumbnail);
                            $path = 'advertise/'.$request->profile_pic->hashName();
                        }
                        $input_data_images = [
                            'video'    =>   !empty($videourl) ? $videourl : $post_image->video,
                            'video_thumbnail' =>  !empty($path) ? $path : $post_image->video_thumbnail,
                        ];
                        $post_image->update($input_data_images);
                        DB::commit();
                        return $this->apiResponse(JsonResponse::HTTP_OK, 'data', "File updated successfully");
                    }else {
                        return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Video not found');
                    }
                } else {
                    return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Post not found');
                }

            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }
        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     *  store Comment on certian post
     * @param Request $request
     * @return mixed
     */
    public function storeComment(Request $request,$id)
    {
        $commentRequest = New SaveCommentRequest();
        $validator = Validator::make($request->all(), $commentRequest->rules(),$commentRequest->messages());

        if ($validator->fails()) {
            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', $validator->errors());
        }

        try {
            DB::beginTransaction();
            $userprofile = UserProfile::find($id);
            if ($userprofile) {
                $data = [
                    'user_profile_id' => $id,
                    'post_id' => $request->post_id,
                    'comment' => $request->comment,
                ];
                $post = Post::find($request->post_id);
                if (empty($post)){
                    return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Post not found');
                }
                $comment = PostComment::Create($data);
                if (isset($comment)) {
                    $title = "New Comment on your post";
                    $message_body = $userprofile->profile_name. " have commented on your post " .$post->title;
                    $action = "Show_that_post";
                    $action_key = $request->post_id;
                    $uniq_key = uniqid();
                    $body = [
                        'message' => $message_body,
                        'action' => $action,
                        'action_key' => $action_key,
                        'uniq_key' => $uniq_key,
                    ];
                    $this->getNotificationDetail($id,$post->user_profile_id,$title,$body);
                }
                DB::commit();
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $comment);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     *  Post Activites (likes, shares, favourite)
     * some posts by user
     * @param Request $request $id => user_profile_id
     * @return mixed
     */
    public function postActivities(Request $request,$id)
    {
        $activityRequest = New PostActivitiesRequest();
        $validator = Validator::make($request->all(), $activityRequest->rules(),$activityRequest->messages());

        if ($validator->fails()) {
            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', $validator->errors());
        }
        try {
            DB::beginTransaction();
            $userprofile = UserProfile::find($id);
            if ($userprofile) {
                $data = [
                    'user_profile_id' => $id,
                    'post_id' => $request->post_id,
                    'is_like' => $request->is_like,
                    'is_share' => $request->is_share,
                    'is_favourite' => $request->is_favourite,
                ];
                //dd($data);
                $post = Post::find($request->post_id);
                if (empty($post)){
                    return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Post not found');
                }
                $check = PostActivity::wherePostId($request->post_id)->whereUserProfileId($id)->first();
                if ($check) {
                    $check->update($data);
                    $like_data = PostActivity::wherePostId($request->post_id)->whereUserProfileId($id)->first();
                } else {
                    $like_data = PostActivity::Create($data);
                }
                if (isset($request->is_like) && $request->is_like === "true") {
                    $title = "New Like on your post";
                    $message_body = $userprofile->profile_name. " liked your post " .$post->title;
                    $action = "Show_that_post";
                    $action_key = $request->post_id;
                    $uniq_key = uniqid();
                    $body = [
                        'message' => $message_body,
                        'action' => $action,
                        'action_key' => $action_key,
                        'uniq_key' => $uniq_key,
                        ];

                    $this->getNotificationDetail($id,$post->user_profile_id,$title,$body);
                }
                DB::commit();
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $like_data);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     *  Post Activites (likesrevert)
     * some posts by user
     * @param Request $request $id => user_profile_id
     * @return mixed
     */
    public function postDislike(Request $request,$id)
    {
        $dislikeRequest = New DislikeRequest();
        $validator = Validator::make($request->all(), $dislikeRequest->rules(),$dislikeRequest->messages());

        if ($validator->fails()) {
            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', $validator->errors());
        }

        try {
            DB::beginTransaction();
            $userprofile = UserProfile::find($id);
            if ($userprofile) {
                $data = [
                    'user_profile_id' => $id,
                    'post_id' => $request->post_id,
                    'is_like' => $request->is_like
                ];
                //dd($data);
                $post = Post::find($request->post_id);
                if (empty($post)){
                    return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Post not found');
                }
                $comment = PostActivity::whereId($request->like_id)->update($data);
                DB::commit();
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $comment);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
    /**
     *  Post Activites (likesrevert)
     * some posts by user
     * @param Request $request $id => user_profile_id
     * @return mixed
     */
    public function deletePost(Request $request,$id,$post_id)
    {
        try {
            DB::beginTransaction();
            $userprofile = UserProfile::find($id);
            if ($userprofile) {
                $post = Post::find($request->post_id);
                if ($post){
                    $post->delete();
                    DB::commit();
                    return $this->apiResponse(JsonResponse::HTTP_OK, 'message', 'Post deleted successfully');
                } else {
                    return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Post not found');
                }
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
    /**
     *  Comment Activites (likes and like revert)
     * some posts by user
     * @param Request $request $id => user_profile_id
     * @return mixed
     */
    public function commentLike(Request $request,$id)
    {
        $commentRequest = New CommentLikeRequest();
        $validator = Validator::make($request->all(), $commentRequest->rules(),$commentRequest->messages());

        if ($validator->fails()) {
            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', $validator->errors());
        }

        try {
            DB::beginTransaction();
            $userprofile = UserProfile::find($id);
            if ($userprofile) {
                $data = [
                    'user_profile_id' => $id,
                    'post_comment_id' => $request->post_comment_id,
                    'post_id' => $request->post_id,
                    'is_like' => $request->is_like
                ];
                //dd($data);
                $post = Post::find($request->post_id);
                if (empty($post)){
                    return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Post not found');
                }
                $postcomment = PostCommentsLike::whereUserProfileId($id)->wherePostCommentId($request->post_comment_id)->first();
                if ($postcomment) {
                    $comment = PostCommentsLike::whereUserProfileId($id)->wherePostCommentId($request->post_comment_id)->update($data);
                } else {
                    $comment = PostCommentsLike::Create($data);
                }
                if (isset($request->is_like) && $request->is_like === "true") {
                    $title = "New Like on comment";
                    $message_body = $userprofile->profile_name. " have liked comment on your post " .$post->title;
                    $action = "Show_that_post";
                    $action_key = $request->post_id;
                    $uniq_key = uniqid();
                    $body = [
                        'message' => $message_body,
                        'action' => $action,
                        'action_key' => $action_key,
                        'uniq_key' => $uniq_key,
                    ];
                    $this->getNotificationDetail($id,$post->user_profile_id,$title,$body);
                }
                DB::commit();
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $comment);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     *  post View by current user
     * some posts by user
     * @param Request $request $id => user_profile_id
     * @return mixed
     */
    public function postView($id,$post_id)
    {

        try {
            DB::beginTransaction();
            $userprofile = UserProfile::find($id);
            if ($userprofile) {
                $data = [
                    'user_profile_id' => $id,
                    'post_id' => $post_id,
                ];
                //dd($data);
                $post = Post::find($post_id);
                if (empty($post)){
                    return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Post not found');
                }
                $post_view = PostViewer::Create($data);
                DB::commit();
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $post_view);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
    /**
     *  post View by current user
     * some posts by user
     * @param Request $request $id => user_profile_id
     * @return mixed
     */
    public function postReporting(Request $request,$id,$post_id)
    {
        $reporting_Request = New ReportingPostRequest();
        $validator = Validator::make($request->all(), $reporting_Request->rules(),$reporting_Request->messages());

        if ($validator->fails()) {
            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', $validator->errors());
        }
        try {
            DB::beginTransaction();
            $userprofile = UserProfile::whereId($id)->whereProfileIsSuspend('false')->first();
            if ($userprofile) {
                $data = [
                    'reported_by' => $id,
                    'post_id' => $post_id,
                    'report_text' => $request->comment,
                ];
                //dd($data);
                $post = Post::find($post_id);
                if (empty($post)){
                    return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Post not found');
                }
                $post_view = ReportingPost::Create($data);
                /* ======send a welcome email=======*/
                $report_data = UserProfile::whereId($post->user_profile_id)->whereProfileIsSuspend('false')->first();
                $post_image = PostImage::wherePostId($post_id)->first();
                if ($report_data) {
                    $mail_data =[
                        'name' => "Hy ".$report_data->profile_name,
                        'body' => "Thanks",
                        'message' => "Although we are inquiring and are in communication with reporter, Please see post below which is reported.",
                        'post_title' => $post->title,
                        'post_description' => $post->description,
                        'post_image' => $post_image->image,
                        'post_video_thumbnail' => $post_image->video_thumbnail,
                        'post_video' => $post_image->video,
                        'post_created_at' => $post->created_at,
                        'reported_by' => $userprofile->profile_name,
                        'reported_message' => $request->comment,
                        'company_message' => "Please take necessary action if its violating our terms. AppOne reserves the right to suspend your account or delete this content if its violating terms.",
                    ];
                    Mail::to($report_data->profile_email)->send(new ReportOnPost($mail_data));
                }
                /* ======send a welcome email=======*/
                DB::commit();
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $post_view);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }


    /**
     *  post View by current user
     * some posts by user
     * @param Request $request $id => user_profile_id
     * @return mixed
     */
    public function getNotificationDetail($send_id,$reciver_id,$title,$body)
    {
        try {
            $userprofile = UserProfile::whereId($send_id)->whereProfileIsSuspend('false')->first();
            if ($userprofile) {
                $reciver = UserProfile::whereId($reciver_id)->whereProfileIsSuspend('false')->whereHas('user',function ($query){
                    $query->where('is_active','true')->where('notification_status','true');
                })->first();
                /*$get_profile = Post::whereId($request->post_id)->whereHas('userProfile', function ($query) {
                        $query->where('profile_is_suspend','false')->where('notification_status','true');
                    })->with(['userProfile' => function ($sub_query){
                        $sub_query->whereHas('user', function ($query) {
                            $query->where('is_active','true')->where('notification_status','true');
                        })->with('user');
                    }])->first();*/

                if ($reciver) {
                    sendFireBaseNotification($reciver->user->device_token, $title,$body);
                }
            }
        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
}

