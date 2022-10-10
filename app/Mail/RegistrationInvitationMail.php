<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegistrationInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('notifications::registration_invitation',
            [
                'message' => 'Jūs esat ielūgts reģistrēties ' . config('app.name') . '!',
                'actionText' => 'Reģistrēties',
                'actionUrl' => route('register.create', ['token' => $this->token]),
                'displayableActionUrl' => route('register.create', ['token' => $this->token]),
            ])->subject('Ielūgums no ' . config('app.name'));
    }
}
