<?php

namespace App\Http\Controllers;

use App\Exports\IncomeExport;
use App\Exports\IncomeExportView;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\AboutUsImage;
use App\Models\AddImpresssion;
use App\Models\AddsMarketing;
use App\Models\CmsSideBar;
use App\Models\MarketerPackage;
use App\Models\Package;
use App\Models\PayFastCredential;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserTransaction;
use App\Traits\Transformer;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use App\Models\PushNotification;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Vimeo\Laravel\Facades\Vimeo;
use App\Models\CmsType;
class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        #-------------------- for transactions----------------------------------#
        $last_24Hours_Transaction = UserTransaction::where('created_at', '>=', \Carbon\Carbon::now()->subDay())->count();
        $last_7_Days_Transaction = UserTransaction::where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->count();
        $life_Time_Transactions = UserTransaction::count();

        #---------------------------- for users-----------------------------------------#
        $last_24Hours_users = User::whereUserType('user')->where('created_at', '>=', \Carbon\Carbon::now()->subDay())->count();
        $last_7_Days_users = User::whereUserType('user')->where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->count();
        $life_Time_users = User::whereUserType('user')->count();
        #---------------------------- for business-----------------------------------------#
        $last_24Hours_Business = UserProfile::whereProfileType('business')->where('created_at', '>=', \Carbon\Carbon::now()->subDay())->count();
        $last_7_Days_Business = UserProfile::whereProfileType('business')->where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->count();
        $life_Time_Business = UserProfile::whereProfileType('business')->count();
        #---------------------------- for Posts-----------------------------------------#
        $last_24Hours_Post = Post::where('created_at', '>=', \Carbon\Carbon::now()->subDay())->count();
        $last_7_Days_Post = Post::where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->count();
        $life_Time_Post = Post::count();
        #---------------------------- for Comments-----------------------------------------#
        $last_24Hours_Comments = PostComment::where('created_at', '>=', \Carbon\Carbon::now()->subDay())->count();
        $last_7_Days_Comments = PostComment::where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->count();
        $life_Time_Comments = PostComment::count();
        #---------------------------- for Adds Marketing-----------------------------------------#
        $last_24Hours_Adds = AddsMarketing::where('created_at', '>=', \Carbon\Carbon::now()->subDay())->count();
        $last_7_Days_Adds = AddsMarketing::where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->count();
        $life_Time_Adds = AddsMarketing::count();
        #---------------------------- for Adds Impressions-----------------------------------------#
        $last_24Hours_AddImpression = AddImpresssion::where('created_at', '>=', \Carbon\Carbon::now()->subDay())->count();
        $last_7_Days_AddImpression = AddImpresssion::where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->count();
        $life_Time_AddImpression = AddImpresssion::count();


        return view('admin.dashboard',
            [
                'last_24Hours_Transaction' => $last_24Hours_Transaction,
                'last_7_Days_Transaction' =>$last_7_Days_Transaction,
                'life_Time_Transactions' =>$life_Time_Transactions,
                'last_24Hours_users' => $last_24Hours_users,
                'last_7_Days_users' =>$last_7_Days_users,
                'life_Time_users' =>$life_Time_users,
                'last_24Hours_Business' => $last_24Hours_Business,
                'last_7_Days_Business' =>$last_7_Days_Business,
                'life_Time_Business' => $life_Time_Business,
                'last_24Hours_Post' => $last_24Hours_Post,
                'last_7_Days_Post' => $last_7_Days_Post,
                'life_Time_Post' => $life_Time_Post,
                'last_24Hours_Comments' => $last_24Hours_Comments,
                'last_7_Days_Comments' => $last_7_Days_Comments,
                'life_Time_Comments' => $life_Time_Comments,
                'last_24Hours_Adds' => $last_24Hours_Adds,
                'last_7_Days_Adds' => $last_7_Days_Adds,
                'life_Time_Adds' => $life_Time_Adds,
                'last_24Hours_AddImpression' => $last_24Hours_AddImpression,
                'last_7_Days_AddImpression' => $last_7_Days_AddImpression,
                'life_Time_AddImpression' => $life_Time_AddImpression,
            ]);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function edit()
    {
        $user = User::find(Auth::user()->id);
        return view('admin.home.profile', compact('user'));
    }
    /**
     * Update Admin Profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);
        if(!empty($request->Password)){
            $validated = $request->validate([
                'password_confirmation' => 'required|same:Password',
            ]);
        }
        DB::beginTransaction();
        $id = Auth::user()->id;
        $user = User::find($id);

        if ($user){
            if ($request->hasFile('profile_pic')){
                UpdateImageAllSizes($request, 'profiles/', $user->profile_photo_path);
                //$path = Storage::disk('s3')->put('profiles', $request->file('profile_pic'));
                $path = 'profiles/'.$request->profile_pic->hashName();
            }
            $data = [
                'name' => $request->name,
                'password' => !empty($request->Password) ? bcrypt($request->Password) : $user->password,
                'profile_photo_path' => !empty($path) ? $path : $user->profile_photo_path,
            ];
            $user->update($data);
            DB::commit();
            $user = User::find($id);
            return redirect(route('admin.edi.profile', $user))->with('success', 'Profile updated successfully.');
        }
        return redirect(route('admin.edi.profile'))->with('error', 'Profile not updated successfully.');
    }

    /**
     * Payment Seeting.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function paymentSettingUpdate(Request $request)
    {
        $validated = $request->validate([
            'merchant_id' => 'required',
            'merchant_key' => 'required',
        ]);
        DB::beginTransaction();
        $setting = PayFastCredential::find($request->id);
        if ($setting){
            $data_setting = [
                'merchant_id' => !empty($request->merchant_id) ? $request->merchant_id : $setting->merchant_id,
                'merchant_key' => !empty($request->merchant_key) ? $request->merchant_key : $setting->merchant_key,
            ];
            $setting->update($data_setting);
            DB::commit();
            return redirect(route('setting'))->with('success', 'Payment API keys successfully updated.');
        }
        return redirect(route('setting'))->with('error', 'Please enter both fields correctly.');
    }

    /**
     * Payment Seeting.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function suspendUser(Request $request)
    {
        try {
            $find_use = User::find($request->id);
            if ($find_use) {
                DB::beginTransaction();
                if ($find_use->is_active == "false"){
                    $user_data = [
                        'email' => str_replace('unsub_', '', $find_use->email),
                        'is_active' => 'true',
                    ];
                } else {
                    $user_data = [
                        'email' => 'unsub_'.$find_use->email,
                        'is_active' => 'false',
                    ];
                }

                //$find_use->restore();
                $find_use->update($user_data);
                $profiles = $find_use->whereHas('profiles')->with('profiles')->first();
                if ($profiles->profiles){
                    foreach ($profiles->profiles as $profile){
                        if ($profiles->is_active == "false") {
                            if ($profile->profile_is_suspend == 'false'){
                                $email = 'unsub_' . $profile->profile_email;
                            } else{
                                $email = $profile->profile_email;
                                //$email = str_replace('unsub_', '', $profile->profile_email);
                            }
                            $profile_data = [
                                'profile_email' => $email,
                                'profile_is_suspend' => 'true',
                            ];
                        } else {
                            $profile_data = [
                                'profile_email' => str_replace('unsub_', '', $profile->profile_email),
                                'profile_is_suspend' => 'false',
                            ];
                        }
                        $profile->update($profile_data);
                    }
                }
                $getdata = User::find($request->id);
                DB::commit();
                $transformed_user = Transformer::transformSuspendUser($getdata, null,null, true);
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_user);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }

    }
    /**
     * Suspend Profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function suspendProfile(Request $request)
    {

        try {
            $find_use = UserProfile::find($request->id);
            if ($find_use) {
                DB::beginTransaction();
                if ($find_use->profile_is_suspend == "true"){
                    $user_data = [
                        'profile_email' => str_replace('unsub_', '', $find_use->profile_email),
                        'profile_is_suspend' => 'false',
                    ];
                } else {
                    $user_data = [
                        'profile_email' => 'unsub_' . $find_use->profile_email,
                        'profile_is_suspend' => 'true',
                    ];
                }

                //$find_use->restore();
                $find_use->update($user_data);
                $find_use = UserProfile::find($request->id);
                DB::commit();
                return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $find_use);
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User profile not found.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }

    }
    /**
     * Payment Seeting.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getSetting(Request $request)
    {
        $data = PayFastCredential::whereUserId(Auth::user()->id)->first();
        return view('admin.home.payment', compact('data'));
    }
    #------------------------- Code added by ahsan from 23-12-20-----------------------------#
    function getMarketing()
    {
        $marketing = DB::table('cms_types')->where('cms_side_bar_id', '5')->first();
        return view('admin.cms.marketing', ['marketing' => $marketing]);
    }
    function updateMarketing(Request $request)
    {
        $validated = $request->validate([
            'marketing' => 'required',

        ]);
        $id=$request->recordid;
        $terms = CmsType::find($id);
        DB::beginTransaction();
        $data_marketing = [
            'content' => $request->marketing,
        ];
        $terms->update($data_marketing);
        DB::commit();
        return redirect(route('marketing'))->with('success', 'Record updated successfully.');

    }
    function gettermsandcondition()
    {
        $terms = DB::table('cms_types')->where('cms_side_bar_id', '3')->first();
        return view('admin.cms.termsandcondition', ['terms' => $terms]);
    }
    function updateTerms(Request $request)
    {
        $validated = $request->validate([
            'termconditions' => 'required',

        ]);
        $id=$request->recordid;
        $terms = CmsType::find($id);
        DB::beginTransaction();
        $data_terms = [
            'content' => $request->termconditions,
        ];
        $terms->update($data_terms);
        DB::commit();
        return redirect(route('termsandconditions'))->with('success', 'Record updated successfully.');
        //dd($request);
    }
    function getPrivacyPolicy()
    {
        $privacy = DB::table('cms_types')->where('cms_side_bar_id', '2')->first();
        return view('admin.cms.privacypolicy', ['privacy' => $privacy]);

    }
    function updatePrivacy(Request $request)
    {
        $validated = $request->validate([
            'privacypolicy' => 'required',

        ]);
        $id=$request->recordid;
        $privacy = CmsType::find($id);
        DB::beginTransaction();
        $data_privacy = [
            'content' => $request->privacypolicy,
        ];
        $privacy->update($data_privacy);
        DB::commit();
        return redirect(route('privacy'))->with('success', 'Record has been updated.');

    }
    function getSignupTerms()
    {
        $signUpTerms = DB::table('cms_types')->where('id', '4')->first();
        return view('admin.cms.signupterms', ['signUpTerms' => $signUpTerms]);

    }
    function updateSignUpTerms(Request $request)
    {
        $validated = $request->validate([
            'signUpTerms' => 'required',

        ]);
        $id=$request->recordid;
        $signup = CmsType::find($id);
        DB::beginTransaction();
        $data_signup = [
            'content' => $request->signUpTerms,
        ];
        $signup->update($data_signup);
        DB::commit();
        return redirect(route('signupterms'))->with('success', 'Record has been updated.');
    }
    function packageslist()
    {
        $allPackages=Package::all();
        return view('admin.packages.packageseditpage', ['allPackages' => $allPackages]);
    }
    function updatePackage(Request $request)
    {
        $validated = $request->validate([
            'name' =>    'required',
            'credits' => 'required|numeric',
            'price'   => 'required|numeric'

        ]);
        $id=$request->recordid;
        DB::beginTransaction();
        $data_package = [
            'name'    =>   $request->name,
            'credits' =>   $request->credits,
            'price'   =>   $request->price
        ];
        $package = Package::find($id);
        $package->update($data_package);
        DB::commit();
        return redirect(route('admin.packages'))->with('success', 'Package Information has been updated.');
    }
    function getUsersCreditLogs()
    {
        $keword = \request('keyword');
        $date = \request('date');
        $allCreditLog = UserTransaction::creditLog($keword)->dateFilter($date)->whereHas('user')->with(['user' => function ($query){
            $query->select('users.id','name');
        }])->paginate(10);
        return view('admin.credits.creditlogslist',  ['allCreditLog' => $allCreditLog]);
    }
    function particularCreditDetail($userid)
    {

        try {
            $find_use = User::find($userid);
            if ($find_use) {
                $userTransactions = UserTransaction::whereUserId($userid)->whereHas('user')->orderBy('id', 'desc')->take(3)->get();
                $userDetail = User::whereId($userid)->whereHas('profiles')->withcount('profiles')->first();
                $userBuiseness = User::whereId($userid)->whereHas('profiles', function ($query) {
                    $query->whereProfileType('business')->whereProfileIsSuspend('false');
                })->withcount('profiles')->first();
                $marketing_compaign = AddsMarketing::whereUserId($userid)->withcount('addImpressions')->orderBy('id', 'desc')->take(3)->get();
                $cureent_credits = User::whereId($userid)->whereHas('trasanction')->withCount(['trasanction as credits' => function ($sub_qury) {
                    $sub_qury->select(DB::raw("SUM(credits) as total_credits"));
                }])->withCount('addImpression')->first();
                return view('admin.credits.creditlofofspecificuser',compact('userTransactions','userDetail','marketing_compaign','cureent_credits','userBuiseness'));
            } else {
                return redirect(route('allcreditlogs'))->with('error', 'Sorry record not found.');            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }
    }
    function getAllTransactions()
    {
        try {
            $keword = \request('keyword');
            $date = \request('date');
            $allTransactions = UserTransaction::search($keword)->dateFilter($date)->whereHas('user')->with(['user'=> function ($query){
                $query->select('users.id','name');
            }])->paginate(10);
            return view('admin.transactions.transactionlists', compact('allTransactions'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }
    }
    function particularTransactionDetail($id)
    {
        try {
            $data = UserTransaction::find($id);
            if ($data) {
                $selectedUserTransactions = UserTransaction::whereId($id)->whereHas('user')->with(['user'=> function ($sub_query) {
                    $sub_query->select('users.id','name','profile_photo_path','created_at');
                }])->first();
                return view('admin.transactions.specifictransaction', compact('selectedUserTransactions'));
            } else {
                return Redirect::back()->withErrors(['error', 'Sorry Record not found']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }
    }
    /**
     * User detail here.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function particularUserDetail($id)
    {
        try {
            $check = User::find($id);
            if ($check) {
                $user_info = User::whereId($id)->whereHas('city')->with('country','city')->whereHas('profiles')->with('profiles',function ($query){
                    $query->withCount('following');
                    $query->withCount('followers');
                    $query->withCount('posts');
                    $query->withCount('postcomment');
                    $query->with('userCategories');
                    $query->with('city');
                    $query->with('country');
                    $query->withcount(['postlike as like_count' => function ($query) {
                        $query->where('is_like', 'true');
                    }]);
                    $query->withcount(['postfile as image_count' => function ($query) {
                        $query->whereNull('video');
                    }, 'postfile as video_count' => function ($query) {
                        $query->whereNotNull('video');
                    }]);
                })->first();
                return view('admin.user.detail', compact('user_info'));
            } else {
                return Redirect::back()->withErrors(['error', 'Sorry Record not found.']);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }
    }

    /**
     * Show the marketing Add Detail.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function notificationDetail($id)
    {
        try {
            $data = PushNotification::whereId($id)->first();
            if ($data) {
                return view('admin.pushnotifications.pushnotificationsdetail', compact('data'));
            } else {
                return Redirect::back()->withErrors(['error', 'Sorry Record not found.']);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }
    }
    /**
     *  update user info
     * @param Request $request
     * @return mixed
     */
    public function notificationStatusEdit(Request $request,$id)
    {

        try {
            DB::beginTransaction();
            $data = PushNotification::whereId($id)->first();
            if ($data) {
                $notification_data = [
                    'status' => "cancelled",
                ];
                PushNotification::whereId($id)->update($notification_data);
                DB::commit();
                return redirect(route('notification.detail',$id))->with('success', 'Push notification has been successfully cancelled.');
            } else {
                return Redirect::back()->withErrors(['error', 'Sorry Record not found.']);
            }
        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['error', 'Sorry Record not found.']);
        }
    }
    #------------------------- code by WOL-17 on Dec 28, 2020----------------------------#
    function getAllPushNotifications()
    {
        $pushNotification = PushNotification::all();
        return view('admin.pushnotifications.pushnotificationslist',compact('pushNotification'));
    }
    function createPushNotification()
    {

        $age = User::max('date_of_birth');
        $diff = !empty($age) ? date('Y') - date('Y',strtotime($age)) : 0;
        return view('admin.pushnotifications.createpushnotification',compact('diff'));

    }
    function generatePushNotification(Request $request)
    {
        $validated = $request->validate([
            'gender' =>    'required',
            'title'    =>'required',
            'message'  =>'required',
            'send'     =>'required'
        ]);

        $data = $request->input();
        //dd($request);
        $pushNotification = new PushNotification;
        if ($data['send']=='1') {
            $pushNotification->gender = $data['gender'];
            $pushNotification->age_from = $data['range_from'];
            $pushNotification->age_to = $data['range_to'];
            //$pushNotification->location = $data['location'];
            //$pushNotification->radius = $data['radius'];
            $pushNotification->titile = $data['title'];
            $pushNotification->message = $data['message'];
            $pushNotification->send_now = $data['send'];
            $pushNotification->status = 'sent';
            $pushNotification->save();
            #--------------------send push notification to all users------------------------#
            $from = \Carbon\Carbon::now()->subYears($request->range_from)->format('Y-m-d');
            $to = Carbon::now()->subYears($request->range_to)->format('Y-m-d');
            $user = User::select('id','name','email','user_type','gender','date_of_birth','device_token')
                ->whereUserType('user')->whereGender($request->gender)->whereBetween('date_of_birth', [$to,$from])->get();
            if (!empty($user)) {
            $title = $request->title;
            $message_body = $request->message;
            $action = "Show_that_profile";
            $uniq_key = uniqid();
                foreach($user as $row) {
                    $action_key = $row->id;
                    $body = [
                        'message' => $message_body,
                        'action' => $action,
                        'action_key' => $action_key,
                        'uniq_key' => $uniq_key,
                    ];
                    sendFireBaseNotification($row->device_token, $title,$body);
                }
            }
        }
        else{
            $today = date('Y-m-d');
            if((($request->scheduleat == $today) && ($request->appt  <=date("h:i")))) {
                return redirect(route('allpushnotifications'))->with('error', 'Time should be greater than current time.');
            }
            $pushNotification->gender = $data['gender'];
            $pushNotification->age_from = $data['range_from'];
            $pushNotification->age_to = $data['range_to'];
            // $pushNotification->location = $data['location'];
            // $pushNotification->radius = $data['radius'];
            $pushNotification->titile = $data['title'];
            $pushNotification->message = $data['message'];
            $pushNotification->send_now = $data['send'];
            $pushNotification->schedule_date_time = $data['scheduleat'];
            $pushNotification->time = $data['appt'];
            $pushNotification->status = 'pending';
            $pushNotification->save();

        }

        if ($data['send']==1) {
            return redirect(route('allpushnotifications'))->with('success', 'Push Notification sent.');
        }
        else{
            return redirect(route('allpushnotifications'))->with('success', 'Push Notification scheduled.');
        }

    }
    /**
     * Show the marketing Add Detail.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function aboutUs()
    {
        try {
            $data = CmsSideBar::whereId(1)->whereHas('CmsTypes')->with('CmsTypes.CmsTypeImages')->first();
            if ($data) {
                $buisness_data = AboutUsImage::whereCmsTypeId($data->id)->whereToturialType('buisness')->get();
                return view('admin.cms.aboutus', compact('data','buisness_data'));
            } else {
                return Redirect::back()->withErrors(['error', 'Sorry Record not found.']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }
    }
    /**
     * Show the marketing Add Detail.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function aboutUsUpdate(Request $request)
    {
        $validated = $request->validate([
            'description' => 'required',
            //'videos' => 'required',
        ]);
        try {
            $data_exist = CmsType::whereCmsSideBarId($request->cms_side_bar_id)->first();
            if ($data_exist) {
                $input_data = [
                    'content'    =>   $request->description,
                ];
                $data_exist->update($input_data);

                return redirect(route('aboutus'))->with( 'success','About us content updated successfully.');
            } else {
                return Redirect::back()->withErrors(['Sorry Record not found.']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors( 'Sorry record not found.');
        }
    }

    /**
     * Show the marketing Add Detail.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function aboutUsImagesUpdate(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            //'video' => 'required',
        ]);
        try {
            $sidebar= CmsType::whereCmsSideBarId($request->cms_side_bar_id)->first();
            if ($sidebar) {

                if ($request->hasFile('video')) {
                    $vimeo = Vimeo::upload($request->file('video'),[
                        "name" => !empty($request->title) ? $request->title : "about-us video",
                        "description" => "This video for AppOne"
                    ]);
                    $videourl = str_replace('/videos/', '', $vimeo); //it contains vimeo id
                } else {
                    $videourl = $request->original_image;
                }
                $about_us = AboutUsImage::whereId($request->data_id)->first();

                if ($about_us) {
                    $update_data = [
                        'name'    =>   $request->title,
                        'toturial_type'    =>   $request->user_type,
                        'image'    =>   $videourl,
                        'status'    =>   $request->status,
                    ];
                    $about_us->update($update_data);
                } else {
                    $input_data = [
                        'cms_type_id '    =>   $request->cms_type_id ,
                        'name'    =>   $request->title,
                        'toturial_type'    =>   $request->user_type,
                        'image'    =>   $videourl,
                        'status'    =>   $request->status,
                    ];
                    AboutUsImage::create($input_data);
                }
                if ($request->user_type == "user") {
                    return redirect(route('aboutus'))->with( 'success','User content updated successfully.');
                } else {
                    return redirect(route('aboutus'))->with( 'success','Buisness content updated successfully.');
                }

            } else {
                return Redirect::back()->withErrors(['Sorry Record not found.']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors( 'Sorry record not found.');
        }
    }

    /**
     * Show the marketing Add Detail.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function aboutUsStatusUpdate(Request $request,$id)
    {
        try {
            $add_data = AboutUsImage::find($id);
            if ($add_data) {
                $input_data = [
                    'status'    =>   $request->status,
                ];
                $add_data->update($input_data);
                return $request->status;
            } else {
                return Redirect::back()->withErrors([ 'Sorry Record not found.']);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }
    }
    /**
     * Under Construction Page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function underConstruction()
    {
        try {
            return view('admin.underconstruction');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }
    }
    /**
     * all marketing.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function allMarketing()
    {
        try {
            $keword = \request('keyword');
            $date = \request('date');
            $data = AddsMarketing::search($keword)->dateFilter($date)->whereHas('user')
                ->with('user',function ($sub_query){
                    $sub_query->whereHas('packages');
                })->withcount('addImpressions')->orderBy('id', 'desc')->paginate(10);
            return view('admin.marketing.lists',compact('data'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }
    }
    /**
     * all income.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function income()
    {
        try {
            $max = \request('max_date');
            $min = \request('min_date');
            $data = UserTransaction::select(DB::raw("SUM(credits) as total_credits"),
                DB::raw('count(*) as trsaction_count'),DB::raw("SUM(amount) as total_amount"),
                DB::raw("SUM(fee) as total_fee"),'created_at'
            )->income($max,$min)->groupBy('created_at')->orderBy('created_at','desc')->get();
            if (\request('btnSubmit') === "Download") {
                return view('admin.home.income_sheet',compact('data'));
            } else {
                return view('admin.home.income',compact('data'));
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }
    }
    /**
     * all income.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function analyticMarketing()
    {
        try {
            $data = User::whereUserType('user')->whereIsActive('true')->get();
            return view('admin.home.analytics_marketing',compact('data'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }
    }
    /**
     * all income.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function getCompaign()
    {

        try {
            $data = AddsMarketing::whereUserId(\request('id'))->get();
            return $data;
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }
    }

    /**
     * all income.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function marketingCompaign()
    {

        try {
            $adds = AddsMarketing::whereId(\request('compaign'))->first();
            if ($adds) {
                $max = \request('max_date');
                $min = \request('min_date');
                $data = AddImpresssion::whereAddsMarketingId(\request('compaign'))->select('id','created_at')
                    ->selectRaw('count(*) as total')
                    ->selectRaw("count(case when sex = 'male' then 1 end) as male_impression")
                    ->selectRaw("count(case when sex = 'female' then 1 end) as female_impression")
                    ->selectRaw("count(case when sex = 'male' then 1 end) as male_impression")
                    ->selectRaw("count(case when sex = 'female' and is_click = 'true'  then 1 end) as female_click")
                    ->selectRaw("count(case when sex = 'male' and is_click = 'true'  then 1 end) as male_click")
                    ->selectRaw("count(case when is_click = 'true'  then 1 end) as total_click")
                    ->search($max,$min)->groupBy(DB::raw('Date(created_at)'))->orderby('created_at')->get();
                if (\request('btnSubmit') === "Download") {
                    return view('admin.home.marketing_sheet',compact('data'));
                } else {
                    return view('admin.home.marketing_compaign',compact('data'));
                }
            } else{
                return redirect(route('home'))->with('error', 'Sorry marketing record not found.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }
    }

    /**
     * all income export.
     *
     * @return \App\Exports\IncomeExport
     */
    function marketingCompaignExport()
    {

        //return Excel::download(new IncomeExportView(), 'income.xlsx');
        try {
            $max = \request('max_date');
            $min = \request('min_date');
            $data = AddImpresssion::whereAddsMarketingId(\request('compaign'))->select('id','created_at')
                ->selectRaw('count(*) as total')
                ->selectRaw("count(case when sex = 'male' then 1 end) as male_impression")
                ->selectRaw("count(case when sex = 'female' then 1 end) as female_impression")
                ->selectRaw("count(case when sex = 'male' then 1 end) as male_impression")
                ->selectRaw("count(case when sex = 'female' and is_click = 'true'  then 1 end) as female_click")
                ->selectRaw("count(case when sex = 'malemale' and is_click = 'true'  then 1 end) as male_click")
                ->selectRaw("count(case when is_click = 'true'  then 1 end) as total_click")
                ->search($max,$min)->groupBy(DB::raw('Date(created_at)'))->orderby('created_at')->get();
            //dd($data);
            return view('admin.home.income_sheet',compact('data'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }
    }
    /**
     * all income export.
     *
     * @return \App\Exports\IncomeExport
     */
    function incomeExport()
    {

        //return Excel::download(new IncomeExportView(), 'income.xlsx');
        try {
            $keword = \request('keyword');
            $date = \request('date');
            $data = UserTransaction::select(DB::raw("SUM(credits) as total_credits"),
                DB::raw('count(*) as trsaction_count'),DB::raw("SUM(amount) as total_amount"),
                DB::raw("SUM(fee) as total_fee"),'created_at'
            )->search($keword)->dateFilter($date)->groupBy('created_at')->orderBy('created_at','desc')->get();
            //dd($data);
            return view('admin.home.income_sheet',compact('data'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }
    }

    /**
     * all marketing.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function marketingDetail($id)
    {
        try {

            $data = AddsMarketing::whereId($id)->whereHas('user')->with('user',function ($sub_query){
                $sub_query->whereHas('trasanction')
                    ->withCount(['trasanction as credits' => function ($sub_qury) {
                        $sub_qury->select(DB::raw("SUM(credits) as total_credits"));
                    }]);
            })->withCount('addImpressions as totalcount')->first();
            return view('admin.marketing.detail', compact('data'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }
    }

    /**
     * Show the marketing Add Detail.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function marketingAddStatusUpdate(Request $request,$id)
    {
        try {
            $add_data = AddsMarketing::whereId($id)->first();
            if ($add_data) {
                $input_data = [
                    'status'    =>   $request->status,
                ];
                $add_data->update($input_data);
                return redirect(route('marketing.detail',$id))->with('success', 'Status updated successfully.');
            } else {
                return Redirect::back()->withErrors([ 'Sorry Record not found.']);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }
    }
    /**
     * all Users.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function getUsers()
    {

        try {
            $keword = \request('keyword');
            $date = \request('date');
            $data = User::search($keword)->dateFilter($date)->whereHas('profiles')->withCount(['profiles'=> function ($sub_query){
                $sub_query->whereProfileType('business');
            }])->paginate(10);
            if ($data) {
                return view('admin.user.list', compact('data'));
            } else {
                return Redirect::back()->withErrors(['error', 'Sorry Record not found.']);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }
    }

}
