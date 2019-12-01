<?php

namespace App\Jobs;

use App\Models\Emailtpl;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * 任务最大尝试次数。
     *
     * @var int
     */
    public $tries = 5;

    /**
     * 任务运行的超时时间。
     *
     * @var int
     */
    public $timeout = 30;

    private $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->order['sitename'] = config('SYS_NAME');
        $this->order['siteurl'] = config('H5_URL');
        Log::debug('邮件配置', config('mail'));
        // 发送邮箱给用户
        $mailtipsArr = Emailtpl::where('tpl_token', '=', 'card_send_mail')->get()->toArray();
        $to = $this->order['rcg_account'];
        $mailtipsInfo = replace_mail_tpl($mailtipsArr[0], $this->order);
        // 开始发送
        Mail::send(['html' => 'emails.mail'], ['body' => $mailtipsInfo['tpl_content']], function ($message) use ($mailtipsInfo, $to){
            $message->to($to)->subject($mailtipsInfo['tpl_name']);
        });
        return;
    }

    /**
     * 要处理的失败任务。
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(\Exception $exception)
    {
        // 给用户发送失败通知，等等...
        dump($exception->getMessage());
    }
}
