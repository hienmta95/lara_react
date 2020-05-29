<?php

namespace App\Services\User;

use App\Mails\VerifyMail;
use App\Repositories\User\UserRepositoryInterface;
use App\Services\BaseService;
use App\Services\Mailer\MailerService;

class RegisterService extends BaseService
{
    private $userRepository;
    private $mailer;

    public function __construct(UserRepositoryInterface $userRepository, MailerService $mailer)
    {
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
    }

    /**
     * @param $request
     * @return array
     */
    public function handle($request)
    {
        $request['is_verify'] = 1;
        $request['verify_token'] = \App\Models\User::generateVerifyToken();
        $user = $this->userRepository->create($request);
        if (!$user) return $this->responseStatus('Register user failed.');

        // Send mail to verify
        $this->sendMail($user);

        return $this->responseStatus('Register ok.', self::SUCCESS, $user);
    }

    /**
     * @param $user
     */
    public function sendMail($user)
    {
        $mail = new VerifyMail($user);
        $this->mailer->handle($mail);
    }
}
