<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddTopicRequest;
use App\Http\Requests\CreateAccountRequest;
use App\Http\Requests\EditUserInterestRequest;
use App\Http\Requests\FollowRequest;
use App\Http\Requests\SaveCommentRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\BusinessCreation;
use App\Mail\PasswordResetSuccess;
use App\Mail\Unsubcribe;
use App\Models\Category;
use App\Models\City;
use App\Models\Country;
use App\Models\Follower;
use App\Models\HashTag;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PrivateProfile;
use App\Models\PushNotification;
use App\Models\PushNotificationToUser;
use App\Models\Topic;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserProfileCategory;
use App\Models\UserTopic;
use App\Traits\Transformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     *  store profiles
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $profileRequest = New CreateAccountRequest();
        $validator = Validator::make($request->all(), $profileRequest->rules(),$profileRequest->messages());

        if ($validator->fails()) {
            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', $validator->errors());
        }

        try {
            $check_user = User::find($request->user_id);
            if ($check_user) {
                $user_profile = UserProfile::whereUserId($request->user_id)->whereProfileIsSuspend('false')->where('profile_type','social')->first();
                if ($user_profile && (isset($request->profile_type) && ($request->profile_type == "social"))) {
                    return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Social Profile already exist');
                }
                DB::beginTransaction();
                //upload profile pic
                $path = "profiles/default.png";
                $path_banner = "default.png";
                if ($request->profile_image) {
                    $req = json_decode(file_get_contents("php://input"));

                    if ($req->profile_image) {
                        $image_parts = explode(";base64,", $req->profile_image);
                        $image_type_aux = explode("image/", $image_parts[0]);

                        $image_type = $image_type_aux[1];

                        $image_base64 = base64_decode($image_parts[1]);
                        $path = 'profiles/' . uniqid() . '.' . $image_type;
                        SaveJsonImageAllSizes($image_base64, 'profiles/',$path);
                        //Storage::disk('s3')->put($path, $image_base64);
                    }
                }
                $data = [
                    'user_id' => $request->user_id,
                    'country_id' => $request->country_id,
                    'city_id' => $request->city_id,
                    'profile_name' => !empty($request->profile_name) ? $request->profile_name : "",
                    'profile_email' => !empty($request->profile_email) ? $request->profile_email : "",
                    'profile_image' => empty($path) ? 'defaul.png' : $path,
                    'profile_phone' => !empty($request->profile_phone) ? $request->profile_phone : "",
                    'profile_address' => !empty($request->profile_address) ? $request->profile_address : "",
                    'profile_website' => !empty($request->profile_website) ? $request->profile_website : "",
                    'profile_about' => !empty($request->profile_about) ? $request->profile_about : "",
                    'profile_banner' => empty($path_banner) ? '' : $path_banner,
                    'profile_type' => $request->profile_type,
                    'profile_status' => $request->profile_status,
                    'firbase_token' => !empty($request->firbase_token) ? $request->firbase_token : "",
                ];

                $userprofile = UserProfile::Create($data);
                // store data in Profiles either socail or buisness
                if (!empty($request->interest)) {
                    foreach ($request->interest as $interest) {
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
                        $category_selected['category_id'] = $category_id;
                        $category_selected['user_profile_id'] = $userprofile->id;
                        $category_selected['user_id'] = $request->user_id;
                        $result_data = UserProfileCategory::Create($category_selected);
                    }

                }
                if ($request->profile_type == "business") {
                    /* ======send a welcome email=======*/
                    $detail =[
                        'body' => "Thanks",
                        'message' => "Thanks for creating your business profile $request->profile_name. We are very excited to have you on our Platform. Its time to explore interesting features of business we offer to build next generation business community. Please feel free to reach us by email if you have any questions. We will be happy to help you and answer your questions.",
                    ];
                    Mail::to($request->profile_email)->send(new BusinessCreation($detail));
                    /* ======send a welcome email=======*/
                }

                DB::commit();
                $transformeProfile = Transformer::transformProfile($userprofile);
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformeProfile);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'user not found');
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
    /**
     *  get all Countries
     * @param Request $request
     * @return mixed
     */
    public function allCountries(Request $request)
    {

        try {
            $countries = Country::all();
            return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $countries);
        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
    /**
     *  get all hash tag
     * @param Request $request
     * @return mixed
     */
    public function hashTagList()
    {

        try {
            $hashtag = HashTag::all();
            return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $hashtag);
        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
    /**
     *  get all hash tag
     * @param Request $request
     * @return mixed
     */
    public function gettopics()
    {

        try {
            $topics = Topic::all();
            return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $topics);
        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     *  get all Cities
     * @param Request $request
     * @return mixed
     */
    public function allCities($id)
    {

        try {
            $country = Country::find($id);
            if ($country){
                $countries = Country::whereId($id)->whereHas('cities')->with(['cities'])->orderBy('name', 'asc')->first();
                $transformed_cities = Transformer::transformCities($countries->cities);
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_cities);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Country not found');
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     *  get all Counts of all profiles
     * @param Request $request
     * @return mixed
     */
    public function profilesCount($id)
    {
        try {
            $user = User::find($id);
            if ($user){
                $social_count = UserProfile::whereUserId($id)->whereProfileIsSuspend('false')->whereProfileType('social')->select('id','profile_name','profile_type','profile_status','profile_image','notification_status','firbase_token')->get();
                $buisness_count = UserProfile::whereUserId($id)->whereProfileIsSuspend('false')->whereProfileType('business')->select('id','profile_name','profile_type','profile_status','profile_image','notification_status','firbase_token')->get();
                $transformed_count = Transformer::transformProfilesCount($social_count,$buisness_count);
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_count);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'user not found');
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
    /**
     *  get all Categories
     * @param Request $request
     * @return mixed
     */
    public function CategoriesList()
    {

        try {
            $category['category'] = Category::whereStatus('publish')->get();
            // all hashtag
            $category['hashtag'] = HashTag::all();
            // all topics
            $category['topics'] = Topic::all();

            return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $category);

        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     *  get all user interested Category
     * @param Request $request
     * @return mixed
     */
    public function userInterestedCategoryList($id)
    {

        try {
            $profile = UserProfile::find($id);
            if ($profile){
                $ccategories = UserProfile::whereId($id)->whereHas('userCategories')->with(['userCategories'])->first();

                $transformed_cities = Transformer::transformUserInterest($ccategories->userCategories);
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_cities);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
    /**
     *  Edit user profile
     * @param Request $request
     * @return mixed
     */
    public function editUserProfile(Request $request,$id)
    {

        $interestRequest = New EditUserInterestRequest();
        $validator = Validator::make($request->all(), $interestRequest->rules(),$interestRequest->messages());

        if ($validator->fails()) {
            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', $validator->errors());
        }

        try {
            DB::beginTransaction();
            $user = User::whereId($request->user_id)->whereNull('deleted_at')->first();
            if ($user) {
                $userprofile = UserProfile::find($id);
                if ($userprofile) {
                    $path = $userprofile->profile_image;
                    if ($request->profile_image) {
                        $req = json_decode(file_get_contents("php://input"));

                        if ($req->profile_image) {
                            $image_parts = explode(";base64,", $req->profile_image);
                            $image_type_aux = explode("image/", $image_parts[0]);

                            $image_type = $image_type_aux[1];

                            $image_base64 = base64_decode($image_parts[1]);
                            $path = 'profiles/' . uniqid() . '.' . $image_type;
                            //$path = 'profiles/' . uniqid() . '.' . $image_type;
                            UpdateJsonImageAllSizes($image_base64, 'profiles/',$path , $userprofile->profile_image);
                            //Storage::disk('s3')->put($path, $image_base64);
                        }
                    }

                    $data = [
                        'user_id' => !empty($request->user_id) ? $request->user_id : $userprofile->user_id,
                        'country_id' => !empty($request->country_id) ? $request->country_id : $userprofile->country_id,
                        'city_id' => !empty($request->city_id) ? $request->city_id : $userprofile->city_id,
                        'profile_name' => !empty($request->profile_name) ? $request->profile_name : $userprofile->profile_name,
                        'profile_email' => !empty($request->profile_email) ? $request->profile_email : $userprofile->profile_email,
                        'profile_image' => !empty($path) ? $path : $request->profile_image,
                        'profile_phone' => !empty($request->profile_phone) ? $request->profile_phone : $userprofile->profile_phone,
                        'profile_address' => !empty($request->profile_address) ? $request->profile_address : $userprofile->profile_address,
                        'profile_website' => !empty($request->profile_website) ? $request->profile_website : $userprofile->profile_website,
                        'profile_about' => !empty($request->profile_about) ? $request->profile_about : $userprofile->profile_about,
                        //'profile_type' => !empty($request->profile_type) ? $request->profile_type : $userprofile->profile_type,
                        'profile_status' => !empty($request->profile_status) ? $request->profile_status : $userprofile->profile_status,
                        'firbase_token' => !empty($request->firbase_token) ? $request->firbase_token : $userprofile->firbase_token,
                    ];
                    UserProfile::whereId($id)->update($data);
                    if (!empty($request->removedItems)) {
                        foreach ($request->removedItems as $interest) {
                            $category_count = UserProfileCategory::whereCategoryId($interest)->whereUserProfileId($id)->first();
                            if ($category_count){
                                $category_count = UserProfileCategory::whereCategoryId($interest)->whereUserProfileId($id)->delete();
                            }
                        }
                    }
                    if (!empty($request->interest)) {
                        foreach ($request->interest as $interest) {
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
                            $category_count = UserProfileCategory::whereCategoryId($category_id)->whereUserProfileId($id)->first();
                            if ($category_count){
                                $userprofile = $category_count;
                            } else {
                                $category_selected['category_id'] = $category_id;
                                $category_selected['user_profile_id'] = $id;
                                $category_selected['user_id'] = $request->user_id;
                                $userprofile = UserProfileCategory::Create($category_selected);
                            }
                        }
                    }
                    DB::commit();
                    $profile = UserProfile::whereId($id)->first();
                    $transformed_posts = Transformer::transformUpdateProfile($profile);
                    return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_posts);
                } else {
                    return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
                }
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User not found');
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
    /**
     *  update user info
     * @param Request $request
     * @return mixed
     */
    public function updateUser(Request $request,$id)
    {

        $interestRequest = New UpdateUserRequest();
        $validator = Validator::make($request->all(), $interestRequest->rules(),$interestRequest->messages());

        if ($validator->fails()) {
            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', $validator->errors());
        }
        try {
            DB::beginTransaction();
            $user = User::whereId($id)->whereNull('deleted_at')->first();
            if ($user) {
                $data = [
                    'country_id' => !empty($request->country_id) ? $request->country_id : $user->country_id,
                    'city_id' => !empty($request->city_id) ? $request->city_id : $user->city_id,
                    'name' => !empty($request->name) ? $request->name : $user->name,
                    'password' => empty($request->password) ? $user->password : bcrypt($request->password),
                    'device_id' => !empty($request->device_id) ? $request->device_id : $user->device_id,
                    'gender' => !empty($request->gender) ? $request->gender : $user->gender,
                    'date_of_birth' => !empty($request->date_of_birth) ? $request->date_of_birth : $user->date_of_birth,
                    'org_password' => !empty($request->password) ? $request->password : $user->org_password,
                    'address' => !empty($request->address) ? $request->address : $user->address,
                    'about' => !empty($request->about) ? $request->about : $user->about,
                    'device_token' => !empty($request->device_token) ? $request->device_token : $user->device_token,
                    'latitude' => !empty($request->latitude) ? $request->latitude : $user->latitude,
                    'longitude' => !empty($request->longitude) ? $request->longitude : $user->longitude,
                ];
                User::whereId($id)->update($data);
                DB::commit();
                return $this->apiResponse(JsonResponse::HTTP_OK, 'message', 'success: Record updated');
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User not found');
            }
        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     *  view Buisnes Profile
     * @param Request $request
     * @return mixed
     */
    public function profileDetail($id)
    {
        try {
            $profile = UserProfile::whereId($id)->whereProfileIsSuspend('false')->first();
            if ($profile) {
                $data = UserProfile::whereId($id)->whereProfileIsSuspend('false')
                    ->whereHas('userCategories')
                    ->with(['userCategories','city','country'])->first();
                $transformed_posts = Transformer::transformProfileDetail($data);
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
     *  add user topic
     * @param Request $request
     * @return mixed
     */
    public function AddTpic(Request $request,$id)
    {

        $topicRequest = New AddTopicRequest();
        $validator = Validator::make($request->all(), $topicRequest->rules(),$topicRequest->messages());

        if ($validator->fails()) {
            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', $validator->errors());
        }

        try {
            DB::beginTransaction();

            if (!empty($request->topics)) {
                foreach ($request->topics as $topic) {
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

                    $topic_selected['topic_id'] = $topic_id;
                    $topic_selected['user_profile_id'] = $id;
                    $topic_selected['user_id'] = $request->user_id;
                    $result_data = UserTopic::Create($topic_selected);
                }

            }
            DB::commit();
            return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $result_data);
        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
    /**
     *  get all user user topic
     * @param Request $request
     * @return mixed
     */
    public function getUserTopics($id)
    {

        try {
            $profile = UserProfile::find($id);
            if ($profile){
                $ccategories = UserProfile::whereId($id)->whereHas('topics')->with(['topics'])->first();
                $transformed_cities = Transformer::transformUserTopics($ccategories->topics);
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_cities);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
    /**
     *  Follow Some one profile
     * @param Request $request
     * @return mixed
     */
    public function followProfile(Request $request,$id)
    {
        $followRequest = New FollowRequest();
        $validator = Validator::make($request->all(), $followRequest->rules(),$followRequest->messages());

        if ($validator->fails()) {
            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', $validator->errors());
        }
        try {
            $userprofile = UserProfile::find($id);
            if ($userprofile){
                $follow_to = UserProfile::find($request->follow_to);
                if ($follow_to) {
                    $data = [
                        'follow_by_id' => $id,
                        'follow_to_id' => $request->follow_to,
                    ];
                    $following = Follower::whereFollowById($id)->whereFollowToId($request->follow_to)->first();
                    if ($following) {
                        return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', 'You are already following');
                    }
                    $result = Follower::Create($data);
                    if ($result) {
                        $title = "Congrats! New follower";
                        $message_body = $userprofile->profile_name. " have followed you ";
                        $action = "Show_that_profile";
                        $action_key = $id;
                        $uniq_key = uniqid();
                        $body = [
                            'message' => $message_body,
                            'action' => $action,
                            'action_key' => $action_key,
                            'uniq_key' => $uniq_key,
                        ];
                        $this->getNotificationDetail($id,$request->follow_to,$title,$body);
                    }
                    return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $result);
                } else {
                    return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Profile not found');
                }

            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'user profile not found');
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
    /**
     *  unFollow Some one profile
     * @param Request $request
     * @return mixed
     */
    public function unFollowProfile($follow_by_id,$follow_to_id)
    {
        try {
            $userprofile = UserProfile::find($follow_by_id);
            if ($userprofile){
                $follow_to = UserProfile::find($follow_to_id);
                if ($follow_to) {
                    $following = Follower::whereFollowById($follow_by_id)->whereFollowToId($follow_to_id)->first();
                    if (empty($following)) {
                        return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', 'You are already not following');
                    }
                    $following = Follower::whereFollowById($follow_by_id)->whereFollowToId($follow_to_id)->delete();
                    return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $following);
                } else {
                    return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Profile not found');
                }

            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'user profile not found');
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
    /**
     *  get all Posts
     * @param Request $request
     * @return mixed
     */
    public function getAllUserProfilePost($id)
    {
        try {
            $status = !empty($request->profile_status) ? $request->profile_status : 'public';
            $type = !empty(request('type')) ? request('type') : "";
            $limit = !empty(request('limit')) ? request('limit') : 10;
            $profile = UserProfile::whereId($id)->whereProfileIsSuspend('false')/*->whereProfileStatus($status)->whereProfileType($type)*/->first();
            if ($profile) {
                $posts = Post::whereUserProfileId($id)->whereHas('postImage', function ($qry) {
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
                if (request('category_id')) {
                    if (!empty(request('category_id'))) {
                        $posts = $posts->whereHas('postCategories', function ($query) {
                            $query->where('categories.id',  request('category_id'));
                        })->with(['postCategories']);
                    }
                }
                $post_data = $posts->paginate($limit);
                $meta = Transformer::transformCollection($post_data,$type);
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
     *  update user info
     * @param Request $request
     * @return mixed
     */
    public function updatNotificationStatus(Request $request,$id)
    {
        try {
            DB::beginTransaction();
            $user = UserProfile::find($id);
            if ($user) {
                $data = [
                    'notification_status' => !empty($request->notification_status) ? $request->notification_status : $user->country_id,
                ];
                $user->update($data);
                DB::commit();
                return $this->apiResponse(JsonResponse::HTTP_OK, 'message', 'success: Record updated successfully');
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User not found');
            }
        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     *  update user info
     * @param Request $request
     * @return mixed
     */
    public function unsubProfile(Request $request,$id)
    {
        try {
            DB::beginTransaction();
            $user = UserProfile::find($id);
            if ($user) {
                if ($user->profile_is_suspend == "true"){
                    $data = [
                        'profile_email' => str_replace('unsub_', '', $user->profile_email),
                        'profile_is_suspend' => 'false',
                    ];
                } else {
                    $data = [
                        'profile_email' => 'unsub_' . $user->profile_email,
                        'profile_is_suspend' => 'true',
                    ];
                }
                $user->update($data);
                $user_data = UserProfile::whereId($id)->first()->profile_is_suspend;
                /* ======send a email=======*/
                $detail =[
                    'body' => "Thanks",
                    'name' => "Hy ".$user->profile_name,
                    'message' => "We will miss you... Its sad you are leaving us. If you are unhappy with App please spend a moment to tell us reason via email. We are committed to improve it as quick as possible. We hope to see you in future.",
                ];
                Mail::to(\request('email'))->send(new Unsubcribe($detail));
                /* ======send a email=======*/
                DB::commit();
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $user_data);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User not found');
            }
        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
    /**
     *  get all user user topic
     * @param Request $request
     * @return mixed
     */
    public function getNotification($id)
    {

        try {
            $profile = UserProfile::find($id);
            if ($profile){
                $notification = PushNotificationToUser::whereUserProfileId($id)->whereHas('pushNotification',function ($query) {
                    $query->whereStatus('sent');
                })->with(['pushNotification'])->get();
                $transformed_notification = Transformer::transformPushNotification($notification);
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_notification);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     *  get all user user topic
     * @param Request $request
     * @return mixed
     */
    public function getFollowers($id)
    {

        try {
            $profile = UserProfile::find($id);
            if ($profile){
                $followers = UserProfile::whereId($id)->whereProfileIsSuspend('false')->whereHas('followers')->with(['followers'])->first();
                //$following = UserProfile::whereId($id)->whereProfileIsSuspend('false')->whereHas('following')->with(['following'])->first();
                $transformed_notification = Transformer::transformfollowers($followers->followers);
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_notification);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     *  get all user user topic
     * @param Request $request
     * @return mixed
     */
    public function getFollowing($id)
    {

        try {
            $profile = UserProfile::find($id);
            if ($profile){
                $following = UserProfile::whereId($id)->whereProfileIsSuspend('false')->whereHas('following')->with(['following'])->first();
                $transformed_notification = Transformer::transformfollowers($following->following);
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_notification);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     *  Follow Some one profile
     * @param Request $request
     * @return mixed
     */
    public function privateProfileFollow(Request $request,$id,$private_id)
    {
        try {
            $userprofile = UserProfile::find($id);
            if ($userprofile){
                $private_user = UserProfile::find($private_id);
                if ($private_user) {
                    $data = [
                        'requested_profile' => $id,
                        'private_profile' => $private_id,
                        'status' => 'pending',
                    ];
                    $rst = PrivateProfile::whereRequestedProfile($id)->wherePrivateProfile($private_id)->first();

                    if ($rst) {
                        if ($rst->status == "pending") {
                            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', 'You are already requested');
                        } elseif ($rst->status == "accepted") {
                            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', 'Your request already accepted');
                        } else {
                            $rst->update($data);
                            $title = "A new follower request";
                            $message_body = $userprofile->profile_name. " is requesting to follow you ";
                            $action = "Show_that_profile";
                            $action_key = $id;
                            $uniq_key = uniqid();
                            $body = [
                                'message' => $message_body,
                                'action' => $action,
                                'action_key' => $action_key,
                                'uniq_key' => $uniq_key,
                            ];
                            $this->getNotificationDetail($id,$private_id,$title,$body);
                            return $this->apiResponse(JsonResponse::HTTP_OK, 'message', 'Your requested successfully sent');
                        }
                    }
                    $result = PrivateProfile::Create($data);
                    $title = "A new follower request";
                    $message_body = $userprofile->profile_name. " is requesting to follow you ";
                    $action = "Show_that_profile";
                    $action_key = $id;
                    $uniq_key = uniqid();
                    $body = [
                        'message' => $message_body,
                        'action' => $action,
                        'action_key' => $action_key,
                        'uniq_key' => $uniq_key,
                    ];
                    $this->getNotificationDetail($id,$private_id,$title,$body);
                    return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $result);
                } else {
                    return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
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
     *  get all user user topic
     * @param Request $request
     * @return mixed
     */
    public function getRequestedProfiles($id)
    {

        try {
            $profile = UserProfile::find($id);
            if ($profile){
                $followers = UserProfile::whereId($id)->whereProfileIsSuspend('false')->whereHas('requestedByProfile')->with(['requestedByProfile'])->first();
                $transformed_notification = Transformer::transformRequestedfollowers($followers->requestedByProfile);
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_notification);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     *  Follow Some one profile
     * @param Request $request
     * @return mixed
     */
    public function acceptFollowingRequest(Request $request,$id,$private_id)
    {
        try {
            $userprofile = UserProfile::find($id);
            if ($userprofile){
                $private_user = UserProfile::find($private_id);
                if ($private_user) {
                    $rst = PrivateProfile::whereRequestedProfile($private_id)->wherePrivateProfile($id)->first();
                    if ($rst) {
                        $data = [
                            'status' => $request->status,
                        ];
                        $rst->update($data);
                        if (isset($request->status) && $request->status === "accepted") {
                            $title = "Congrats! Your follow request is approved";
                            $message_body = "You can now see details of ".$userprofile->profile_name;
                            $action = "Show_that_profile";
                            $action_key = $id;
                            $uniq_key = uniqid();
                            $body = [
                                'message' => $message_body,
                                'action' => $action,
                                'action_key' => $action_key,
                                'uniq_key' => $uniq_key,
                            ];
                            $this->getNotificationDetail($id,$private_id,$title,$body);
                        } elseif (isset($request->status) && $request->status === "rejected"){
                            $title = "Sorry! Your follow request is denied";
                            $message_body = "You can try again in future";
                            $action = "Show_that_profile";
                            $action_key = $id;
                            $uniq_key = uniqid();
                            $body = [
                                'message' => $message_body,
                                'action' => $action,
                                'action_key' => $action_key,
                                'uniq_key' => $uniq_key,
                            ];
                            $this->getNotificationDetail($id,$private_id,$title,$body);
                        }
                        return $this->apiResponse(JsonResponse::HTTP_OK, 'message', 'Your requested has been updated');
                    } else {
                        return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'Record not found');
                    }
                } else {
                    return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found');
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
