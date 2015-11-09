<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Dealer 的注释
 *
 * @作者 roy
 */
class Dealer extends Eloquent
{
    protected $table = 'dealer';
    
    protected $primaryKey = 'dealer_id';
    
    public static function getByCustomerId($customer_id)
    {
        $dealer_id = DB::table('dealer_customer')
                ->where('customer_id', '=',$customer_id)
                ->where('dc_relat_type','=', 1)
                ->select('dealer_id')
                ->first()->dealer_id;
        
        return Dealer::find($dealer_id);
    }
}
