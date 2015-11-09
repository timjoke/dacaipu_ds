<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

/**
 * Customer 的注释
 *
 * @作者 roy
 */
class Customer extends Eloquent implements UserInterface
{
    use UserTrait;
    protected $table = 'customer';
    
    protected $primaryKey = 'customer_id';
    protected $username = 'customer_name';
    public $timestamps = false;
    /**
    * The attributes excluded from the model's JSON form.
    *
    * @var array
    */
    protected $hidden = array('customer_pwd',);
    
    protected $fillable = array('customer_name','customer_mobile','customer_email','customer_pwd');
    
    protected $guarded = array('customer_pwd');
}
