<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ExtrasController;
use App\Http\Controllers\Auth\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');*/
Route::get('/', function () {
    return redirect(route('login'));
});
    Route::get('/dashboard', function () {
        if (Auth::user() &&  Auth::user()->user_type == "admin") {
            return redirect(route('admindashboard'));
        } else {
            return redirect(route('home'));
        }
    });
    Route::get('/home', function () {
        if (Auth::user() &&  Auth::user()->user_type == "admin") {
            return redirect(route('admindashboard'));
        } else {
            return redirect(route('home'));
        }
    });
    Route::get('/admin', function () {
        if (Auth::user() &&  Auth::user()->user_type == "admin") {
            return redirect(route('admindashboard'));
        } else {
            return redirect(route('home'));
        }
    });
    Route::get('/', function () {
        if (Auth::user() &&  Auth::user()->user_type == "admin") {
            return redirect(route('admindashboard'));
        } else {
            return redirect(route('home'));
        }
    });
    Route::get('/marketer', function () {
        if (Auth::user() &&  Auth::user()->user_type == "admin") {
            return redirect(route('admindashboard'));
        } else {
            return redirect(route('home'));
        }
    });

Route::get('/recover-password', function () {
    return view('auth.forgotpassword');
});
Route::get('notification', [ExtrasController::class, 'testNotification'])->name('test.notification');
Route::get('/reset-password', [ResetPasswordController::class, 'sendRecoverEmail'])->name('resetpass');
Auth::routes();
Route::group(['middleware' => ['auth', 'marketer'], 'prefix' => 'marketer'], function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home');
    Route::get('/profile', [HomeController::class, 'editProfile'])->name('edit.profile');
    Route::post('/update', [HomeController::class, 'updateProfile'])->name('update.profile');
    Route::get('/marketing', [HomeController::class, 'marketing'])->name('marketer.marketing');
    Route::get('/add/detail/{id}', [HomeController::class, 'addDetail'])->name('add.detail');
    Route::get('/create/add', [HomeController::class, 'createAdd'])->name('create.add');
    Route::post('/mach/audience', [HomeController::class, 'machAudience'])->name('audience');
    Route::post('/create/save', [HomeController::class, 'saveAdd'])->name('save.add');
    Route::post('/status/update/{id}', [HomeController::class, 'addStatusUpdate'])->name('addstatus.update');
    #-------------------- marketer routes add by WOL-17------------------------------#
    Route::get('/buycredits'  , [HomeController::class, 'buycreditslist'])->name('buyredits');
    Route::get('/selectedpackage/{id}', [HomeController::class, 'selectedpackage'])->name('selected.package');
    Route::get('/cancelpayfastrequest'  , [HomeController::class, 'cancelpayfastcreditrequest'])->name('payfast.cancel');
    Route::get('/notify'  , [HomeController::class, 'notifypayfast']);
    Route::get('/transactions', [HomeController::class, 'usertransactions'])->name('transactions');
    Route::get('/transactiondetail/{id}', [HomeController::class, 'transactiondetail'])->name('transaction-detail');
    Route::get('under-construction', [HomeController::class, 'underConstrut'])->name('under-cons');
});
// admin
Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin'], function () {
    Route::get('dashboard', [AdminController::class, 'index'])->name('admindashboard');
    Route::get('profile', [AdminController::class, 'edit'])->name('admin.edi.profile');
    Route::put('suspend/user/{id}', [AdminController::class, 'suspendUser'])->name('suspend.user');
    Route::put('suspend/profile/{id}', [AdminController::class, 'suspendProfile'])->name('suspend.profile');
    Route::post('profile', [AdminController::class, 'updateProfile'])->name('admin.update.profile');
    Route::get('payment', [AdminController::class, 'getSetting'])->name('setting');
    Route::post('payment', [AdminController::class, 'paymentSettingUpdate'])->name('admin.payment.update');
    Route::get('about-us', [AdminController::class, 'aboutUs'])->name('aboutus');
    Route::post('aboutus', [AdminController::class, 'aboutUsUpdate'])->name('aboutusupdate');
    Route::post('aboutus/images', [AdminController::class, 'aboutUsImagesUpdate'])->name('aboutusuimages');
    Route::post('/aboutus/status/{id}', [AdminController::class, 'aboutUsStatusUpdate'])->name('aboutstatus.update');
    #-------------------------- admin routes added by WOL-17-------------------------------#
    Route::get('marketing', [AdminController:: class, 'getMarketing'])->name('marketing');
    Route::post('update-marketing', [AdminController::class, 'updateMarketing'])->name('admin.update.marketing');
    Route::get('termsandconditions',[AdminController::class, 'gettermsandcondition'])->name('termsandconditions');
    Route::post('update-terms', [AdminController::class, 'updateTerms'])->name('admin.update.terms');
    Route::get('privacy-policy',[AdminController::class, 'getPrivacyPolicy'])->name('privacy');
    Route::post('update-privacy', [AdminController::class, 'updatePrivacy'])->name('admin.update.privacy');
    Route::get('signup-terms',[AdminController::class, 'getSignupTerms'])->name('signupterms');
    Route::post('update-signup-terms', [AdminController::class, 'updateSignUpTerms'])->name('admin.update.signupterms');
    Route::get('packages', [AdminController::class, 'packageslist'] )->name('admin.packages');
    Route::post('update-package', [AdminController::class, 'updatePackage'])->name('admin.package.update');
    Route::get('credit-logs',[AdminController::class, 'getUsersCreditLogs'])->name('allcreditlogs');
    Route::get('creditdetail/{id}', [AdminController::class, 'particularCreditDetail'])->name('selected.creditdetail');
    Route::get('all-transactions',[AdminController::class, 'getAllTransactions'])->name('alluserstransactions');
    Route::get('selectedtransactiondetail/{id}', [AdminController::class, 'particularTransactionDetail'])->name('selected.transactiondetail');
