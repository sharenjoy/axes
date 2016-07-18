<?php namespace Sharenjoy\Cmsharenjoy\Service\Notification;

use Services_Twilio;
use Config;

class TwilioSmsNotification implements NotificationInterface {

    /**
     * Recipient of notification
     * @var string
     */
    protected $to;

    /**
     * Sender of notification
     * @var string
     */
    protected $from;

    /**
     * Twilio SMS SDK
     * @var \Services_Twilio
     */
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Services_Twilio(
            Config::get('twilio.account_id'),
            Config::get('twilio.auth_token')
        );

        $this->from(Config::get('twilio.from'));
    }

    /**
     * Recipients of notification
     * @param  string $to The recipient
     * @return Impl\Service\Notification\SmsNotification  $this  Return self for chainability
     */
    public function to($to)
    {
        $this->to = $to;

        return $this;
    }

    /**
     * Sender of notification
     * @param  string $from The sender
     * @return Impl\Service\Notification\NotificationInterface  $this  Return self for chainability
     */
    public function from($from)
    {
        $this->from = $from;

        return $this;
    }

    public function notify($subject, $message)
    {
        $sms = $this->twilio
            ->account
            ->messages
            ->sendMessage(
                $this->from,
                $this->to,
                $subject."\n".$message
            );
    }

}