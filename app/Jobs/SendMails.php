<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 任务最大尝试次数。
     *
     * @var int
     */
    public $tries = 2;

    /**
     * 任务运行的超时时间。
     *
     * @var int
     */
    public $timeout = 30;

    private $to;

    private $mailContent;

    private $mailTitle;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($to = "", $mailContent = "", $mailTitle = "")
    {
       $this->to = $to;
       $this->mailContent = $mailContent;
       $this->mailTitle = $mailTitle;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $to = $this->to;
        $mailContent = $this->mailContent;
        $mailTitle = $this->mailTitle;
        // 开始发送
        Mail::send(['html' => 'emails.mail'], ['body' => $mailContent], function ($message) use ($to, $mailTitle){
            $message->to($to)->subject($mailTitle);
        });
    }
}
