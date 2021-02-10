<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddLikeShareRequest;
use App\Http\Requests\PostActivitiesRequest;
use App\Http\Requests\ReportingPostRequest;
use App\Mail\ReportOnPost;
use App\Models\AddActivity;
use App\Models\AddImpresssion;
use App\Models\AddsMarketing;
use App\Models\AdveriseWithUs;
use App\Models\CmsSideBar;
use App\Models\Country;
use App\Models\Follower;
use App\Models\Post;
use App\Models\PostActivity;
use App\Models\PostComment;
use App\Models\PostImage;
use App\Models\PostViewer;
use App\Models\ReportingPost;
use App\Models\UserProfile;
use App\Models\UserProfileCategory;
use App\Traits\Transformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Type\Integer;
use Carbon\Carbon;


class HomeController extends Controller
{
    /**
     *  get all Friends whome you are following
     * and that person also back following your profile
     * @param Request $request
     * @return mixed
     */
    public function getAllFriends(Request $request, $id)
    {

        try {
            $limit = !empty(request('limit')) ? request('limit') : 10;
            $keyword = !empty(request('keyword')) ? request('keyword') : "";
            $profile = UserProfile::whereId($id)->whereProfileIsSuspend('false')->first();
            if ($profile) {
                $followers = Follower::whereFollowToId($id)->pluck('follow_by_id')->toArray();
                $following = Follower::whereFollowById($id)->pluck('follow_to_id')->toArray();
                //$meta = Transformer::transformCollection($followers,$following);
                $transformed_posts = Transformer::transformAllFriends($followers, $following, $keyword);
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_posts);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     *  Viw social Profile
     * @param Request $request
     * @return mixed
     */
    public function viewSocialProfilePrivate($id, Request $request)
    {

        try {
            $status = !empty($request->profile_status) ? $request->profile_status : 'public';
            $type = !empty($request->profile_type) ? $request->profile_type : 'social';
            $current_user = !empty($request->current_user_profile_id) ? $request->current_user_profile_id : null;
            $profile = UserProfile::whereId($id)->whereProfileIsSuspend('false')/*->whereProfileStatus($status)->whereProfileType($type)*/->first();
            if ($profile) {
                $followers = UserProfile::whereId($id)->whereProfileIsSuspend('false')/*->whereProfileType($type)*/->whereHas('followers')->with(['followers', 'userCategories'])->first();
                $following = UserProfile::whereId($id)->whereProfileIsSuspend('false')/*->whereProfileType($type)*/->whereHas('following')->withCount(['following'])->first();
                $posts = UserProfile::whereId($id)->whereProfileIsSuspend('false')/*->whereProfileType($type)*/->whereHas('posts')->withCount(['posts'])->first();
                $is_following = Follower::whereFollowById($current_user)->whereFollowToId($id)->count();
                $about_data = UserProfile::whereId($id)->whereProfileIsSuspend('false')->whereHas('user')->with(['topics','user'=>function ($query){
                    $query->select('users.id','name','about');
                }])->first();
                $transformed_profile = Transformer::transformViewProfile($followers, $following, $posts, $profile,$is_following, $about_data);
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_profile);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     *  view Buisnes Profile
     * @param Request $request
     * @return mixed
     */
    public function viewBuisnessProfile($id)
    {
        try {
            $status = !empty($request->profile_status) ? $request->profile_status : 'public';
            $type = !empty(request('type')) ? request('type') : '';
            $limit = !empty(request('limit')) ? request('limit') : 10;
            $is_featured = !empty(request('is_featured')) ? request('is_featured') : "false";
            $profile = UserProfile::whereId($id)->whereProfileIsSuspend('false')/*->whereProfileStatus($status)->whereProfileType($type)*/->first();
            if ($profile) {
                $topic_id = null;
                if (\request('topic_id')) {
                    $topic_id = !empty(request('topic_id')) ? request('topic_id') : "";
                }
                $posts = Post::whereUserProfileId($id)->whereIsFeatured($is_featured)
                    ->whereHas('postTopics', function ($query) use ($topic_id) {
                        if (!empty($topic_id)) {
                            $query->whereTopicId($topic_id);
                        }
                    })
                    ->whereHas('postImage', function ($qry) {
                        if (request('type')) {
                            $type = request('type') ? request('type') : '';

                            if (!empty($type)) {
                                if ($type === 'video') {
                                    $qry->whereNotNull('video');
                                }
                            }
                            if (!empty($type)) {
                                if ($type === 'image') {
                                    $qry->whereNull('video');
                                }
                            }
                        }
                    })->with(['postTopics', 'postImage' => function ($sub_query) {
                        if (request('type')) {
                            $type = request('type') ? request('type') : '';

                            if (!empty($type)) {
                                if ($type == 'video') {
                                    $sub_query->whereNotNull('video');
                                }
                            }
                        }
                    }]);
                $post_data = $posts->paginate($limit);
                $meta = Transformer::transformCollection($post_data);
                $transformed_posts = Transformer::transformViewBuisnessProfile($post_data,$type);
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_posts, $meta);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     *  get all Suggested
     * @param Request $request
     * @return mixed
     */
    public function getSuggestedFriends(Request $request,$id)
    {

        try {
            $status = !empty($request->profile_status) ? $request->profile_status : 'public';
            $type = !empty($request->profile_type) ? $request->profile_type : 'social';
            $category_id = !empty($request->category_id) ? $request->category_id : null;
            $profile = UserProfile::whereId($id)->whereProfileIsSuspend('false')/*->whereProfileStatus($status)->whereProfileType($type)*/->first();
            if ($profile) {
                $data = $profile->whereHas('userCategories', function ($query) {
                    if (!empty($category_id)) {
                        $query->where('categories.id',$category_id);
                    }
                    $query->whereHas('userProfiles');
                })->with(['userCategories' => function ($qury) use($category_id){
                    $qury->where('categories.id',$category_id);
                    $qury->with(['userProfiles' => function ($sub_query) {
                        $sub_query->select('user_profiles.id', 'user_profiles.user_id', 'profile_name', 'profile_email', 'profile_image',
                            'profile_type', 'profile_status', 'profile_is_suspend', 'user_profiles.created_at');
                    }]);
                }])->first();
                $transformed_data = Transformer::transformSuggestedFriends($data->userCategories, $id);
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_data);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     *  get all Posts
     * @param Request $request
     * @return mixed
     */
    public function getAllPost($id)
    {
        try {
            $status = !empty($request->profile_status) ? $request->profile_status : 'public';
            $type = !empty(request('type')) ? request('type') : "";
            $limit = !empty(request('limit')) ? request('limit') : 10;
            $profile = UserProfile::whereId($id)->whereProfileIsSuspend('false')/*->whereProfileStatus($status)->whereProfileType($type)*/->first();
            if ($profile) {
                $follow_by_id = Follower::whereFollowToId($id)->pluck('follow_by_id')->toArray();
                $following = Follower::whereFollowById($id)->pluck('follow_to_id')->toArray();
                $friends = $result = array_intersect($follow_by_id, $following);
                $following = array_merge($following, [(Integer)$id]);
                $posts = Post::whereHas('postImage', function ($qry) {
                    if (request('type')) {
                        $type = request('type') ? request('type') : '';

                        if (!empty($type)) {
                            if ($type === 'video') {
                                $qry->whereNotNull('video');
                            }
                        }
                        if (!empty($type)) {
                            if ($type === 'image') {
                                $qry->whereNull('video');
                            }
                        }
                    }
                })->with(['postImage'])
                    ->whereHas('userProfile')
                    ->with(['userProfile' => function ($qury) {
                        $qury->select('user_profiles.id', 'profile_name', 'profile_image');
                    }])->withcount('postComments')->withcount(['postActivities as is_share_count' => function ($query) {
                        $query->where('is_share', 'true');
                    }, 'postActivities as is_like_count' => function ($query) {
                        $query->where('is_like', 'true');
                    },'postActivities as self_like' => function ($query) use ($id) {
                        $query->whereUserProfileId($id)->where('is_like', 'true');

                    }]);
                if (request('hash_tag')) {
                    if (!empty(request('hash_tag'))) {
                        $posts = $posts->whereHas('hashtag', function ($query) {
                            $query->where('name', 'like', '%'. request('hash_tag') .'%');
                        })->with(['hashtag']);
                    }
                }
                if (request('trending')) {
                    if (!empty(request('trending'))) {
                        $posts = $posts->whereHas('postActivities', function ($query) {
                            $query->where('created_at', '>=', Carbon::now()->subWeeks(1));
                        });
                    }
                }
                if (request('category_id')) {
                    if (!empty(request('category_id'))) {
                        $posts = $posts->whereHas('postCategories', function ($query) {
                            $query->where('categories.id',  request('category_id'));
                        })->with(['postCategories']);
                    }
                }
                if (request('friends')) {
                    if (!empty(request('friends'))) {
                        $posts = $posts->whereIn('user_profile_id', $friends)->orderBy('id', 'desc');
                    }
                } else {
                    $posts = $posts->whereIn('user_profile_id', $following)->orderBy('id', 'desc');
                }

                $post_data = $posts->paginate($limit);
                $meta = Transformer::transformCollection($post_data);
                $transformed_posts = Transformer::transformPosts($post_data,$type);
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_posts, $meta);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
    /**
     *  get single post detail data
     * @param Request $request
     * @return mixed
     */
    public function postDetail($id,$post_id)
    {
        try {
            $status = !empty($request->profile_status) ? $request->profile_status : 'public';
            $type = !empty($request->profile_type) ? $request->profile_type : 'social';
            $profile = UserProfile::whereId($id)->whereProfileIsSuspend('false')/*->whereProfileStatus($status)->whereProfileType($type)*/->first();
            if ($profile) {
                $post_check = Post::find($post_id);
                if ($post_check) {
                    $posts = Post::whereId($post_id)->whereHas('postImage')->with(['postImage'])
                        ->whereHas('userProfile')
                        ->with('hashtag','postCategories','getpostTopic')
                        ->with(['postComments'=> function ($sub_qury) use ($id){
                            $sub_qury->whereHas('userProfile')->with(['userProfile' => function ($qury) {
                                $qury->select('user_profiles.id', 'profile_name', 'profile_image');
                            }]);
                            $sub_qury->withcount(['commentLikes as comment_likes_count' => function ($comment_query)  use ($id){
                                $comment_query->where('is_like', 'true');
                            }, 'commentLikes as self_comment_like' => function ($query) use ($id) {
                                $query->whereUserProfileId($id)->where('is_like', 'true');
                            }]);
                        }])
                        ->with(['userProfile' => function ($qury) {
                            $qury->select('user_profiles.id', 'profile_name', 'profile_image');
                        }])->withcount('postComments')->withcount(['postActivities as is_share_count' => function ($query) {
                            $query->where('is_share', 'true');
                        }, 'postActivities as is_like_count' => function ($query) {
                            $query->where('is_like', 'true');
                        },'postActivities as self_like' => function ($query) use ($id) {
                            $query->whereUserProfileId($id)->where('is_like', 'true');
                        }]);
                    $post_data = $posts->first();
                    $transformed_posts = Transformer::transformPostDetail($post_data);
                    return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_posts);
                } else {
                    return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'post not found');
                }

            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
    /**
     *  get side Bar all API;s data
     * @param Request $request
     * @return mixed
     */
    public function sideBar()
    {
        try {
            $sidebars = CmsSideBar::whereNull('deleted_at')->get();
            if ($sidebars) {
                $content = CmsSideBar::whereHas('CmsTypes')->with(['CmsTypes' => function ($qury) {
                    $qury->with(['CmsTypeImages'=> function ($sub_qury) {
//                        $sub_qury->select('about_us_images.id', 'image');
                    }]);
//                    $qury->select('content');
                }])->get();
                $transformed_posts = Transformer::transformSideBar($content);
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_posts);

            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     *  get all adds
     * @param Request $request
     * @return mixed
     */
    public function viewAdds(Request $request,$id)
    {
        try {
            $today = date('Y-m-d');
            $status = !empty($request->profile_status) ? $request->profile_status : 'public';
            $type = !empty($request->profile_type) ? $request->profile_type : 'social';
            $limit = !empty(request('limit')) ? request('limit') : 10;
            $profile = UserProfile::whereId($id)->whereProfileIsSuspend('false')/*->whereProfileStatus($status)->whereProfileType($type)*/
                ->whereHas('user')
                ->with(['user' => function ($qury) {
                    $qury->select('users.id', 'gender', 'date_of_birth');
                }])
                ->first();
            if ($profile) {
                $user_age = Carbon::parse($profile->user->date_of_birth)->diff(Carbon::now())->format('%y');
                $data = AddsMarketing::whereStatus('visible')->whereAddStatus('active')/*->where('add_date','<=',$today)*/
                    ->where(function ($query) use($profile){
                        $query->where('gender', $profile->user->gender)
                            ->orWhereNull('gender');
                    })
                    ->where(function ($query) use($today){
                        $query->where('add_date','>=', $today)
                            ->where('add_date', $today)
                            ->orWhereNull('add_date');
                    })
                    ->where(function ($query) use($user_age){
                        $query->where('age_from', '<=', $user_age)
                            ->orWhereNull('age_from');
                    })
                    ->where(function ($query) use($user_age){
                        $query->where('age_to', '>', $user_age)
                            ->orWhereNull('age_to');
                    })
                    ->where(function ($query) {
                        $query->where('end_on_budget_end', 'true')
                            ->orWhereNull('end_on_budget_end');
                    })
                    ->where(function ($query) use($today){
                        $query->where('end_date', '>=', $today)
                            ->orWhereNull('end_date');
                    })
                    ->where(function ($query) use($profile){
                        $query->where('location', 'like', '%'. $profile->user->address .'%')
                            ->orWhereNull('location');
                    })
                    ->where(function ($query){
                        if (!empty(\request('latitude') && \request('longitude'))) {
                            $latitude = \request('latitude');
                            $longitude = \request('longitude');
                            $sql =  "(6378.10  * ACOS(COS(RADIANS($latitude))
                                * COS(RADIANS(latitude))
                                * COS(RADIANS($longitude) - RADIANS(longitude))
                                + SIN(RADIANS($latitude))
                                * SIN(RADIANS(latitude))))";
                            $query->whereRaw($sql.'<='."radious")
                                ->select(DB::raw("*, $sql AS distance"));
                        }
                        $query->orWhereNull('radious');
                    });
                $adds = $data->withCount(['addImpressions' => function($query) use($id) {
                    $query->where('user_profile_id', $id);

                }])
                    ->withCount('addImpressions as totalcount')
                    ->whereHas('userProfile')
                    ->with(['userProfile' => function ($qury) {
                        $qury->select('user_profiles.id', 'profile_name', 'profile_image');
                        $qury->whereHas('packages')->withCount(['packages as credits' => function ($sub_qury) {
                            $sub_qury->select(DB::raw("SUM(credits) as total_credits"));
                        }]);
                    }])->withcount('addActivities')->withcount(['addActivities as is_share_count' => function ($query) {
                        $query->where('is_share', 'true');
                    }, 'addActivities as is_like_count' => function ($query) {
                        $query->where('is_like', 'true');
                    },'addActivities as self_like' => function ($query) use ($id) {
                        $query->whereUserProfileId($id)->where('is_like', 'true');
                    }]);

                $post_data = $adds->paginate($limit);
                //dd($post_data);
                $meta = Transformer::transformCollection($post_data);
                $transformed_adds = Transformer::transformAdds($post_data,$profile);
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_adds, $meta);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch (\Exception $e) {
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
    public function addsActivities(Request $request,$id)
    {
        $activityRequest = New AddLikeShareRequest();
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
                    'adds_marketing_id' => $request->add_id,
                    'is_like' => $request->is_like,
                    'is_share' => $request->is_share
                ];
                //dd($data);
                $post = AddsMarketing::find($request->add_id);
                if (empty($post)){
                    return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Add not found');
                }
                $check = AddActivity::whereAddsMarketingId($request->add_id)->whereUserProfileId($id)->first();
                if ($check) {
                    $check->update($data);
                    $like_data = AddActivity::whereAddsMarketingId($request->add_id)->whereUserProfileId($id)->first();
                } else {
                    $like_data = AddActivity::Create($data);
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
     *  post View by current user
     * some posts by user
     * @param Request $request $id => user_profile_id
     * @return mixed
     */
    public function addImpression($id,$add_id)
    {
        try {
            DB::beginTransaction();
            $userprofile = UserProfile::find($id);
            if ($userprofile) {
                $data = [
                    'user_profile_id' => $id,
                    'adds_marketing_id' => $add_id,
                    'sex' => \request('sex'),
                    'is_click' => \request('is_click'),
                ];
                //dd($data);
                $post = AddsMarketing::find($add_id);
                if (empty($post)){
                    return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Add not found');
                }
                $post_view = AddImpresssion::Create($data);
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
     *  Advertise with us
     * some posts by user
     * @param Request $request $id => user_profile_id
     * @return mixed
     */
    public function advertiseWithUs()
    {
        try {
            $data = AdveriseWithUs::find(1);
            return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $data);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
    /**
     *  view Buisnes Profile
     * @param Request $request
     * @return mixed
     */
    public function getCatPost($id)
    {
        try {
            $limit = !empty(request('limit')) ? request('limit') : 10;
            $profile = UserProfile::whereId($id)->whereProfileIsSuspend('false')->first();
            if ($profile) {
                $cat_data = UserProfileCategory::whereUserProfileId($id)->first();
                if ($cat_data){
                    $cat_id = $cat_data->category_id;
                }
                if (\request('category_id')) {
                    $cat_id = !empty(request('category_id')) ? request('category_id') : '';
                }
                if ($cat_id) {
                    $posts = Post::whereHas('postCategories',function ($query) use ($cat_id){
                        $query->where('categories.id',$cat_id);
                    })->whereHas('postImage')->with(['postImage'])
                        ->whereHas('userProfile')
                        ->with(['userProfile' => function ($qury) {
                            $qury->select('user_profiles.id', 'profile_name', 'profile_image');
                        }])->orderBy('id', 'desc');
                    $post_data = $posts->paginate($limit);
                }
                $meta = Transformer::transformCollection($post_data);
                $transformed_posts = Transformer::transformCatPosts($post_data);
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_posts, $meta);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     *  Advertise with us
     * some posts by user
     * @param Request $request $id => user_profile_id
     * @return mixed
     */
    public function sendNotification(Request $request)
    {
        try {
            $token = "fJBnloTgTYieNMyY8a5mcR:APA91bHCSUG0y0fB11LQrH-KPDqxRAkstJKf1ke_oRsss7y2YecXx8_fLjXNEkwy8Vgl67oM4Nx2aYui0jGjh0mNX-QmfF_7a_y6t4-GzRDfouIG74Z0hThR5ES4HraOzhFyZjEx849Z";
            $data = sendFireBaseNotification($token, $request->title , $request->body);
            return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $data);
        } catch (\Exception $e) {
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
    public function postReporting(Request $request)
    {
        $reporting_Request = New ReportingPostRequest();
        $validator = Validator::make($request->all(), $reporting_Request->rules(),$reporting_Request->messages());

        if ($validator->fails()) {
            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', $validator->errors());
        }
        $id = $request->id;
        $post_id = $request->post_id;
        try {
            DB::beginTransaction();
            $userprofile = UserProfile::whereId($request->id)->whereProfileIsSuspend('false')->first();
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
                    $detail =[
                        'name' => "Hy ".$report_data->profile_name,
                        'body' => "Thanks",
                        'message' => "Although we are inquiring and are in communication with reporter, Please see post below which is reported.",
                        'post_title' => $post->title,
                        'post_description' => $post->description,
                        'post_image' => $post_image->image,
                        'post_video_thumbnail' => $post_image->video_thumbnail,
                        'post_created_at' => $post->created_at,
                        'reported_by' => $userprofile->profile_name,
                        'reported_message' => $request->comment,
                        'company_message' => "Please take necessary action if its violating our terms. AppOne reserves the right to suspend your account or delete this content if its violating terms.",
                    ];
                    Mail::to($report_data->profile_email)->send(new ReportOnPost($detail));
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
}
