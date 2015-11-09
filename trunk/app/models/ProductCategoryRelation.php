<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * ProductCategoryRelation 的注释
 *
 * @作者 roy
 */
class ProductCategoryRelation extends Eloquent
{

    protected $table = 'dish_category_relation';
    protected $primaryKey = 'dr_id';
    public $timestamps = false;

}
