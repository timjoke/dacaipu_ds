<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

//Route::match(array('GET','POST'),'/', 'HomeController@Login');


Route::get('/',function()
{
    if(!Auth::check())
    {
        return View::make('home.login');
    }
    else
    {
        return Redirect::to('new_orders');
    }
});
Route::match(array('GET','POST'),'/login', array('as' => 'login', 'uses' => 'HomeController@Login'));
Route::get('logout', 'HomeController@logout');
Route::group(array('before' => 'auth',), function()
{
    /*
    Route::get('/', array('as' => '/', function(){
        return Redirect::to('new_orders');
    }));
     * 
     */
    
    Route::get('new_orders.json', 'OrderController@new_orders_json');
    Route::get('new_orders', 'OrderController@new_orders');
    Route::get('history_orders.json', 'OrderController@history_orders_json');
    Route::get('history_orders', 'OrderController@history_orders');
    Route::post('change_order_status', 'OrderController@change_order_status');
    
    Route::get('category', 'ProductController@product_category');
    Route::post('change_category_status','ProductController@change_category_status');
    Route::post('save_category','ProductController@save_category');
    
    Route::post('product_paged_list','ProductController@product_paged');
    
    Route::get('product','ProductController@product');
    
    Route::post('save_product','ProductController@save_product');
    
    Route::post('product_item.json', 'ProductController@product_item_json');
    
    Route::post('add_product','ProductController@add_product');
    
    Route::post('change_product_status','ProductController@change_product_status');
});

Route::post('product_img', 'ProductController@upload_product_img');

Route::get('flushcache', function(){
    Cache::flush();
});
