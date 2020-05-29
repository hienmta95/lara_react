<?php

namespace App\Mails;

class ResetPasswordMail extends BaseMail
{
    public $passwordReset;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($passwordReset)
    {
        $this->passwordReset = $passwordReset;
    }

    /**
     * Build the message.
     *
     * @return void
     */
    public function build()
    {
        return $this->to($this->passwordReset->email)
            ->subject(__('mails.reset_password.subject'))
            ->body('users.resetPasswordMail');
    }
}
