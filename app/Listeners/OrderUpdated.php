<?php

namespace App\Listeners;

use App\Jobs\MailSend;
use App\Models\Emailtpl;
use App\Models\Order;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\OrderUpdated as OrderUpdatedEvent;

class OrderUpdated
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderUpdatedEvent $event)
    {
        $sysCache = cache('system-setting');
        // 当代充商品状态，将会对顾客进行订单内容推送
        $order = [
            'created_at' => date('Y-m-d H:i'),
            'ord_title' => $event->order->title,
            'webname' => $sysCache['text_logo'] ?? '独角数卡',
            'weburl' => config('app.url'),
            'order_id' => $event->order->order_sn,
            'ord_price' => $event->order->actual_price,
            'ord_info' => str_replace(PHP_EOL, '<br/>', $event->order->info)
        ];
        $to = $event->order->email;
        // 邮件
        if ($event->order->type == Order::MANUAL_PROCESSING) {
            switch ($event->order->status) {
                case Order::STATUS_PENDING:
                    $mailtpl = Emailtpl::query()->where('tpl_token', 'pending_order')->first()->toArray();
                    self::sendMailToOrderStatus($mailtpl, $order, $to);
                    break;
                case Order::STATUS_COMPLETED:
                    $mailtpl = Emailtpl::query()->where('tpl_token', 'completed_order')->first()->toArray();
                    self::sendMailToOrderStatus($mailtpl, $order, $to);
                    break;
                case Order::STATUS_FAILURE:
                    $mailtpl = Emailtpl::query()->where('tpl_token', 'failed_order')->first()->toArray();
                    self::sendMailToOrderStatus($mailtpl, $order, $to);
                    break;
            }
        }
    }


    /**
     * 邮件发送
     *
     * @param array $mailtpl 模板
     * @param array $order 内容
     * @param string $to 接受者
     *
     * @author    assimon<ashang@utf8.hk>
     * @copyright assimon<ashang@utf8.hk>
     * @link      http://utf8.hk/
     */
    private static function sendMailToOrderStatus(array $mailtpl, array $order, string $to) :void
    {
        $info = replace_mail_tpl($mailtpl, $order);
        MailSend::dispatch($to, $info['tpl_name'], $info['tpl_content']);
    }
}
