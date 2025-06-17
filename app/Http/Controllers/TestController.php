<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Contracts\EmailInterface;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use App\Contracts\NotificationServiceInterface;

class TestController extends Controller
{
    protected $emailInterface;

    public function __construct(EmailInterface $emailInterface)
    {
        $this->emailInterface = $emailInterface;
    }

    public function sendMail()
    {
        $this->emailInterface->send(["to" => "eng.ahmed0302@gmail.com", "username" => "Ahmed Ebrahim"]);
        return "done";
    }

    public function users(Request $request)
    {

        Cookie::queue('user_id', 1, 60 * 24 * 30); // 30 days
        return $request->cookie('user_id');
        // $users = Cache::flexible("users", [20, 30], function ()  {
        //     User::get();
        //     User::get();
        //     User::get();
        //     User::get();
        //     User::get();

        //     sleep(2);
        //     return User::inRandomOrder()->get();
        // });

        // return view('users', compact('users'));




    }
    public function test()
    {
        $users=Cache::get("users");
        return $users;
    }
}