//Route::get('selectedusercreditlog/{id}', [AdminController::class, 'particularUserCreditLog'])->name('selected.usercreditlog');
    Route::get('users', [AdminController::class, 'getUsers'])->name('alluser');
    Route::get('userdetail/{id}', [AdminController::class, 'particularUserDetail'])->name('selected.userdetail');
    Route::get('all-pushnotifications',[AdminController::class, 'getAllPushNotifications'])->name('allpushnotifications');
    Route::get('notification/detail/{id}',[AdminController::class, 'notificationDetail'])->name('notification.detail');
    Route::get('notification/update/{id}',[AdminController::class, 'notificationStatusEdit'])->name('notification.status');
    Route::get('add-pushnotifications',[AdminController::class, 'createPushNotification'])->name('createpushnotification');
    Route::post('generate-push-notification', [AdminController::class, 'generatePushNotification'])->name('admin.generate.pushnotification');
    Route::get('under-construction', [AdminController::class, 'underConstruction'])->name('underconstruction');
    Route::get('allmarketing', [AdminController::class, 'allMarketing'])->name('all.marketing');
    Route::get('marketing/detail/{id}', [AdminController::class, 'marketingDetail'])->name('marketing.detail');
    Route::post('marketing/status/update/{id}', [AdminController::class, 'marketingAddStatusUpdate'])->name('marketingstatus.update');
    Route::get('income', [AdminController::class, 'income'])->name('income');
    Route::get('analytics/marketing', [AdminController::class, 'analyticMarketing'])->name('analytics.marketing');
    Route::get('income/export', [AdminController::class, 'incomeExport'])->name('income.export');
    Route::get('marketing/export', [AdminController::class, 'marketingCompaignExport'])->name('marketing.export');
    Route::get('user/compaign', [AdminController::class, 'getCompaign'])->name('user.compaign');
    Route::get('marketing/compaign', [AdminController::class, 'marketingCompaign'])->name('marketing.compaign');
    //extras route here
    Route::group(['prefix' => 'extras'], function () {
        Route::get('interest', [ExtrasController::class, 'categories'])->name('cat_list');
        Route::get('interest/edit/{id}', [ExtrasController::class, 'interestedit'])->name('cat_edit');
        Route::get('interest/create', [ExtrasController::class, 'categoryCreate'])->name('cat_create');
        Route::post('interest/update/{id}', [ExtrasController::class, 'categoryUpdate'])->name('cat_update');
        Route::get('interest/delete/{id}', [ExtrasController::class, 'categorydelete'])->name('cat_delete');
        Route::post('interest/save', [ExtrasController::class, 'categorySave'])->name('cat_save');
        Route::get('advertise', [ExtrasController::class, 'advertise'])->name('advertise');
        Route::post('advertise/Save', [ExtrasController::class, 'advertiseSave'])->name('adsave');
        Route::get('topic', [ExtrasController::class, 'topics'])->name('topic_list');
        Route::get('topic/create', [ExtrasController::class, 'topicCreate'])->name('topic_create');
        Route::post('topic/save', [ExtrasController::class, 'topicSave'])->name('topic_save');
        Route::get('topic/edit/{id}', [ExtrasController::class, 'topicEdit'])->name('topic_edit');
        Route::post('topic/update/{id}', [ExtrasController::class, 'topicUpdate'])->name('topic_update');
        Route::get('topic/delete/{id}', [ExtrasController::class, 'topicDelete'])->name('topic_delete');
    });
});

