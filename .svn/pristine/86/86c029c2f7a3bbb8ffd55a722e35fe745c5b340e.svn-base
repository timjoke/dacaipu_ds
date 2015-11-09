<?php
use Business\busOrderds;
/**
 * OrderController 的注释
 *
 * @作者 roy
 */
class OrderController extends BaseController
{

    /**
     * 获得今日订单
     * @return array
     */
    public function new_orders_json()
    {
        $ods = array();
        $orders = Order::getWaitProcessOrders($this->dealer->dealer_id);

        foreach ($orders as $order)
        {
            $products = OrderDishFlash::where('order_id', '=', $order->order_id)->get();
            $order->products = $products;
            $order->express_fee = $this->dealer->dealer_express_fee;

            $order_dis = OrderDiscount::where('order_id', '=', $order->order_id)->get();
            $order->discount = $order_dis;

            $coupon = Coupon::where('order_id', '=', $order->order_id)->first();
            $order->coupon = $coupon;

            $msg = OrderStatusMessage::where('order_id', '=', $order->order_id)
                    ->where('cur_order_status', '=', 2)
                    ->first();

            $order->memo = $msg->memo;

            array_push($ods, $order);
        }

        return $ods;
    }

    public function new_orders()
    {
        //\Debugbar::disable();
        
        return View::make('orders.newlist');
    }

    public function change_order_status()
    {
        $result = new stdClass();
        $order_id = Input::get('order_id');
        $order_status = Input::get('order_status');
        $new_status = Input::get('new_status');

        $reason = Input::get('reason', '');
        if($new_status == 4 && empty($reason))
        {
            $result->code = -2;
            $result->msg = 'reason is must.';
            return json_encode($result);
        }
        
        $order = Order::find($order_id);
        

        if (empty($order))
        {
            $result->code = -1;
            $result->msg = 'order not exist';
            return json_encode($result);
        }

        if ($order_status != $order->order_status)
        {
            $result->code = -1;
            $result->msg = '该订单已被处理，请刷新！';
            return json_encode($result);
        }

        try
        {
            DB::beginTransaction();

            $order->order_status = $new_status;
            $order->update();

            $osm = new OrderStatusMessage();
            $osm->order_id = $order->order_id;
            $osm->cur_order_status = $new_status;
            $osm->memo = $reason;
            $osm->modifier_id = Auth::user()->cusetomer_id;
            $osm->save();
            
            if($new_status == 4)
            {
                $products = OrderDishFlash::where('order_id','=',$order_id)->get();
                foreach($products as $product)
                {
                    $dish = Product::find($product->dish_id);
                    $dish->dish_count = $dish->dish_count + $product->order_count;
                    $dish->update();
                }
            }

            $notice_obj = new stdClass();
            $notice_obj->order_id = $order_id;
            $notice_obj->reason = $reason;
            
            $bo = new busOrderds();
            $bo->order_status_notice($notice_obj);
            
            DB::commit();
            
            $result->code = 0;
            return json_encode($result);
        } 
        catch (Exception $e)
        {
            DB::rollBack();
            Log::debug($e->getLine() . $e->getMessage());
            Log::debug($e->getTraceAsString());
            $result->code = -1;
            $result->msg = $e->getMessage();

            return json_encode($result);
        }
    }

    public function history_orders_json()
    {
        $page = Input::get('page',1);
        $start = ($page - 1) * 10 + 1;
        
        $result = Order::getHistoryOrders($this->dealer->dealer_id, $start);
        $ods = array();
        foreach ($result->list as $order)
        {
            $products = OrderDishFlash::where('order_id', '=', $order->order_id)->get();
            $order->products = $products;
            $order->express_fee = $this->dealer->dealer_express_fee;

            $order_dis = OrderDiscount::where('order_id', '=', $order->order_id)->get();
            $order->discount = $order_dis;

            $coupon = Coupon::where('order_id', '=', $order->order_id)->first();
            $order->coupon = $coupon;

            $msg = OrderStatusMessage::where('order_id', '=', $order->order_id)
                    ->where('cur_order_status', '=', 2)
                    ->first();

            $order->memo = $msg->memo;

            array_push($ods, $order);
        }
        
        $result->list = $ods;
        return json_encode($result);
    }
    
    public function history_orders()
    {
        return View::make('orders.historylist');
    }

}
