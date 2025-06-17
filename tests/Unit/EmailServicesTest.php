<?php

namespace Tests\Unit;

use Tests\TestCase; // ✅ Laravel's base TestCase
use App\Mail\WelcomeMail;
use App\Services\EmailServices;
use Illuminate\Support\Facades\Mail;

class EmailServicesTest extends TestCase
{
    public function test_email_service_sends_emails()
    {
        // Prevent real emails
        Mail::fake();

        $data = [
            'to' => 'test@gmail.com',
            'username' => 'Ahmed Ebrahim'
        ];

        // استخدم الخدمة الحقيقية
        $service = new EmailServices();
        $result = $service->send($data);

        // نتأكد من الإرسال
        Mail::assertQueued(WelcomeMail::class); // 4 مرات queue

        $expected="Email sent to " . $data['username'] ;
        // نتأكد من نتيجة الدالة
        $this->assertEquals($expected, $result);
    }
}
