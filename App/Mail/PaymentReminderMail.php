<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Support\Str;

class PaymentReminderMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $hashedId = base64_encode($this->user->id);
        $paymentToken = Str::random(10);
        User::find($this->user->id)->update([
            'payment_reminded_at' => now(),
            'payment_token' => $paymentToken
        ]);
        $paymentLink = config('constants.website_domain').'/initiate-payment/'.$hashedId.'/'.$paymentToken;

        return $this->view('emails.payment_reminder')
                    ->subject("DPHICON2022 - Payment Reminder")
                    ->with([
                        'user' => $this->user,
                        'paymentLink' => $paymentLink,
                    ]);
    }
}
