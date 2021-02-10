<?php

namespace App\Http\Controllers;

use App\Models\AddsMarketing;
use App\Models\AdveriseWithUs;
use App\Models\Category;
use App\Models\CmsSideBar;
use App\Models\PushNotification;
use App\Models\Topic;
use App\Models\User;
use App\Models\UserTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Vimeo\Laravel\Facades\Vimeo;

class ExtrasController extends Controller
{
    /**
     * category List.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function categories()
    {
        try {
            $keword = \request('keyword');
            $date = \request('date');
            $data = Category::search($keword)->dateFilter($date)->whereNull('deleted_at')
                ->withCount('userProfilesCategories as count')->orderBy('id','desc')->paginate(10);
            if ($data) {
                return view('admin.extras.categories.list', compact('data'));
            } else {
                return Redirect::back()->withErrors(['Sorry Record not found.']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors('Sorry record not found.');
        }
    }
    /**
     * Interest Detail.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function interestedit($id)
    {
        try {
            $data = Category::find($id);
            if ($data) {
                return view('admin.extras.categories.detail', compact('data'));
            } else {
                return Redirect::back()->withErrors(['Sorry Record not found']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors('Sorry record not found.');
        }
    }
    /**
     * category create.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function categoryCreate()
    {
        try {
            return view('admin.extras.categories.create');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors('Sorry record not found.');
        }
    }
    /**
     *  Save category
     * @param Request $request
     * @return mixed
     */
    public function categorySave(Request $request)
    {
        $validated = $request->validate([
            'name' => 'unique:categories',
        ]);

        if($request->hasFile('image')){
            SaveImageAllSizes($request, 'advertise/');
            $path = 'advertise/'.$request->image->hashName();
        }
        try {
            DB::beginTransaction();
            $cat_data = [
                'name' => $request->name,
                'status' => $request->status,
                'image' => !empty($path) ? $path : "",
            ];
            Category::create($cat_data);
            DB::commit();
            return redirect(route('cat_list'))->with('success', 'Interest added successfully.');

        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['server error']);
        }
    }

    /**
     *  Save category
     * @param Request $request
     * @return mixed
     */
    public function categoryUpdate(Request $request,$id)
    {
        /*$validated = $request->validate([
            'status' => 'require',
        ]);*/

        try {
            $data = Category::find($id);
            if($request->hasFile('profile_pic')){
                UpdateImageAllSizes($request, 'advertise/', $data->image);
                $path = 'advertise/'.$request->profile_pic->hashName();
            }
            if ($data) {
                DB::beginTransaction();
                $cat_data = [
                    'status' => $request->status,
                    'image' => !empty($path) ? $path : $data->image,
                ];
                $data->update($cat_data);
                DB::commit();
                return redirect(route('cat_list'))->with('success', 'Interest updated successfully.');
                //return Redirect::back()->with('success', 'Interest updated successfully.');
            } else {
                return Redirect::back()->withErrors(['Sorry Record not found.']);
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['Sorry Record not found.']);
        }
    }
    /**
     * Interest delete.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function categorydelete($id)
    {
        try {
            $data = Category::find($id);
            if ($data) {
                $data->delete();
                return redirect(route('cat_list'))->with('success', 'Interest deleted successfully.');
            } else {
                return Redirect::back()->withErrors(['Sorry Record not found.']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors('Sorry record not found.');
        }
    }
    /**
     *  Save category
     * @param Request $request
     * @return mixed
     */
    public function advertiseSave(Request $request)
    {
        $validated = $request->validate([
            'image' => 'mimes:mp4,mov,ogg,qt,flv,m3u8,3gp,mov,avi,wmv | max:20000'
        ]);
        $data = AdveriseWithUs::find($request->id);
        $videourl = "";
        if($request->hasFile('image')){
            $video = $request->file('image');
            $fiel_name = $request->file('image')->getClientOriginalName();
            $vimeo = Vimeo::upload($video,[
                "name" => $fiel_name,
                "description" => "This video for AppOne "
                ]);
            $videourl = str_replace('/videos/', '', $vimeo); //it contains vimeo id
        }
        try {
            DB::beginTransaction();
            $cat_data = [
                'image' => !empty($videourl) ? $videourl : $data->image,
            ];
            if ($data) {
                $data->update($cat_data);
            } else{
                AdveriseWithUs::create($cat_data);
            }
            DB::commit();
            return redirect(route('advertise'))->with('success', 'Advertise updated successfully.');

        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['server error']);
        }
    }
    /**
     * category List.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function advertise()
    {
        try {
            $data = AdveriseWithUs::find(1);
            return view('admin.extras.advertise.create',compact('data'));
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors('Sorry record not found.');
        }
    }

    /**
     * category List.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function topics()
    {
        try {
            $keword = \request('keyword');
            $date = \request('date');
            $data = Topic::search($keword)->dateFilter($date)->whereNull('deleted_at')->withCount('post as count')->orderBy('id','desc')->paginate(10);
            if ($data) {
                return view('admin.extras.topics.list', compact('data'));
            } else {
                return Redirect::back()->withErrors(['Sorry Record not found.']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors('Sorry record not found.');
        }
    }

    /**
     * category create.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function topicCreate()
    {
        try {
            return view('admin.extras.topics.create');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors('Sorry record not found.');
        }
    }

    /**
     *  Save category
     * @param Request $request
     * @return mixed
     */
    public function topicSave(Request $request)
    {
        $validated = $request->validate([
            'name' => 'unique:topics',
        ]);

        if($request->hasFile('image')){
            SaveImageAllSizes($request, 'advertise/');
            $path = 'advertise/'.$request->image->hashName();
        }
        try {
            DB::beginTransaction();
            $cat_data = [
                'name' => $request->name,
                'status' => $request->status,
                'image' => !empty($path) ? $path : "",
            ];
            Topic::create($cat_data);
            DB::commit();
            return redirect(route('topic_list'))->with('success', 'Topic added successfully.');

        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['server error']);
        }
    }

    /**
     * Interest Detail.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function topicEdit($id)
    {
        try {
            $data = Topic::find($id);
            if ($data) {
                return view('admin.extras.topics.detail', compact('data'));
            } else {
                return Redirect::back()->withErrors(['Sorry Record not found']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors('Sorry record not found.');
        }
    }
    /**
     *  Save category
     * @param Request $request
     * @return mixed
     */
    public function topicUpdate(Request $request,$id)
    {

        try {
            $data = Topic::find($id);
            if($request->hasFile('profile_pic')){
                UpdateImageAllSizes($request, 'advertise/', $data->image);
                $path = 'advertise/'.$request->profile_pic->hashName();
            }
            if ($data) {
                DB::beginTransaction();
                $cat_data = [
                    'status' => $request->status,
                    'image' => !empty($path) ? $path : $data->image,
                ];
                $data->update($cat_data);
                DB::commit();
                return redirect(route('topic_list'))->with('success', 'Topic updated successfully.');
                //return Redirect::back()->with('success', 'Interest updated successfully.');
            } else {
                return Redirect::back()->withErrors(['Sorry Record not found.']);
            }

        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['Sorry Record not found.']);
        }
    }

    /**
     * Interest Delete.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function topicDelete($id)
    {
        try {
            $data = Topic::find($id);
            if ($data) {
                $data->delete();
                return redirect(route('topic_list'))->with('success', 'Topic deleted successfully.');
            } else {
                return Redirect::back()->withErrors(['Sorry Record not found.']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('home'))->withErrors('Sorry record not found.');
        }
    }

    /**
     * test Notification.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function testNotification()
    {
        try {
            $data = PushNotification::whereStatus('pending')->get();
            if ($data) {
                foreach ($data as $notification) {
                    $from = \Carbon\Carbon::now()->subYears($notification->age_from)->format('Y-m-d');
                    $to = Carbon::now()->subYears($notification->age_to)->format('Y-m-d');
                    $user = User::select('id','name','email','user_type','gender','date_of_birth','device_token')
                        ->whereUserType('user')->whereGender($notification->gender)->whereBetween('date_of_birth', [$to,$from])->get();
                    if ($user) {
                        $title = $notification->title;
                        $message_body = $notification->message;
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
            }
        } catch ( \Exception $e) {
            DB::rollBack();
            return Redirect::back()->withErrors(['Sorry Record not found.']);
        }
    }
}
