<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class PushNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will send schedulled notification sending from Admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = \App\Models\PushNotification::whereStatus('pending')->get();
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
    }
}
