<?php

namespace App\Service\Sms;



/**
 * This is the virtual sending class for SMS
 * It doesn't really do anything
 */
class TestSender implements SmsSender {

    private $messages = [];

    public function send($message, $phone) {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        $this->messages[] = ['phone' => $phone, 'message' => $message];
        return true;
    }

    public function getMessages() {
        return $this->messages;
    }
}