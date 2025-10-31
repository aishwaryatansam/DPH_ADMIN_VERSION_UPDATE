<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Submission;
use Illuminate\Support\Str;

class AbstractApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $abstract;

    public function __construct(Submission $abstract)
    {
        $this->abstract = $abstract;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('emails.abstract_approved')
                    ->subject("DPHICON2022 - Notification Mail")
                    ->with([
                        'abstract' => $this->abstract,
                    ]);
    }
}
