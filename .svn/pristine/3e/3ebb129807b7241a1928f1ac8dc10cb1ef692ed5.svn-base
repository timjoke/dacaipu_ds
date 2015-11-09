<?php

/**
 * Dish 的注释
 *
 * @作者 roy
 */
class Product extends Eloquent
{

    protected $table = 'dish';
    protected $primaryKey = 'dish_id';
    public $timestamps = false;
    
    /**
     * 获取菜品列表信息，包含菜品图片
     * @return type
     */
    public static function getProducts($dealer_id, $category_id = 0, $product_name = null)
    {
        $query = DB::table(('dish'))
                ->leftJoin('pic', 'dish.dish_id', '=', 'pic.entity_id')
                ->where('pic.pic_type', '=',2)
                ->leftJoin('dish_category_relation AS dcr', 'dish.dish_id', '=', 'dcr.dish_id')
                ->join('dish_category as dc','dc.category_id' ,'=', 'dcr.category_id')
                ->where('dish.dealer_id', '=', $dealer_id);

        if (!empty($product_name))
        {
            $query = $query->where('dish.dish_name','like',"%$product_name%");
            $query = $query->orWhere('dish.dish_jianpin','like',"$product_name%");
            $query = $query->orWhere('dish_quanpin','like',"$product_name%");
        }
        
        if ($category_id != 0)
        {
            $query = $query->where('dcr.category_id','=',"$category_id");
        }
        
        $list = $query->orderBy(DB::raw('(dish.dish_count - dish.alert_count)'))
                ->orderBy('dish.dish_jianpin')
                ->select(array(
                    'pic.pic_url',
                    'dc.category_name',
                    'dish.dish_id',
                    'dish.dish_name',
                    'dish.dish_price',
                    'dish.dish_count',
                    'dish.dish_recommend',
                    'dish.dish_package_fee',
                    'dish.dish_is_vaget',
                    'dish.dish_spicy_level',
                    'dish.dish_introduction',
                    'dish.dealer_id',
                    'dish.dish_status',
                    'dish.dish_createtime',
                    'dish.dish_mode',
                    'dish.dish_parent_id',
                    'dish.dish_modifytime',
                    'dish.is_presell',
                    'dish.alert_count',
                    'dish.is_presell'))
                    ->paginate();
        
        //print_r(DB::getQueryLog());
        return $list;

    }

}
