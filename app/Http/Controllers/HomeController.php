<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCompaignRequest;
use App\Models\AddImpresssion;
use App\Models\AddsMarketing;
use App\Models\Package;
use App\Models\PayFastCredential;
use App\Models\Post;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserTransaction;
use App\Traits\Transformer;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Vimeo\Laravel\Facades\Vimeo;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
class HomeController extends Controller
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
        try {
            $adds_Ids = AddsMarketing::whereUserId(Auth::user()->id)->pluck('id');
            #---------------------------- for Adds Marketing-----------------------------------------#
            $last_24Hours_Adds = AddsMarketing::whereUserId(Auth::user()->id)->where('created_at', '>=', \Carbon\Carbon::now()->subDay())->count();
            $last_7_Days_Adds = AddsMarketing::whereUserId(Auth::user()->id)->where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->count();
            $life_Time_Adds = AddsMarketing::whereUserId(Auth::user()->id)->count();
            #---------------------------- for Adds Impressions-----------------------------------------#
            $last_24Hours_AddImpression = AddImpresssion::where('created_at', '>=', \Carbon\Carbon::now()->subDay())->whereIn('adds_marketing_id',$adds_Ids)->count();
            $last_7_Days_AddImpression = AddImpresssion::where('created_at', '>=', \Carbon\Carbon::today()->subDays(7))->whereIn('adds_marketing_id',$adds_Ids)->count();
            $life_Time_AddImpression = AddImpresssion::whereIn('adds_marketing_id',$adds_Ids)->count();
            return view('marketing.home.dashboard',[
                'last_24Hours_Adds' => $last_24Hours_Adds,
                'last_7_Days_Adds' => $last_7_Days_Adds,
                'life_Time_Adds' => $life_Time_Adds,
                'last_24Hours_AddImpression' => $last_24Hours_AddImpression,
                'last_7_Days_AddImpression' => $last_7_Days_AddImpression,
                'life_Time_AddImpression' => $life_Time_AddImpression,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editProfile()
    {
        $user = User::find(Auth::user()->id);
        return view('marketing.home.profile', compact('user'));
    }

    /**
     * Show the application dashboard.
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
        //dd($request);
        DB::beginTransaction();
        $user = User::find(Auth::user()->id);
        if ($user){
            if ($request->hasFile('profile_pic')){
                UpdateImageAllSizes($request, 'profiles/', $user->profile_photo_path);
                $path = 'profiles/'.$request->profile_pic->hashName();
                //$path = Storage::disk('s3')->put('profiles', $request->file('profile_pic'));
            }

            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => !empty($request->Password) ? bcrypt($request->Password) : $user->password,
                'profile_photo_path' => !empty($path) ? $path : $user->profile_photo_path,
            ];

            $user->update($data);
            DB::commit();
            $user = User::find(Auth::user()->id);
            return redirect(route('edit.profile', Auth::user()->id,$user))->with('success', 'Profile updated successfully.');
        }

        return redirect(route('edit.profile', Auth::user()->id))->with('error', 'Profile has not been updated.');

    }
    #-------------------------- code added by ahsan (Dec 19,2020)------------------------------------#
    /**
     * Buy credits here.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function buycreditslist()
    {
        $packages = Package::whereStatus('publish')->get();
        return view('marketing.credits.creditslistpage', ['packages' => $packages]);

    }
    /**
     * notify fast.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function notifypayfast()
    {
        //require( 'payfast_common.inc' );

// Notify PayFast that information has been received
        pflog( 'PayFast ITN call received' );
        dd('in here');
    }
    /**
     * Cancel Payfast Request method.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function cancelpayfastcreditrequest()
    {
        $packages = Package::whereStatus('publish')->get();
        return view('marketing.credits.creditslistpage', ['packages' => $packages]);
    }
    /**
     * Generate Signature here.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function generateSignature($data, $passPhrase = 'Starshare246') {
        // Create parameter string
        $pfOutput = '';
        foreach( $data as $key => $val ) {
            if(!empty($val)) {
                $pfOutput .= $key .'='. urlencode( trim( $val ) ) .'&';
            }
        }
        // Remove last ampersand
        $getString = substr( $pfOutput, 0, -1 );
        if(isset($passPhrase)) {
            $getString .= '&passphrase='. urlencode( trim( $passPhrase ) );
            //dd($getString);
        }
        return md5($getString);
    }
    /**
     * Select packge here.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function selectedpackage($id)
    {
        $package =  Package::whereId($id)->first();
        if ($package) {
            $admin = PayFastCredential::find(1);
            #--------------Calculate Payfast fee--------------------------------------#
            $packageamount=$package->price;
            $basicPercentForadmin=($packageamount/100)*(3.5);
            $add2Percent=($basicPercentForadmin)+(2);
            $fifteenPercentofAdd=(15/100)*($add2Percent);//0.48
            $payfastTaxAmount=($fifteenPercentofAdd)+($add2Percent);//10
            $finalAmountGetFromCustomer=($payfastTaxAmount)+($packageamount);//216
            #------------------------ get payfast details------------------------------#
            $data = array(
                // Merchant details
//            'merchant_id' => '10015469',
//            'merchant_key' => '67owpmi6bsi1d',
                'merchant_id' => $admin->merchant_id,
                'merchant_key' => $admin->merchant_key,
                'return_url' => route('transactions'),
                'cancel_url' => route('payfast.cancel'),
//                'notify_url' => URL::to('/').'/payfast/notify.php',
                'notify_url' => 'https://breakhot.com/payfast/notify.php',
                // Buyer details
                'name_first' => Auth()->user()->name,
                'email_address'=> Auth()->user()->email,
                // Transaction details
                'm_payment_id' => rand(10,100000), //Unique payment ID to pass through to notify_url
                'amount' => number_format( sprintf( '%.2f', $finalAmountGetFromCustomer ), 2, '.', '' ),
                'item_name' => 'Buy Credits',
                'item_description' => 'Buy Credits For AppOne Marketer',
                'custom_int1' => $package->id,
                'custom_int2' => $package->credits,
                'custom_int3' => Auth()->user()->id,
                'custom_int5' => $packageamount,
                'custom_str1' => $payfastTaxAmount,
                'custom_str2' => $package->name,
                //'payment_method' => 'cc'
            );
            $signature = $this->generateSignature($data);
            $data['signature'] = $signature;
            return view('marketing.credits.selectedpackagedetail', ['package' => $package,'customerAmount' =>$finalAmountGetFromCustomer,'data'=>$data]);
        } else {
            return Redirect::back()->withErrors(['error', 'Sorry Record not found.']);
        }

    }
    /**
     * Select Transtaction here.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function usertransactions()
    {
        $keword = \request('keyword');
        $date = \request('date');
        $userid = Auth()->user()->id;
        $transactions = UserTransaction::whereUserId($userid)->search($keword)->dateFilter($date)->paginate(10);
        return view('marketing.transactions.transactionlistpage', ['transactions' => $transactions]);

    }
    /**
     * Select Transtaction detail here.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    function transactiondetail($id)
    {
        $transactions = UserTransaction::find($id);
        return view('marketing.transactions.transactiondetail', ['transactions' => $transactions]);
    }
    /**
     * Show the marketing Adds.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function marketing()
    {
        try {
            $keword = \request('keyword');
            $date = \request('date');
            $data = AddsMarketing::whereUserId(Auth()->user()->id)->search($keword)->dateFilter($date)->withCount('addImpressions as totalcount')->orderBy('id', 'desc')->paginate(10);
            return view('marketing.adds.contentList', compact('data'));
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
    public function addDetail($id)
    {
        try {
            $data = AddsMarketing::whereId($id)->whereUserId(Auth::user()->id)->withCount('addImpressions as totalcount')->first();
            if ($data) {
                return view('marketing.adds.addView', compact('data'));
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
    public function addStatusUpdate(Request $request,$id)
    {
        try {
            $add_data = AddsMarketing::whereId($id)->whereUserId(Auth::user()->id)->first();
            if ($add_data) {
                $input_data = [
                    'status'    =>   $request->status,
                ];
                $add_data->update($input_data);
                return redirect(route('add.detail',$id))->with('success', 'Status updated successfully.');
            } else {
                return Redirect::back()->withErrors([ 'Sorry Record not found.']);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }
    }

    /**
     * Show the marketing Add creation.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function createAdd(Request $request)
    {

        try {
            $user =  Auth::user()->trasanction->sum('credits');
            $impression = 0;
            if ($user) {
                $impression_count = AddsMarketing::whereUserId(Auth::user()->id)->pluck('id');
                if ($impression_count){
                    $impression = AddImpresssion::whereIn('adds_marketing_id',$impression_count)->count();
                }
                if ($impression >= $user) {

                    return Redirect::back()->withErrors(['error', 'Sorry you have no more credits.']);

                }
                $data = AddsMarketing::withCount('addImpressions as totalcount')->first();
                $age = User::max('date_of_birth');
                $diff = !empty($age) ? date('Y') - date('Y',strtotime($age)) : 0;
                return view('marketing.adds.create', compact('data','diff'));
            } else {
                return Redirect::back()->withErrors(['Please buy package. You dont have credits to create Advertisement.']);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }
    }

    /**
     * Show the marketing Add creation.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function machAudience(Request $request)
    {

        try {
            $today = date('Y-m-d');
            //$request->Age_from   $request->Age_to
            $from = Carbon::now()->subYears($request->Age_from)->format('Y-m-d');
            $to = Carbon::now()->subYears($request->Age_to)->format('Y-m-d');
            $data = User::select("id", "gender", "address", "latitude", "longitude", 'date_of_birth'
                ,DB::raw("6371 * acos(cos(radians(" . \request('latitude') . "))
		        * cos(radians(latitude))
		        * cos(radians(longitude) - radians(" . \request('longitude') . "))
		        + sin(radians(" .\request('latitude'). "))
		        * sin(radians(latitude))) AS distance"))
                ->having("distance", "<=",\request('radius'))
                ->whereIsActive('true')
                ->whereUserType('user')
                //->whereBetween('date_of_birth', [$from, $to])
                ->where(function ($query) use($from,$to){
                    $query->where('date_of_birth','>=',$from)
                        ->orWhere('date_of_birth','<=',$to)
                        ->orWhereNull('date_of_birth');
                })
                //->where('date_of_birth','>=',$from)
                //->where('date_of_birth','<=',$to)
                ->where(function ($query) {
                    $query->where('gender', \request('Gender'))
                        ->orWhereNull('gender');
                })
                ->get();
            $count = 0;
            if ($data) {
                $count = count($data);
            }
            return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $count);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }
    }

    /**
     * Show the marketing Add creation.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function saveAdd(AddCompaignRequest $request)
    {
        try {
            DB::beginTransaction();
            if ($request->file() && !empty($request->file('bannerupload'))){
                SaveBannerAllSizes($request, 'banner/');
                $path = 'banner/'.$request->bannerupload->hashName();
                //$path = Storage::disk('s3')->put('banner', $request->file('bannerupload'));
            }
            if ($request->file() && !empty($request->file('videoupload'))){
                $vimeo = Vimeo::upload($request->file('videoupload'));
                $videourl = str_replace('/videos/', '', $vimeo); //it contains vimeo id
            }
            $max = AddsMarketing::max('add_number');
            $data = [
                'user_id' => Auth::user()->id,
                'name' => $request->Name,
                'add_number' => $max + 1,
                'add_date' => !empty($request->AddDate) ? date("Y-m-d", strtotime($request->AddDate)) : date("Y-m-d"),
                'video' => !empty($videourl) ? $videourl : "",
                'banner' => !empty($path) ? $path : "default.png",
                'description' => $request->Description,
                'gender' => $request->Gender,
                'age_from' => $request->Age_from,
                'age_to' => $request->Age_to,
                'location' => $request->Location,
                'radious' => $request->radius,
                'impressions' => !empty($request->multipleImpressions) ? $request->multipleImpressions : $request->UniqueImpressions,
                'funds_to' => $request->Fund_to,
                'end_date' => !empty($request->Endondate) ? $request->Endondate : "",
                'end_on_budget_end' => !empty($request->Endondate) ? "" : $request->Endoncebudgetends,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ];
            //dd($data);
            AddsMarketing::create($data);
            DB::commit();
            return redirect(route('marketer.marketing'))->with('success', 'Advertisement has been succesfully created.');
        } catch (\Exception $e) {
            DB::rollBack();
            return Redirect::back()->with('error', 'There is some error with server.');

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
     * Under Construction Page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function underConstrut()
    {
        try {
            return view('marketing.underconstruction');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->with('error', 'Sorry record not found.');
        }
    }
}
