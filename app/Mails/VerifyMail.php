<?php

namespace App\Mails;

class VerifyMail extends BaseMail
{
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return void
     */
    public function build()
    {
        return $this->to($this->user->email)
            ->subject('This is subject of verify email')
            ->body('users.verifyMail');
    }
}
