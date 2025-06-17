<?php 
namespace App\Services;

use App\Mail\WelcomeMail;
use App\Contracts\EmailInterface;
use Illuminate\Support\Facades\Mail;

class EmailServices implements EmailInterface{
    public function send(array $data)
    {

        Mail::to($data['to'])->queue(new WelcomeMail($data));
        return "Email sent to " . $data['username'];
    }
}