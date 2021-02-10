<?php

namespace App\Http\Controllers\Api;
use App\Http\Requests\LoginRequest;
use App\Mail\ForgotPasseord;
use App\Mail\PasswordResetSuccess;
use App\Mail\WelComeMail;
use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Traits\Transformer;
use Matrix\Exception;
use Spatie\Permission\Traits\HasRoles;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UserProfileCategory;
class AuthController extends Controller
{
    /**
     *  Register new user
     * @param Request $request
     * @return mixed
     */
    public function register(Request $request)
    {

        $RegisterRequest = New RegisterRequest;
        $validator = Validator::make($request->all(), $RegisterRequest->rules(),$RegisterRequest->messages());

        if ($validator->fails()) {
            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', $validator->errors());
        }

        try {
            DB::beginTransaction();
            $path = "profiles/default.png";
            $data = [
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => empty($request->password) ? '' : Hash::make($request->password),
                'user_type' => "user",
                'device_id' => $request->device_type,
                'profile_photo_path' => $path,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'org_password' => $request->password,
                'address' => $request->address,
                'about' => $request->about,
                'device_token' => $request->device_token,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ];
            $role = "User";
            $user = User::Create($data);
            $user->syncRoles([$role]);
            $token = $user->createToken('token')->plainTextToken;
            // store data in Profiles either socail or buisness
            DB::commit();
            $data = ['message' => "Successfully Added"];
            $userprofile = UserProfile::whereUserId($user->id)->whereProfileIsSuspend('false')->whereProfileType('social')->first();
            $user = User::whereId($user->id)->with('city','country')->first();
            /* ======send a welcome email=======*/
            $detail =[
                'body' => "Thanks",
                'name' => "Hy ".$user->name,
                'message' => "We are very excited to have you on AppOne. Its time to explore interesting features we offer to build next generation community. Please feel free to reach us by email if you have any questions. We will be happy to help you and answer your questions.",
            ];
            Mail::to($request->email)->send(new WelComeMail($detail));
            /* ======send a welcome email=======*/
            $transformed_user = Transformer::transformUser($user,$userprofile, $token, true);
            return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_user);
        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
    /**
     *  reg new user
     * @param Request $request
     * @return mixed
     */
    public function reg(Request $request)
    {
        $RegisterRequest = New RegisterRequest;
        $validator = Validator::make($request->all(), $RegisterRequest->rules(),$RegisterRequest->messages());

        if ($validator->fails()) {
            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', $validator->errors());
        }
        try {
            DB::beginTransaction();
            $path = "profiles/default.png";
            if ($request->profile_image) {
                $req = json_decode(file_get_contents("php://input"));

                if ($req->profile_image) {
                    $image_parts = explode(";base64,", $req->profile_image);
                    $image_type_aux = explode("image/", $image_parts[0]);

                    $image_type = $image_type_aux[1];

                    $image_base64 = base64_decode($image_parts[1]);
                    $path = 'profiles/' . uniqid() . '.' . $image_type;
                    Storage::disk('local')->put($path, $image_base64);
                }
            }
            if ($request->image) {
                $req = json_decode(file_get_contents("php://input"));

                if ($req->image) {
                    $image_parts = explode(";base64,", $req->image);
                    $image_type_aux = explode("image/", $image_parts[0]);

                    $image_type = $image_type_aux[1];

                    $image_base64 = base64_decode($image_parts[1]);
                    $image_path = 'posts/' . uniqid() . '.' . $image_type;
                    Storage::disk('s3')->put($image_path, $image_base64);
                }
            }
            $data = [
                'country_id' => $request->country_id,
                'city_id' => $request->city_id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => empty($request->password) ? '' : Hash($request->password),
                'user_type' => "user",
                'device_id' => $request->device_type,
                'profile_photo_path' => $path,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'org_password' => $request->password,
                'address' => $request->address,
                'about' => $request->about,
                'device_token' => $request->device_token,
            ];
            $role = "User";
            $user = User::Create($data);
            $user->syncRoles([$role]);
            $token = $user->createToken('token')->plainTextToken;
            // store data in Profiles either socail or buisness
            if ($request->profile_type){
                $profiledata = [
                    'country_id' => $request->country_id,
                    'city_id' => $request->city_id,
                    'user_id' => $user->id,
                    'profile_name' => $request->profile_name,
                    'profile_email' => $request->profile_email,
                    'profile_image' => $path,
                    'profile_phone' => $request->profile_phone,
                    'profile_address' => $request->profile_address,
                    'profile_website' => $request->profile_website,
                    'profile_about' => $request->profile_about,
                    'profile_banner' => $request->profile_banner,
                    'profile_type' => $request->profile_type,
                ];
                $user_profile = UserProfile::Create($profiledata);
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

                    $category_selected['category_id'] = $category_id;
                    $category_selected['user_profile_id'] = $user_profile->id;
                    $category_selected['user_id'] = $user->id;
                    $result_data = UserProfileCategory::Create($category_selected);
                }
            }
            DB::commit();
            $data = ['message' => "Successfully Added"];
            $transformed_user = Transformer::transformUser($user_profile,$user, $token, true);
            return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_user);
        } catch ( \Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
    /**
     *  Login user
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {

        $loginRequest = New LoginRequest;
        $validator = Validator::make($request->all(), $loginRequest->rules(),$loginRequest->messages());

        if ($validator->fails()) {
            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', $validator->errors());
        }

        try {
            DB::beginTransaction();

            $credentials = [
                'email' => $request->email, 'password' => $request->password,
                'is_active' => 'true'
            ];
            if (auth()->attempt($credentials)) {
                $user = User::where('email', $request->email)->whereUserType($request->user_type)->first();
                if (empty($user)) {
                    return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User name or password is incorrect For the doctor');
                }
                $token = $user->createToken('token')->plainTextToken;
                $data = [
                    'device_token' => !empty($request->device_key) ? $request->device_key : $user->device_token,
                ];
                $user->update($data);
                $userprofile = UserProfile::whereUserId($user->id)->whereProfileIsSuspend('false')->whereProfileType('social')->with('city','country')->first();
                $user = User::whereId($user->id)->with('city','country')->first();
                $transformed_user = Transformer::transformUser($user, $userprofile,$token, true);
                $response = $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_user);
                DB::commit();
            } else {
                $response = $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'User name or password is incorrect');
            }
            return $response;

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }
    /**
     * Update password of current user
     * @return JsonResponse
     */
    public function updatePassword()
    {
        $validator = Validator::make(request()->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', $validator->errors());
        }
        try {
            $user = User::whereEmail(\request('email'))->first();
            if ($user) {
                DB::beginTransaction();
                $user->update(['password' => bcrypt(request('password')),'org_password' => request('password')]);
                /* ======send a welcome email=======*/
                $detail =[
                    'body' => "Thanks",
                    'name' => "Hy ".$user->name,
                    'message' => "Password has been successfully changed, you can now access your account with new password you have just changed. If this operation is not done by you, please reach our support via email for help.",
                ];
                Mail::to(\request('email'))->send(new PasswordResetSuccess($detail));
                /* ======send a welcome email=======*/
                DB::commit();
                return $this->apiResponse(JsonResponse::HTTP_OK, 'message', 'Your password has been updated');
            } else {
                return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', "Email or verification code is incorrect");
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->apiResponse(JsonResponse::HTTP_INTERNAL_SERVER_ERROR, 'message', $e->getMessage());
        }
    }

    /**
     *  Send forgot password email to user
     * @return JsonResponse
     */
    public function forgotPassword(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', $validator->errors());
        }
        $check_email = User::whereEmail($request->email)->first();
        if ($check_email) {
            $detail =[
                'body' => rand(111111,999999),
                'name' => $check_email->name,
                'message' => "Please use following code to reset your password for AppOne account. If you havent requested to confirmation code for changing password, Ignore this message.",
            ];
            $user = User::whereEmail($request->email)->update(['two_factor_recovery_codes' => $detail['body']]);
            Mail::to($request->email)->send(new ForgotPasseord($detail));
            return $this->apiResponse(JsonResponse::HTTP_OK, 'message', 'A recovery email has been sent on your email.');

        } else {
            return $this->apiResponse(JsonResponse::HTTP_NOT_FOUND, 'message', 'email not found.');
        }

    }

    /**
     *  verify code
     * @return JsonResponse
     */
    public function codeVerify(Request $request)
    {

        $validator = Validator::make(request()->all(), [
            'email' => 'required',
            'code' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->apiResponse(JsonResponse::HTTP_UNPROCESSABLE_ENTITY, 'message', $validator->errors());
        }
        $check_data = User::whereEmail($request->email)->whereTwoFactorRecoveryCodes($request->code)->first();
        if ($check_data) {
            $transformed_verifyData = Transformer::transformRecoverPassword($check_data);
            return $this->apiResponse(JsonResponse::HTTP_OK, 'data', $transformed_verifyData);
        } else {
            return $this->apiResponse(JsonResponse::HTTP_OK, 'message', 'your code is incorrect.');
        }
    }
}
