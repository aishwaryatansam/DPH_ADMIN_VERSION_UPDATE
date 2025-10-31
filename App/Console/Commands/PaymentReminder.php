<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Mail;
use App\Mail\PaymentReminderMail;

class PaymentReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment:reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command will trigger payment reminder mails.';

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
        $users = User::getPaymentPendingUsers();

        foreach($users as $user){
            if($user->payments->isEmpty() || $user->payments->whereIn('status', [0,2])->count() > 0){
                Mail::to($user->email)->cc(config('constants.error_catch_mail'))->send(new PaymentReminderMail($user));
            }
        }

        return Command::SUCCESS;
    }
}
