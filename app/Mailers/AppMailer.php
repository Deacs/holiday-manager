<?php  namespace App\Mailers; 

use App\User;
use Illuminate\Contracts\Mail\Mailer;

class AppMailer
{
    protected $mailer;

    protected $from = 'admin@application.com';

    protected $to;

    protected $view;

    protected $data = [];

    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendConfirmationRequestEmail(User $user)
    {
        $this->to   = $user->email;
        $this->view = 'emails.account-confirm';
        $this->data = compact('user');

        $this->deliver();
    }

    public function deliver()
    {
        $this->mailer->send($this->view, $this->data, function($message) {
            $message->from($this->from, 'Administrator')
                    ->to($this->to);
        });
    }
}
