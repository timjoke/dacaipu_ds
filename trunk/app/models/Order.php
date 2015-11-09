<?php

/**
 * order 的注释
 *
 * @作者 roy
 */
class Order extends Eloquent
{

    protected $table = 'orders';
    protected $primaryKey = 'order_id';
    public $timestamps = false;

    /**
     * 获取待处理订单
     * @param type $dealer_id
     * @return type
     */
    public static function getWaitProcessOrders($dealer_id)
    {
        $sql = 'SELECT
            orders.order_id,
            orders.order_paid,
            orders.order_dinnertime,
            orders.order_type,
            orders.order_createtime,
            orders.order_status,
            contact.contact_addr,
            contact.contact_name,
            contact.contact_tel,
            (
                    SELECT
                            SUM(order_count)
                    FROM
                            order_dish_flash
                    WHERE
                            order_dish_flash.order_id = orders.order_id
            ) AS dish_count
            
            FROM
                    orders
            INNER JOIN contact ON orders.contact_id = contact.contact_id
            WHERE orders.order_type in (1,2) and orders.order_status in (2,3,5,6,7) and orders.dealer_id=:dealer_id';

        $list = DB::select($sql, array(':dealer_id' => $dealer_id));
        return $list;
    }

    
    public static function getHistoryOrders($dealer_id, $start)
    {
        $sql = 'SELECT
                count(1) as rows
        FROM
                orders
        INNER JOIN contact ON orders.contact_id = contact.contact_id
        where orders.order_type in (1,2)  and orders.dealer_id=:dealer_id and orders.order_status in (8,9)';
        
        $total_count = DB::selectOne($sql, array(':dealer_id' => $dealer_id))->rows;
        
        
        $sql = 'SELECT
                orders.order_id,
            orders.order_paid,
            orders.order_dinnertime,
            orders.order_type,
            orders.order_createtime,
            orders.order_status,
            contact.contact_addr,
            contact.contact_name,
            contact.contact_tel,
                (
                        SELECT
                                SUM(order_count)
                        FROM
                                order_dish_flash
                        WHERE
                               order_dish_flash.order_id = orders.order_id
                ) AS dish_count
        FROM
                orders
        INNER JOIN contact ON orders.contact_id = contact.contact_id
        where orders.order_type in (1,2)  and orders.dealer_id=:dealer_id and orders.order_status in (8,9) order by orders.order_id desc limit ' . $start . ',10';


        $list = DB::select($sql, array(':dealer_id' => $dealer_id));
        $result = new stdClass();
        $result->total_count = $total_count;
        $result->list = $list;
        return $result;
    }

}
