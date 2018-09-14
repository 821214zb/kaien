<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
//use Illuminate\Foundation\Bus\Dispatchable;Dispatcher;
use Illuminate\Support\Facades\Mail;
class SendEmail implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($m3_email)
    {
        $this->user = $m3_email;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        //sleep(4);
        $m3_email = $this->user;
        Mail::send('email_register', ['m3_email' => $m3_email], function ($m) use ($m3_email) {
            // $m->from('hello@app.com', 'Your Application');
            $m->to($m3_email->to, '尊敬的用户')
                ->cc($m3_email->cc)
                ->subject($m3_email->subject);
        });


//
//        Mail::raw('这里填写邮件的内容',function ($message){
//            // 发件人（你自己的邮箱和名称）
//            $message->from('your_email@163.com', 'yourname');
//            // 收件人的邮箱地址
//            $message->to($this->user);
//            // 邮件主题
//            $message->subject('队列发送邮件');
//        });
    }
}
