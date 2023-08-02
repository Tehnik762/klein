<?php

namespace App\Service\Sms;



/**
 * This is the virtual sending class for SMS
 * It doesn't really do anything
 */
class VirtualSender implements SmsSender {


    public function send($message, $phone) {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        session(['message' => $message, 'phone' => $phone]);
        return true;

    }
}