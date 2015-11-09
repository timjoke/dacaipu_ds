<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * OrderDiscount 的注释
 *
 * @作者 roy
 */
class OrderDiscount extends Eloquent
{
    protected $table = 'order_discount';
    protected $primaryKey = 'ao_id';
    
    public $timestamps = false;
}
