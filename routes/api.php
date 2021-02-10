<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PostController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('countries', [UserController::class, 'allCountries']);
Route::get('cities/{id}', [UserController::class, 'allCities']);
Route::get('categories', [UserController::class, 'CategoriesList']);
Route::get('topics', [UserController::class, 'gettopics']);
Route::get('hashtag', [UserController::class, 'hashTagList']);
Route::post('register', [AuthController::class, 'register']);
Route::post('reg', [AuthController::class, 'reg']);
Route::post('login', [AuthController::class, 'login']);
Route::post('forgot_password', [AuthController::class, 'forgotPassword']);
Route::post('code-verify', [AuthController::class, 'codeVerify']);
Route::post('update_password', [AuthController::class, 'updatePassword']);
Route::post('user/{id}/post/reporting/{post_id}', [PostController::class, 'postReporting']);
Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'user'], function () {
    Route::put('update/{id}', [UserController::class, 'updateUser']);
    Route::post('create/profile', [UserController::class, 'store']);
    Route::get('profilescount/{id}', [UserController::class, 'profilesCount']);
    Route::get('{id}/interested/categories', [UserController::class, 'userInterestedCategoryList']);
    Route::put('profile/edit/{id}', [UserController::class, 'editUserProfile']);
    Route::get('profile/detail/{id}', [UserController::class, 'profileDetail']);
    Route::post('{id}/add/topics', [UserController::class, 'AddTpic']);
    Route::get('{id}/get/topics', [UserController::class, 'getUserTopics']);
    Route::post('{id}/creat/post', [PostController::class, 'store']);
    Route::post('{id}/edit/post/{post_id}', [PostController::class, 'update']);
    Route::post('{id}/video/{post_id}', [PostController::class, 'storeVideo']);
    Route::post('{id}/edit/video/{post_id}', [PostController::class, 'updateVideo']);
    Route::post('{id}/post/comment', [PostController::class, 'storeComment']);
    Route::post('{id}/post/activities', [PostController::class, 'postActivities']);
    Route::patch('{id}/post/dislike', [PostController::class, 'postDislike']);
    Route::get('{id}/post/delete/{post_id}', [PostController::class, 'deletePost']);
    Route::post('{id}/comment/like', [PostController::class, 'commentLike']);
    Route::get('{id}/friends', [HomeController::class, 'getAllFriends']);
    Route::post('{id}/follow', [UserController::class, 'followProfile']);
    Route::get('{id}/unfollow/{following_id}', [UserController::class, 'unFollowProfile']);
    Route::get('{id}/view/socialprofile/private', [HomeController::class, 'viewSocialProfilePrivate']);
    Route::get('{id}/view/buisness/profile', [HomeController::class, 'viewBuisnessProfile']);
    Route::get('{id}/suggested/friends', [HomeController::class, 'getSuggestedFriends']);
    Route::get('{id}/posts', [HomeController::class, 'getAllPost']);
    Route::get('{id}/post/{post_id}', [HomeController::class, 'postDetail']);
    Route::post('{id}/post/view/{post_id}', [HomeController::class, 'postView']);
    Route::get('{id}/view/adds', [HomeController::class, 'viewAdds']);
    Route::get('{id}/adds/activities', [HomeController::class, 'addsActivities']);
    Route::post('{id}/add/view/{add_id}', [HomeController::class, 'addImpression']);
    Route::get('{id}/userposts', [UserController::class, 'getAllUserProfilePost']);
    Route::put('{id}/notification/status', [UserController::class, 'updatNotificationStatus']);
    Route::put('{id}/unsub', [UserController::class, 'unsubProfile']);
    Route::get('{id}/notification', [UserController::class, 'getNotification']);
    Route::get('{id}/followers', [UserController::class, 'getFollowers']);
    Route::get('{id}/following', [UserController::class, 'getFollowing']);
    Route::get('{id}/category/post', [HomeController::class, 'getCatPost']);
    Route::post('{id}/private/follow/{private_profile}', [UserController::class, 'privateProfileFollow']);
    Route::get('{id}/requested/profiles', [UserController::class, 'getRequestedProfiles']);
    Route::put('{id}/accept/following/requesst/{private_profile}', [UserController::class, 'acceptFollowingRequest']);
});
Route::group(['middleware' => ['auth:sanctum'], ], function () {
    Route::get('about/us', [HomeController::class, 'sideBar']);
    Route::get('advertise', [HomeController::class, 'advertiseWithUs']);
    Route::get('sendnotification', [HomeController::class, 'sendNotification']);
});
