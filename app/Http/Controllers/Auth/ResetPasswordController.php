<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ForgotPasseord;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function sendRecoverEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);
        $user = User::whereEmail($request->email)->first();
        if ($user) {
            $detail =['body' => rand(111111,999999)];
            $data_terms = [
                'password' => bcrypt($detail['body']),
                'org_password' => $detail['body'],
                'two_factor_recovery_codes' => $detail['body'],
            ];
            $user->update($data_terms);
            Mail::to($request->email)->send(new ForgotPasseord($detail));
            return redirect(route('login'))->with('success', 'New Password has been sent to your email.');
        } else {
            return Redirect::back()->withErrors(['Please enter a valid email address.']);
        }

    }
    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
}
