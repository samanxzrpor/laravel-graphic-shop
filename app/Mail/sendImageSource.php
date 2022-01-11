<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class sendImageSource extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(private array $images , private User $user)
    {
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $email = $this->view('mail.sendImage')
                ->with(['user' => $this->user]);
        foreach ($this->images as $image)
        {
            $email->attach(storage_path('app/uploads/' . $image));
        }

        return $email;
    }
}
