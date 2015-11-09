<?php

namespace Business;

/**
 * 电商下单相关业务
 * @作者 roy
 */
class busOrderds
{

    /**
     * 
     * @param type $result
     * $result->order_id 订单id；
     * $result->reason 订单拒绝原因；
     * @return type
     */
    public function order_status_notice($result)
    {
        $bs = new busSms();
        $order = \Order::find($result->order_id);

        if (!isset($order))
        {
            Log::info('订单状态通知失败：订单不存在。订单号:' . $result->order_id);
            return false;
        }

        $dealer = \Dealer::find($order->dealer_id);
        $order_status = $order->order_status;
        $contact = \Contact::find($order->contact_id);

        $msg = '';
        if ($order->order_type == 1)
        {
            switch ($order_status)
            {
                /*
                 * 等待付款
                 */
                case 1:
                    {
                        
                    }
                    break;
                /*
                 * 等待处理
                 */
                case 2:
                    {
                        
                    }
                    break;
                /*
                 * 处理中 
                 */
                case 3:
                    {
                        $msg = sprintf("您的订单【订单号：%s】已开始备货！", $result->order_id);
                    }
                    break;
                /*
                 * 已拒绝
                 */
                case 4:
                    {
                        $msg = sprintf("非常抱歉，您的订单【订单号：%s】被店家拒绝了,拒绝原因是 %s", $result->order_id, $result->reason);
                    }
                    break;
                /*
                 * 等待配送
                 */
                case 5:
                    {
                        $msg = sprintf("您的订单【订单号：%s】备货完毕，准备配送！", $result->order_id);
                    }
                    break;
                /*
                 * 等待自取
                 */
                case 6:
                    {
                        $msg = sprintf("您的订单【订单号：%s】已备货完毕，请尽快来取货！", $result->order_id);
                    }
                    break;
                /*
                 * 配送中
                 */
                case 7:
                    {
                        $msg = sprintf("您的订单【订单号：%s】已在配送途中，请准备收货！", $result->order_id);
                    }
                    break;
                /*
                 * 完成订单
                 */
                case 8:
                    {
                        //$msg = sprintf("您的订单【订单号：%s】已完成，感谢您的支持！", $result->order_id);
                    }
                    break;
                /*
                 * 订单结束
                 */
                case 9:
                    {
                        
                    }
                    break;
                default:
                    break;
            }
        }
        else if ($order->order_type == 2)
        {
            switch ($order_status)
            {
                /*
                 * 等待付款
                 */
                case 1:
                    {
                        
                    }
                    break;
                /*
                 * 等待处理
                 */
                case 2:
                    {
                        
                    }
                    break;
                /*
                 * 处理中 
                 */
                case 3:
                    {

                        $msg = sprintf("您的订单【订单号：%s】已开始备货,请于%s到%s自取。地址：%s,电话：%s。", $result->order_id, date("Y年m月d日 H点i分", strtotime($order->order_dinnertime)), $dealer->dealer_name, $dealer->dealer_addr, $dealer->dealer_tel);
                    }
                    break;
                /*
                 * 已拒绝
                 */
                case 4:
                    {
                        $msg = sprintf("非常抱歉，您的订单【订单号：%s】被店家拒绝了,拒绝原因是 %s", $result->order_id, $result->reason);
                    }
                    break;
                /*
                 * 完成订单
                 */
                case 8:
                    {
                        //$msg = sprintf("您的订单【订单号：%s】已完成，感谢您的支持！", $result->order_id);
                    }
                    break;
                /*
                 * 订单结束
                 */
                case 9:
                    {
                        
                    }
                    break;
                default:
                    break;
            }
        }
        

        if (!empty($msg))
        {
            $bs->send($contact->contact_tel, $msg, $dealer->dealer_name);
        }

        return true;
    }
}
