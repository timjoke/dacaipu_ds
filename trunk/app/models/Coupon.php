<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Coupon 的注释
 *
 * @作者 roy
 */
class Coupon extends Eloquent
{
    protected $table = 'coupon';
    protected $primaryKey = 'coupon_id';
    public $timestamps = false;
}
