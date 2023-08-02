<?php
namespace App\Service\Sms;


interface SmsSender {

    /**
     * @param string $message
     * @param string $text
     * 
     * @return [type]
     */
    public function send($message, $text);

}