<?php


namespace app\models;


use app\core\Model;

class ContactForm extends Model
{

    public string $subject = '';
    public string $email = '';
    public string $message = '';

    public function rules()
    {
        return[
            'subject' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED],
            'message' => [self::RULE_REQUIRED],
        ];
    }

    public function labels(): array
    {
        return [
          'subject' => 'Enter your subject',
          'email' => 'Your email',
          'message' => 'Body',
        ];
    }

    public function send()
    {
        return true;
    }

}